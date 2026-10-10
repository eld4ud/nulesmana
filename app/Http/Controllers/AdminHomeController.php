<?php

namespace App\Http\Controllers;

use App\Models\Member;
use App\Models\News;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Schema;

class AdminHomeController extends Controller
{
    public function index()
    {
        $pendingMembers = collect();
        $approvedMembers = collect();$publishedNews = collect();

        if (Schema::hasTable('members')) {
            // Data pendaftar yang belum di-ACC
            $pendingMembers = Member::where('status', 'pending')->latest()->get();
            // Data pendaftar yang SUDAH di-ACC (Daftar Anggota Resmi)
            $approvedMembers = Member::where('status', 'approved')->latest()->get();
        }

        if (Schema::hasTable('news')) {
            $publishedNews = News::latest()->get();
        }

        return view('admin.home', compact('pendingMembers', 'approvedMembers', 'publishedNews'));
    }

    public function approve($id)
    {
        $member = Member::findOrFail($id);$member->update(['status' => 'approved']);

        return back()->with('success', 'Anggota berhasil di-ACC!');
    }

    public function reject($id)
    {
        $member = Member::findOrFail($id);$member->update(['status' => 'rejected']);

        return back()->with('success', 'Pendaftaran anggota ditolak.');
    }

    // UPDATE DATA ANGGOTA (EDIT)
    public function updateMember(Request $request,$id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'banom' => 'required|string',
            'phone' => 'nullable|string|max:20',
        ]);

        $member = Member::findOrFail($id);$member->update([
            'name' => $request->name,
            'banom' => $request->banom,
            'phone' => $request->phone,
        ]);

        return back()->with('success', 'Data anggota berhasil diperbarui!');
    }

    // HAPUS ANGGOTA (DELETE)
    public function destroyMember($id)
    {
        $member = Member::findOrFail($id);$member->delete();

        return back()->with('success', 'Data anggota berhasil dihapus!');
    }

    public function storeNews(Request $request)
    {
    $request->validate([
        'title' => 'required|string|max:255',
        'event_date' => 'required|date',
        'content' => 'required|string',
        'image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
    ]);

    $imagePath = null;
    if ($request->hasFile('image')) {
        $imagePath = $request->file('image')->store('news', 'public');
    }

    News::create([
        'title' => $request->title,
        'event_date' => $request->event_date,
        'content' => $request->content,
        'image' => $imagePath,
    ]);

    return back()->with('success', 'Berita & foto kegiatan berhasil dipublikasikan!');
    }

    public function destroyNews($id)
    {
        $news = News::findOrFail($id);$news->delete();

        return back()->with('success', 'Berita berhasil dihapus.');
    }
}