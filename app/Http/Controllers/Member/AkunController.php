<?php

namespace App\Http\Controllers\Member;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\View\View;

class AkunController extends Controller
{
    /** Halaman yang masih dikerjakan di tahap berikutnya. */
    private const PAGES = [
        'kia'        => 'Kartu Identitas Anggota',
        'data'       => 'Data Saya',
        'infaq'      => 'Riwayat Infaq',
        'notifikasi' => 'Notifikasi',
        'pengaturan' => 'Pengaturan',
    ];

    public function dashboard(Request $request): View
    {
        return view('member.dashboard', ['user' => $request->user()]);
    }

    public function page(Request $request): View
    {
        $slug = $request->route('page');

        abort_unless(isset(self::PAGES[$slug]), 404);

        return view('member.soon', ['title' => self::PAGES[$slug]]);
    }
}
