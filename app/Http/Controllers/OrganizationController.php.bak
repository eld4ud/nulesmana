<?php

namespace App\Http\Controllers;

use App\Models\Member;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Validation\Rule;
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

    /**
     * Menyatukan variasi nama Banom yang mungkin sudah ada di tabel members.
     * Tidak mengubah data aslinya dan tidak memasukkan NU umum ke salah satu Banom.
     */
    private static function canonicalBanom(?string $value): ?string
    {
        $text = mb_strtolower(trim((string) $value));
        $text = preg_replace('/[^a-z]+/', '', $text);

        if (str_contains($text, 'ippnu')) {
            return 'IPPNU';
        }
        if (str_contains($text, 'ipnu')) {
            return 'IPNU';
        }
        if (str_contains($text, 'ansor') || str_contains($text, 'banser')) {
            return 'Ansor';
        }
        if (str_contains($text, 'fatayat')) {
            return 'Fatayat';
        }
        if (str_contains($text, 'muslimat')) {
            return 'Muslimat';
        }

        return null;
    }

    /** Jumlah dihitung langsung dari status ACC, bukan dari frekuensi login. */
    private function approvedCounts(): array
    {
        $counts = array_fill_keys(array_keys(self::BANOMS), 0);

        $rows = Member::query()
            ->where('status', 'approved')
            ->select('banom')
            ->selectRaw('COUNT(*) AS total')
            ->groupBy('banom')
            ->get();

        foreach ($rows as $row) {
            $key = self::canonicalBanom($row->banom);
            if ($key !== null) {
                $counts[$key] += (int) $row->total;
            }
        }

        return $counts;
    }

    /**
     * Halaman struktur publik. Tidak menampilkan semua nama anggota pribadi.
     * Nama tampil hanya pada jabatan yang dipublikasikan pengurus.
     */
    public function index(): View
    {
        $counts = $this->approvedCounts();
        $positions = DB::table('organization_positions as p')
            ->leftJoin('members as m', 'm.id', '=', 'p.member_id')
            ->where('p.is_visible', true)
            ->select('p.*', 'm.name as member_name', 'm.status as member_status')
            ->orderBy('p.level')
            ->orderBy('p.sort_order')
            ->orderBy('p.id')
            ->get()
            ->groupBy('banom');

        $banoms = [];
        foreach (self::BANOMS as $key => $label) {
            $banoms[$key] = [
                'label' => $label,
                'count' => $counts[$key],
                'positions' => ($positions->get($key) ?? collect())->filter(
                    fn ($position) => $position->member_id === null || $position->member_status === 'approved'
                )->values(),
            ];
        }

        return view('struktur-organisasi', compact('banoms'));
    }

    /** Panel admin untuk menetapkan jabatan, bukan mengedit status member. */
    public function manage(Request $request): View
    {
        $this->ensureAdmin($request);

        $selected = $request->query('banom', 'IPNU');
        if (!is_string($selected) || !array_key_exists($selected, self::BANOMS)) {
            $selected = 'IPNU';
        }

        $positions = DB::table('organization_positions as p')
            ->leftJoin('members as m', 'm.id', '=', 'p.member_id')
            ->where('p.banom', $selected)
            ->select('p.*', 'm.name as member_name')
            ->orderBy('p.level')
            ->orderBy('p.sort_order')
            ->orderBy('p.id')
            ->get();

        $members = Member::query()
            ->where('status', 'approved')
            ->orderBy('name')
            ->get(['id', 'name', 'banom'])
            ->filter(fn ($member) => self::canonicalBanom($member->banom) === $selected)
            ->values();

        $counts = $this->approvedCounts();
        $banomLabels = self::BANOMS;

        return view('admin.struktur', compact('selected', 'positions', 'members', 'counts', 'banomLabels'));
    }

    public function store(Request $request): RedirectResponse
    {
        $this->ensureAdmin($request);
        $data = $this->validatedPosition($request);

        DB::table('organization_positions')->insert([
            ...$data,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        return redirect()->route('admin.struktur.index', ['banom' => $data['banom']])
            ->with('success', 'Jabatan pengurus berhasil ditambahkan.');
    }

    public function update(Request $request, int $id): RedirectResponse
    {
        $this->ensureAdmin($request);
        $current = DB::table('organization_positions')->where('id', $id)->first();
        abort_if($current === null, 404);

        $data = $this->validatedPosition($request);
        DB::table('organization_positions')->where('id', $id)->update([
            ...$data,
            'updated_at' => now(),
        ]);

        return redirect()->route('admin.struktur.index', ['banom' => $data['banom']])
            ->with('success', 'Struktur pengurus berhasil diperbarui.');
    }

    public function destroy(Request $request, int $id): RedirectResponse
    {
        $this->ensureAdmin($request);
        $current = DB::table('organization_positions')->where('id', $id)->first();
        abort_if($current === null, 404);

        DB::table('organization_positions')->where('id', $id)->delete();

        return redirect()->route('admin.struktur.index', ['banom' => $current->banom])
            ->with('success', 'Jabatan dihapus dari struktur. Data anggota tidak ikut terhapus.');
    }

    private function validatedPosition(Request $request): array
    {
        $validated = $request->validate([
            'banom' => ['required', Rule::in(array_keys(self::BANOMS))],
            'role' => ['required', 'string', 'max:100'],
            'person_name' => ['nullable', 'string', 'max:120', 'required_without:member_id'],
            'member_id' => [
                'nullable',
                'integer',
                Rule::exists('members', 'id')->where('status', 'approved'),
            ],
            'description' => ['nullable', 'string', 'max:180'],
            'level' => ['required', 'integer', 'between:1,3'],
            'sort_order' => ['required', 'integer', 'between:0,999'],
            'is_visible' => ['required', 'boolean'],
        ]);

        $memberId = $validated['member_id'] ?? null;
        if ($memberId !== null) {
            $member = Member::query()->findOrFail($memberId);
            if (self::canonicalBanom($member->banom) !== $validated['banom']) {
                throw \Illuminate\Validation\ValidationException::withMessages([
                    'member_id' => 'Anggota harus berasal dari Banom yang dipilih.',
                ]);
            }
        }

        return [
            'banom' => $validated['banom'],
            'role' => trim($validated['role']),
            'person_name' => $memberId !== null ? null : trim($validated['person_name'] ?? ''),
            'member_id' => $memberId,
            'description' => $validated['description'] ?? null,
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
