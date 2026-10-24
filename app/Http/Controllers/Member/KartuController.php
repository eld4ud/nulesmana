<?php

namespace App\Http\Controllers\Member;

use App\Http\Controllers\Controller;
use App\Models\Member;
use App\Models\User;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use RuntimeException;

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

    // QR kartu mengarah ke profil KIA milik PEMILIK kartu saja.
    // Tambahkan route ini di grup auth + approved.member + role:member.
    public function dariQr(Request $request, Member $member): RedirectResponse
    {
        $user = $request->user();

        abort_unless(
            $user
            && $user->role === 'member'
            && $user->status === 'approved'
            && (int) $member->user_id === (int) $user->id
            && $member->status === 'approved',
            403,
            'Kartu ini hanya dapat dibuka oleh pemilik akun.'
        );

        return redirect()->route('member.kia');
    }

    public function uploadFoto(Request $request): RedirectResponse
    {
        $request->validate([
            'foto' => ['required', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048'],
        ]);

        $user = $request->user();
        $member = $user?->member;
        abort_unless(
            $user && $user->role === 'member'
            && $user->status === 'approved'
            && $member && $member->status === 'approved',
            403
        );

        $disk = Storage::disk('public');
        $previous = $member->photo;
        $newPath = $request->file('foto')->store('members', 'public');

        try {
            $member->update(['photo' => $newPath]);
        } catch (\Throwable $exception) {
            $disk->delete($newPath);
            throw $exception;
        }

        // Jangan hapus gambar dari folder lama (fallback untuk anggota lama).
        if ($previous && $previous !== $newPath && str_starts_with($previous, 'members/')) {
            $disk->delete($previous);
        }

        return back()->with('success', 'Foto profil dan kartu anggota berhasil diperbarui.');
    }

    // Foto lama tetap tampil jika anggota belum mempunyai members.photo.
    private function legacyFotoUrl(int $userId): ?string
    {
        foreach (Storage::disk('public')->files('member-photos/' . $userId) as $file) {
            if (preg_match('~/avatar\.(jpg|jpeg|png|webp)$~i', $file)) {
                return Storage::disk('public')->url($file);
            }
        }
        return null;
    }

    private function dataKartu(): array
    {
        $userId = Auth::id();

        $data = DB::transaction(function () use ($userId) {
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
                    'user_id' => $user->id,
                    'member_id' => $member->id,
                ]);
                throw new RuntimeException('NIA akun dan anggota tidak sama. Hubungi admin.');
            }

            $nia = $userNia ?: $memberNia;

            if ($nia === '') {
                $nia = User::generateNia();
                if (! is_string($nia) || trim($nia) === '') {
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

        $photoPath = $data['member']->photo;
        $data['photoUrl'] = $photoPath
            ? Storage::disk('public')->url($photoPath)
            : $this->legacyFotoUrl((int) $userId);

        return $data;
    }
}
