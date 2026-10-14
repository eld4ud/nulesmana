<?php

namespace App\Http\Controllers\Member;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\View\View;

class AkunController extends Controller
{
    /**
     * Daftar halaman yang tersedia untuk anggota.
     */
    private const PAGES = [
        'kia'        => 'Kartu Identitas Anggota',
        'data'       => 'Data Saya',
        'infaq'      => 'Riwayat Infaq',
        'notifikasi' => 'Notifikasi',
        'pengaturan' => 'Pengaturan',
    ];

    /**
     * Menampilkan dashboard / profil anggota.
     *
     * URL: /akun
     * Route: member.dashboard
     */
    public function dashboard(Request $request): View
    {
        $user = $request->user();

        // Pastikan hanya anggota yang dapat mengakses.
        abort_unless(
            $user && $user->role === 'member',
            403,
            'Halaman ini hanya untuk anggota.'
        );

        return view('member.dashboard', [
            'user'      => $user,
            'pageTitle' => 'Profil Saya',
            'menus'     => self::PAGES,
        ]);
    }

    /**
     * Menampilkan halaman fitur anggota.
     *
     * URL:
     * /akun/kia
     * /akun/data
     * /akun/infaq
     * /akun/notifikasi
     * /akun/pengaturan
     */
    public function page(Request $request): View
    {
        $user = $request->user();

        abort_unless(
            $user && $user->role === 'member',
            403
        );

        $slug = $request->route('page');

        // Pastikan halaman yang diminta terdaftar.
        abort_unless(
            is_string($slug) && array_key_exists($slug, self::PAGES),
            404
        );

        return view('member.soon', [
            'user'  => $user,
            'title' => self::PAGES[$slug],
            'page'  => $slug,
        ]);
    }
}
