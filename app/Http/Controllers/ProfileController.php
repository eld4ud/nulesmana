<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;

class ProfileController extends Controller
{
    /**
     * Satu halaman profil untuk admin dan anggota.
     * Form/warna ditentukan oleh resources/views/profile/edit.blade.php.
     */
    public function edit(Request $request): View
    {
        return view('profile.edit', [
            'user' => $request->user(),
        ]);
    }

    /**
     * Update nama/email akun. Nama anggota disinkronkan ke tabel members.
     * NIA, role, banom, dan status sama sekali tidak diubah di sini.
     */
    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        $user = $request->user();
        $validated = $request->validated();

        DB::transaction(function () use ($user, $validated): void {
            $user->fill($validated);

            if ($user->isDirty('email')) {
                $user->email_verified_at = null;
            }

            $user->save();

            if ($user->role === 'member' && array_key_exists('name', $validated)) {
                $user->member()->update(['name' => $user->name]);
            }
        });

        // Admin kembali ke /admin/profile, bukan /profile bawaan Breeze.
        return Redirect::route(
            $user->role === 'admin' ? 'admin.profile.edit' : 'profile.edit'
        )->with('status', 'profile-updated');
    }

    /**
     * Fitur penghapusan akun asli tetap dipertahankan untuk kompatibilitas.
     * Tidak ada tombol hapus akun pada desain profil admin.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        Auth::logout();
        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }
}
