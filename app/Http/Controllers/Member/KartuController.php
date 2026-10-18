<?php

namespace App\Http\Controllers\Member;

use App\Http\Controllers\Controller;
use App\Models\Member;
use App\Models\User;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use RuntimeException;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Storage;

class KartuController extends Controller
{
    public function kia(): View
    {
        return view('member.kartu.kia', $this->dataKartu());
    }

    public function cetak(): View
    {
        return view('member.kartu.cetak', $this->dataKartu());
    }

    public function uploadFoto(Request $request): RedirectResponse
    {
        $request->validate([
            'foto' => ['required', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048'],
        ]);
        $user = $request->user();
        abort_unless($user && $user->role === 'member' && $user->status === 'approved'
            && $user->member && $user->member->status === 'approved', 403);
        $disk = Storage::disk('public');
        $dir = 'member-photos/' . $user->id;
        $extension = $request->file('foto')->extension();
        $name = 'avatar.' . $extension;
        $disk->putFileAs($dir, $request->file('foto'), $name);
        foreach ($disk->files($dir) as $file) {
            if ($file !== $dir . '/' . $name) $disk->delete($file);
        }
        return back()->with('success', 'Foto profil berhasil diperbarui.');
    }

    private function fotoUrl(int $userId): ?string
    {
        $files = Storage::disk('public')->files('member-photos/' . $userId);
        foreach ($files as $file) {
            if (preg_match('/\/avatar\.(jpg|jpeg|png|webp)$/i', $file)) {
                return Storage::disk('public')->url($file);
            }
        }
        return null;
    }

    private function dataKartu(): array
    {
        $userId = Auth::id();

        $data = DB::transaction(function () use ($userId) {
            // Kunci akun agar dua permintaan bersamaan tidak menerbitkan dua NIA.
            $user = User::query()->lockForUpdate()->findOrFail($userId);
            $member = Member::query()->where('user_id', $user->id)
                ->lockForUpdate()->firstOrFail();

            abort_unless(
                $user->role === 'member'
                && $user->status === 'approved'
                && $member->status === 'approved',
                403,
                'Keanggotaan belum disetujui.'
            );

            $userNia = trim((string) $user->nia);
            $memberNia = trim((string) $member->nia);

            if ($userNia !== '' && $memberNia !== '' && $userNia !== $memberNia) {
                Log::warning('NIA berbeda antara akun dan anggota', [
                    'user_id' => $user->id, 'member_id' => $member->id,
                ]);
                throw new RuntimeException('NIA akun dan anggota tidak sama. Hubungi admin.');
            }

            $nia = $userNia ?: $memberNia;

            if ($nia === '') {
                // Gunakan generator NIA proyek yang sudah ada, bukan nomor buatan.
                // Jika generator bermasalah, proses batal tanpa menyimpan nomor palsu.
                $nia = User::generateNia();
                if (!is_string($nia) || trim($nia) === '') {
                    throw new RuntimeException('Generator NIA tidak menghasilkan nomor.');
                }
                $nia = trim($nia);
            }

            $usedByOtherUser = User::query()->where('nia', $nia)
                ->where('id', '!=', $user->id)->exists();
            $usedByOtherMember = Member::query()->where('nia', $nia)
                ->where('id', '!=', $member->id)->exists();

            if ($usedByOtherUser || $usedByOtherMember) {
                throw new RuntimeException('NIA sudah digunakan anggota lain. Hubungi admin.');
            }

            if ($userNia !== $nia) $user->update(['nia' => $nia]);
            if ($memberNia !== $nia) $member->update(['nia' => $nia]);

            return ['user' => $user->fresh(), 'member' => $member->fresh(), 'nia' => $nia];
        });

        $data['photoUrl'] = $this->fotoUrl($userId);
        return $data;
    }
}
