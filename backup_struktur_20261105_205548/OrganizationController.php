<?php

namespace App\Http\Controllers;

use App\Models\Member;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;

class OrganizationController extends Controller
{
    private const BANOMS = [
        'IPNU' => 'IPNU (Putra)',
        'IPPNU' => 'IPPNU (Putri)',
        'Ansor' => 'GP Ansor / Banser',
        'Fatayat' => 'Fatayat NU',
        'Muslimat' => 'Muslimat NU',
    ];

    // Tidak mengubah struktur tabel. Foto disimpan berdasarkan ID jabatan.
    private const PHOTO_DIRECTORY = 'organization-positions';
    private const PHOTO_EXTENSIONS = ['jpg', 'jpeg', 'png', 'webp'];

    private static function canonicalBanom(?string $value): ?string
    {
        $text = preg_replace('/[^a-z]+/', '', mb_strtolower(trim((string) $value)));
        if (str_contains($text, 'ippnu')) return 'IPPNU';
        if (str_contains($text, 'ipnu')) return 'IPNU';
        if (str_contains($text, 'ansor') || str_contains($text, 'banser')) return 'Ansor';
        if (str_contains($text, 'fatayat')) return 'Fatayat';
        if (str_contains($text, 'muslimat')) return 'Muslimat';
        return null;
    }

    private function approvedCounts(): array
    {
        $counts = array_fill_keys(array_keys(self::BANOMS), 0);
        $rows = Member::query()->where('status', 'approved')
            ->select('banom')->selectRaw('COUNT(*) as total')->groupBy('banom')->get();

        foreach ($rows as $row) {
            $key = self::canonicalBanom($row->banom);
            if ($key !== null) $counts[$key] += (int) $row->total;
        }
        return $counts;
    }

    private function photoUrl(int $id): ?string
    {
        $disk = Storage::disk('public');
        foreach (self::PHOTO_EXTENSIONS as $extension) {
            $path = self::PHOTO_DIRECTORY . '/position-' . $id . '.' . $extension;
            if ($disk->exists($path)) return $disk->url($path);
        }
        return null;
    }

    private function attachPhotoUrls($positions)
    {
        return $positions->map(function ($position) {
            $position->photo_url = $this->photoUrl((int) $position->id);
            $position->display_name = $position->member_name ?: ($position->person_name ?: 'Belum ditetapkan');
            return $position;
        });
    }

    public function index(): View
    {
        $counts = $this->approvedCounts();
        $allPositions = DB::table('organization_positions as p')
            ->leftJoin('members as m', 'm.id', '=', 'p.member_id')
            ->where('p.is_visible', true)
            ->select('p.*', 'm.name as member_name', 'm.status as member_status')
            ->orderBy('p.level')->orderBy('p.sort_order')->orderBy('p.id')->get()
            ->filter(fn ($item) => $item->member_id === null || $item->member_status === 'approved');
        $allPositions = $this->attachPhotoUrls($allPositions)->groupBy('banom');

        $banoms = [];
        foreach (self::BANOMS as $key => $label) {
            $banoms[$key] = [
                'label' => $label,
                'count' => $counts[$key],
                'positions' => ($allPositions->get($key) ?? collect())->values(),
            ];
        }
        return view('struktur-organisasi', compact('banoms'));
    }

    public function manage(Request $request): View
    {
        $this->ensureAdmin($request);
        $selected = $request->query('banom', 'IPNU');
        if (!is_string($selected) || !array_key_exists($selected, self::BANOMS)) $selected = 'IPNU';

        $positions = DB::table('organization_positions as p')
            ->leftJoin('members as m', 'm.id', '=', 'p.member_id')
            ->where('p.banom', $selected)
            ->select('p.*', 'm.name as member_name')
            ->orderBy('p.level')->orderBy('p.sort_order')->orderBy('p.id')->get();
        $positions = $this->attachPhotoUrls($positions);

        $members = Member::query()->where('status', 'approved')->orderBy('name')
            ->get(['id', 'name', 'banom'])
            ->filter(fn ($member) => self::canonicalBanom($member->banom) === $selected)->values();

        $counts = $this->approvedCounts();
        $banomLabels = self::BANOMS;
        return view('admin.struktur', compact('selected', 'positions', 'members', 'counts', 'banomLabels'));
    }

    public function store(Request $request): RedirectResponse
    {
        $this->ensureAdmin($request);
        $data = $this->validatedPosition($request);
        $id = DB::table('organization_positions')->insertGetId([
            ...$data, 'created_at' => now(), 'updated_at' => now(),
        ]);
        $this->savePhoto($request, (int) $id);
        return redirect()->route('admin.struktur.index', ['banom' => $data['banom']])
            ->with('success', 'Pengurus dan foto berhasil disimpan.');
    }

    public function update(Request $request, int $id): RedirectResponse
    {
        $this->ensureAdmin($request);
        abort_unless(DB::table('organization_positions')->where('id', $id)->exists(), 404);
        $data = $this->validatedPosition($request);
        DB::table('organization_positions')->where('id', $id)
            ->update([...$data, 'updated_at' => now()]);
        $this->savePhoto($request, $id);
        return redirect()->route('admin.struktur.index', ['banom' => $data['banom']])
            ->with('success', 'Data struktur dan foto berhasil diperbarui.');
    }

    public function destroy(Request $request, int $id): RedirectResponse
    {
        $this->ensureAdmin($request);
        $position = DB::table('organization_positions')->where('id', $id)->first();
        abort_if($position === null, 404);
        DB::table('organization_positions')->where('id', $id)->delete();
        $this->deletePhoto($id);
        return redirect()->route('admin.struktur.index', ['banom' => $position->banom])
            ->with('success', 'Jabatan beserta fotonya dihapus. Data anggota tetap aman.');
    }

    private function savePhoto(Request $request, int $id): void
    {
        if ($request->hasFile('photo')) {
            $photo = $request->file('photo');
            // Simpan foto baru dulu; apabila upload gagal, foto lama tidak dihapus.
            $extension = strtolower($photo->extension());
            if (!in_array($extension, self::PHOTO_EXTENSIONS, true)) {
                throw ValidationException::withMessages(['photo' => 'Format foto harus JPG, PNG, atau WEBP.']);
            }
            $path = self::PHOTO_DIRECTORY . '/position-' . $id . '.' . $extension;
            $stored = $photo->storeAs(self::PHOTO_DIRECTORY, 'position-' . $id . '.' . $extension, 'public');
            if (!$stored) {
                throw ValidationException::withMessages(['photo' => 'Foto gagal disimpan. Periksa penyimpanan server.']);
            }
            $this->deletePhoto($id, except: $path);
        } elseif ($request->boolean('remove_photo')) {
            $this->deletePhoto($id);
        }
    }

    private function deletePhoto(int $id, ?string $except = null): void
    {
        $disk = Storage::disk('public');
        foreach (self::PHOTO_EXTENSIONS as $extension) {
            $path = self::PHOTO_DIRECTORY . '/position-' . $id . '.' . $extension;
            if ($path !== $except && $disk->exists($path)) $disk->delete($path);
        }
    }

    private function validatedPosition(Request $request): array
    {
        $validated = $request->validate([
            'banom' => ['required', Rule::in(array_keys(self::BANOMS))],
            'role' => ['required', 'string', 'max:100'],
            'person_name' => ['nullable', 'string', 'max:120', 'required_without:member_id'],
            'member_id' => ['nullable', 'integer', Rule::exists('members', 'id')->where('status', 'approved')],
            'description' => ['nullable', 'string', 'max:180'],
            'level' => ['required', 'integer', 'between:1,3'],
            'sort_order' => ['required', 'integer', 'between:0,999'],
            'is_visible' => ['required', 'boolean'],
            'photo' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048'],
            'remove_photo' => ['nullable', 'boolean'],
        ]);

        $memberId = $validated['member_id'] ?? null;
        if ($memberId !== null) {
            $member = Member::query()->findOrFail($memberId);
            if (self::canonicalBanom($member->banom) !== $validated['banom']) {
                throw ValidationException::withMessages([
                    'member_id' => 'Anggota harus berasal dari Banom yang sedang dikelola.',
                ]);
            }
        }

        return [
            'banom' => $validated['banom'],
            'role' => trim($validated['role']),
            'person_name' => $memberId !== null ? null : trim($validated['person_name'] ?? ''),
            'member_id' => $memberId,
            'description' => trim($validated['description'] ?? '') ?: null,
            'level' => (int) $validated['level'],
            'sort_order' => (int) $validated['sort_order'],
            'is_visible' => (bool) $validated['is_visible'],
        ];
    }

    private function ensureAdmin(Request $request): void
    {
        abort_unless($request->user() && $request->user()->role === 'admin', 403);
    }
}
