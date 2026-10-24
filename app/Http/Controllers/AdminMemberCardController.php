<?php

namespace App\Http\Controllers;

use App\Models\Member;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Storage;

// SELURUH ROUTE CONTROLLER INI WAJIB auth + admin.
class AdminMemberCardController extends Controller
{
    public function show(Member $member): View
    {
        abort_unless($member->status === 'approved', 404, 'Kartu hanya tersedia untuk anggota yang disetujui.');

        $user = $member->user;
        $nia = $member->nia ?: $user?->nia ?: 'NIA belum terbit';
        $photoUrl = $member->photo
            ? Storage::disk('public')->url($member->photo)
            : null;

        return view('admin.kartu-anggota', compact('member', 'user', 'nia', 'photoUrl'));
    }
}
