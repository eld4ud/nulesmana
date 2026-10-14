<?php

namespace App\Http\Controllers;

use App\Models\Member;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\View\View;

class PageController extends Controller
{
    /** /daftar-anggota */
    public function signup(): View
    {
        return view('pages.signup');
    }

    /** /kia */
    public function kia(): View
    {
        return view('pages.kia');
    }

    /** /kia/cek?nia=LSM-26-0001 -> /verifikasi/LSM-26-0001 */
    public function kiaCheck(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'nia' => ['required', 'string', 'max:30'],
        ]);

        return redirect()->route('kia.verify', Str::upper(trim($data['nia'])));
    }

    /** /verifikasi/{nia}: hanya menampilkan nama, banom, dan status */
    public function verify(string $nia): View
    {
        $nia = Str::upper($nia);

        $member = Member::query()
            ->where('nia', $nia)
            ->where('status', 'approved')
            ->first();

        return view('pages.verify', [
            'nia'    => $nia,
            'member' => $member,
        ]);
    }

    /** /profil */
    public function profil(): View
    {
        $count = fn (string $banom) => Member::query()
            ->where('status', 'approved')
            ->where('banom', $banom)
            ->count();

        $banoms = [
            ['IPNU',            'Pelajar putra',  'ph-student',      $count('IPNU')],
            ['IPPNU',           'Pelajar putri',  'ph-student',      $count('IPPNU')],
            ['GP Ansor / Banser', 'Pemuda dan Banser', 'ph-shield-check', $count('Ansor')],
            ['Fatayat NU',      'Perempuan muda', 'ph-flower-lotus', $count('Fatayat')],
            ['Muslimat NU',     'Ibu-ibu NU',     'ph-heart',        $count('Muslimat')],
        ];

        return view('pages.profil', [
            'banoms' => $banoms,
            'total'  => array_sum(array_column($banoms, 3)),
        ]);
    }
}
