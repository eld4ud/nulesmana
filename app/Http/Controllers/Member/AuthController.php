<?php

namespace App\Http\Controllers\Member;

use App\Http\Controllers\Controller;
use App\Models\Member;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Schema;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;

class AuthController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | HALAMAN LOGIN ANGGOTA
    |--------------------------------------------------------------------------
    */

    public function create(): View
    {
        return view('member.login');
    }

    /*
    |--------------------------------------------------------------------------
    | PROSES LOGIN ANGGOTA
    |--------------------------------------------------------------------------
    */

    public function store(Request $request): RedirectResponse
    {
        // Validasi data dari form login anggota.
        $validated = $request->validate([
            'login_type' => [
                'required',
                Rule::in([
                    'email',
                    'phone',
                    'nia',
                    'username',
                ]),
            ],

            'login' => [
                'required',
                'string',
                'max:255',
            ],

            'password' => [
                'required',
                'string',
            ],

            'remember' => [
                'nullable',
                'boolean',
            ],
        ]);

        $loginType = $validated['login_type'];
        $login = trim($validated['login']);

        $user = null;

        /*
        |--------------------------------------------------------------------------
        | LOGIN MENGGUNAKAN EMAIL
        |--------------------------------------------------------------------------
        */

        if ($loginType === 'email') {

            $user = User::query()
                ->where('email', $login)
                ->where('role', 'member')
                ->first();
        }

        /*
        |--------------------------------------------------------------------------
        | LOGIN MENGGUNAKAN NOMOR HP
        |--------------------------------------------------------------------------
        */

        if ($loginType === 'phone') {

            $member = Member::query()
                ->where('phone', $login)
                ->first();

            if ($member && $member->user_id) {

                $user = User::query()
                    ->whereKey($member->user_id)
                    ->where('role', 'member')
                    ->first();
            }
        }

        /*
        |--------------------------------------------------------------------------
        | LOGIN MENGGUNAKAN NIA
        |--------------------------------------------------------------------------
        */

        if ($loginType === 'nia') {

            // Cari melalui akun users terlebih dahulu.
            $user = User::query()
                ->where('nia', $login)
                ->where('role', 'member')
                ->first();

            // Jika tidak ditemukan, cari dari members.
            if (! $user) {

                $member = Member::query()
                    ->where('nia', $login)
                    ->first();

                if ($member && $member->user_id) {

                    $user = User::query()
                        ->whereKey($member->user_id)
                        ->where('role', 'member')
                        ->first();
                }
            }
        }

        /*
        |--------------------------------------------------------------------------
        | LOGIN MENGGUNAKAN USERNAME
        |--------------------------------------------------------------------------
        |
        | Hanya digunakan jika tabel users
        | memang memiliki kolom username.
        |
        */

        if (
            $loginType === 'username'
            && Schema::hasColumn('users', 'username')
        ) {

            $user = User::query()
                ->where('username', $login)
                ->where('role', 'member')
                ->first();
        }

        /*
        |--------------------------------------------------------------------------
        | PERIKSA EMAIL / HP / NIA DAN PASSWORD
        |--------------------------------------------------------------------------
        */

        if (
            ! $user
            || ! Hash::check(
                $validated['password'],
                $user->password
            )
        ) {

            throw ValidationException::withMessages([
                'login' => 'Identitas login atau password salah.',
            ]);
        }

        /*
        |--------------------------------------------------------------------------
        | PASTIKAN AKUN MEMANG MILIK ANGGOTA
        |--------------------------------------------------------------------------
        */

        if ($user->role !== 'member') {

            throw ValidationException::withMessages([
                'login' => 'Gunakan halaman login admin untuk akun pengurus.',
            ]);
        }

        /*
        |--------------------------------------------------------------------------
        | PASTIKAN TERHUBUNG DENGAN DATA ANGGOTA
        |--------------------------------------------------------------------------
        */

        $member = Member::query()
            ->where('user_id', $user->id)
            ->first();

        if (! $member) {

            throw ValidationException::withMessages([
                'login' => 'Akun belum terhubung dengan data anggota. Hubungi pengurus.',
            ]);
        }

        /*
        |--------------------------------------------------------------------------
        | PERIKSA STATUS VERIFIKASI
        |--------------------------------------------------------------------------
        */

        if (
            $user->status === 'pending'
            || $member->status === 'pending'
        ) {

            throw ValidationException::withMessages([
                'login' => 'Pendaftaran masih menunggu ACC dari pengurus.',
            ]);
        }

        if (
            $user->status === 'rejected'
            || $member->status === 'rejected'
        ) {

            throw ValidationException::withMessages([
                'login' => 'Pendaftaran ditolak. Hubungi pengurus untuk informasi lebih lanjut.',
            ]);
        }

        /*
        |--------------------------------------------------------------------------
        | HANYA ANGGOTA APPROVED YANG BOLEH LOGIN
        |--------------------------------------------------------------------------
        */

        if (
            $user->status !== 'approved'
            || $member->status !== 'approved'
        ) {

            throw ValidationException::withMessages([
                'login' => 'Status keanggotaan belum aktif.',
            ]);
        }

        /*
        |--------------------------------------------------------------------------
        | LOGIN BERHASIL
        |--------------------------------------------------------------------------
        */

        Auth::guard('web')->login(
            $user,
            $request->boolean('remember')
        );

        // Membuat ulang ID sesi setelah login.
        $request->session()->regenerate();

        /*
         * Hapus tujuan lama dari session.
         *
         * Ini mencegah anggota diarahkan kembali
         * ke /admin/dashboard atau URL admin lainnya.
         */
        $request->session()->forget('url.intended');

        /*
         * Jangan gunakan redirect()->intended().
         *
         * Anggota approved selalu diarahkan
         * ke dashboard anggota.
         */
        return redirect()->route('member.dashboard');
    }

    /*
    |--------------------------------------------------------------------------
    | LOGOUT ANGGOTA
    |--------------------------------------------------------------------------
    */

    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        // Hapus sesi lama dan perbarui token CSRF.
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()
            ->route('member.login')
            ->with(
                'success',
                'Berhasil keluar dari akun anggota.'
            );
    }
}
