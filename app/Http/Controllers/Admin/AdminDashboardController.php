<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Member;
use App\Models\News;
use App\Models\InfaqTransaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Schema;

class AdminDashboardController extends Controller
{
    // Overview / Halaman Utamanya Admin

    // Modul: Kelola Infaq & Kas
public function infaqIndex()
{
    $infaqTransactions = Schema::hasTable('infaq_transactions') ? InfaqTransaction::latest()->get() : collect();
    $infaqMasuk = Schema::hasTable('infaq_transactions') ? InfaqTransaction::where('type', 'masuk')->sum('amount') : 0;
    $infaqKeluar = Schema::hasTable('infaq_transactions') ? InfaqTransaction::where('type', 'keluar')->sum('amount') : 0;
    $totalInfaq = $infaqMasuk - $infaqKeluar;

    return view('admin.infaq', compact('infaqTransactions', 'infaqMasuk', 'infaqKeluar', 'totalInfaq'));
}

public function storeInfaq(Request $request)
{
    $request->validate([
        'amount' => 'required|numeric|min:1',
        'type' => 'required|in:masuk,keluar',
        'description' => 'required|string|max:255',
    ]);

    InfaqTransaction::create([
        'amount' => $request->amount,
        'type' => $request->type,
        'description' => $request->description,
    ]);

    return back()->with('success', 'Transaksi kas/infaq berhasil dicatat!');
}

public function destroyInfaq($id)
{
    $infaq = InfaqTransaction::findOrFail($id);
    $infaq->delete();

    return back()->with('success', 'Catatan transaksi berhasil dihapus.');
}

    public function index()
    {
        $pendingMembers = Schema::hasTable('members') ? Member::where('status', 'pending')->latest()->take(5)->get() : collect();
        $totalApprovedMembers = Schema::hasTable('members') ? Member::where('status', 'approved')->count() : 0;
        $totalNews = Schema::hasTable('news') ? News::count() : 0;

        $totalInfaq = 0;
        if (Schema::hasTable('infaq_transactions')) {
            $infaqMasuk = InfaqTransaction::where('type', 'masuk')->sum('amount');
            $infaqKeluar = InfaqTransaction::where('type', 'keluar')->sum('amount');
            $totalInfaq = $infaqMasuk - $infaqKeluar;
        }

        return view('admin.dashboard', compact('pendingMembers', 'totalApprovedMembers', 'totalNews', 'totalInfaq'));
    }

    // Modul Halaman Kelola Anggota
    public function membersIndex()
    {
        $pendingMembers = Schema::hasTable('members') ? Member::where('status', 'pending')->latest()->get() : collect();
        $approvedMembers = Schema::hasTable('members') ? Member::where('status', 'approved')->latest()->get() : collect();

        return view('admin.members', compact('pendingMembers', 'approvedMembers'));
    }

    public function approveMember($id)
    {
        $member = Member::findOrFail($id);
        $member->update(['status' => 'approved']);
        return back()->with('success', 'Anggota berhasil di-ACC!');
    }

    public function rejectMember($id)
    {
        $member = Member::findOrFail($id);
        $member->update(['status' => 'rejected']);
        return back()->with('success', 'Pendaftaran anggota ditolak.');
    }

   public function updateMember(Request $request, $id)
{
    $request->validate([
        'name' => 'required|string|max:255',
        'banom' => 'required|string',
        'gender' => 'nullable|string',
        'photo' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048', // Maks 2MB
    ]);

    $member = Member::findOrFail($id);

    // Jika ada upload foto baru
    if ($request->hasFile('photo')) {
        // Hapus foto lama jika ada di storage
        if ($member->photo && \Illuminate\Support\Facades\Storage::disk('public')->exists($member->photo)) {
            \Illuminate\Support\Facades\Storage::disk('public')->delete($member->photo);
        }
        
        // Simpan foto baru
        $photoPath = $request->file('photo')->store('members', 'public');
        $member->photo = $photoPath;
    }

    $member->name = $request->name;
    $member->banom = $request->banom;
    if ($request->gender) {
        $member->gender = $request->gender;
    }
    $member->save();

    return back()->with('success', 'Data & foto profil anggota berhasil diperbarui!');
    }

    public function destroyMember($id)
    {
        $member = Member::findOrFail($id);
        $member->delete();
        return back()->with('success', 'Data anggota berhasil dihapus!');
    }

    // Modul Halaman Kelola Berita
    public function newsIndex()
    {
        $publishedNews = Schema::hasTable('news') ? News::latest()->get() : collect();
        return view('admin.news', compact('publishedNews'));
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

        return back()->with('success', 'Berita berhasil dipublikasikan!');
    }

    public function destroyNews($id)
    {
        $news = News::findOrFail($id);
        $news->delete();
        return back()->with('success', 'Berita berhasil dihapus.');
    }
}