<?php

namespace App\Http\Controllers\Member;

use App\Http\Controllers\Controller;
use App\Models\Member;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class AkunController extends Controller
{
    private const PAGES = [
        'kia'        => 'Kartu Identitas Anggota',
        'data'       => 'Data Saya',
        'infaq'      => 'Riwayat Infaq',
        'notifikasi' => 'Notifikasi',
        'pengaturan' => 'Pengaturan',
    ];

    public function dashboard(Request $request): View
    {
        $user = $request->user();

        abort_unless($user && $user->role === 'member', 403);

        return view('member.dashboard', [
            'user'      => $user,
            'pageTitle' => 'Profil Saya',
            'menus'     => self::PAGES,
        ]);
    }

    public function page(Request $request): View
    {
        $user = $request->user();
        abort_unless($user && $user->role === 'member', 403);

        $slug = $request->route('page');

        abort_unless(
            is_string($slug) && array_key_exists($slug, self::PAGES),
            404
        );

        return view('member.soon', [
            'user'   => $user,
            'member' => $user->member,
            'title'  => self::PAGES[$slug],
            'page'   => $slug,
        ]);
    }

    /**
     * Anggota boleh memperbarui nama, telepon, dan alamat miliknya.
     * NIA, banom, role, serta status tidak bisa dikirim melalui endpoint ini.
     */
    public function updateData(Request $request): RedirectResponse
    {
        $user = $request->user();

        abort_unless(
            $user && $user->role === 'member' && $user->status === 'approved',
            403
        );

        $validated = $request->validate([
            'name'    => ['required', 'string', 'min:2', 'max:100'],
            'phone'   => ['nullable', 'string', 'max:30'],
            'address' => ['nullable', 'string', 'max:500'],
        ]);

        DB::transaction(function () use ($user, $validated): void {
            $member = Member::query()
                ->where('user_id', $user->id)
                ->lockForUpdate()
                ->first();

            abort_unless(
                $member && $member->status === 'approved',
                403,
                'Data keanggotaan belum terhubung atau belum disetujui.'
            );

            $name = trim($validated['name']);

            $user->name = $name;
            $user->save();

            $member->name = $name;
            $member->phone = filled($validated['phone'] ?? null)
                ? trim($validated['phone'])
                : null;
            $member->address = filled($validated['address'] ?? null)
                ? trim($validated['address'])
                : null;
            $member->save();
        });

        return redirect()
            ->route('member.data')
            ->with('success', 'Data pribadi berhasil diperbarui.');
    }
}
