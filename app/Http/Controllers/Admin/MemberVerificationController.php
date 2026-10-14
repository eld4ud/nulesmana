<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Member;
use App\Models\User;
use Illuminate\Http\Request;

class MemberVerificationController extends Controller
{
    public function index()
    {
        $members = Member::with('user')->latest()->get();
        return view('admin.members.index', compact('members'));
    }

    public function approve($id)
    {
        $member = Member::findOrFail($id);
        $user = $member->user;

        if ($user && $user->status !== 'approved') {
            $nia = User::generateNia();

            $user->update([
                'status' => 'approved',
                'nia' => $nia,
            ]);

            $member->update([
                'status' => 'approved',
                'nia' => $nia,
            ]);
        }

        return redirect()->back()->with('success', 'Anggota berhasil disetujui dan NIA otomatis telah diterbitkan.');
    }

    public function reject($id)
    {
        $member = Member::findOrFail($id);
        $user = $member->user;

        $user?->update(['status' => 'rejected']);
        $member->update(['status' => 'rejected']);

        return redirect()->back()->with('success', 'Pendaftaran anggota ditolak.');
    }
}