<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Member;
use App\Models\News;
use App\Models\InfaqTransaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\ValidationException;

class AdminDashboardController extends Controller
{
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

    public function membersIndex()
    {
        $pendingMembers = Schema::hasTable('members') ? Member::where('status', 'pending')->latest()->get() : collect();
        $approvedMembers = Schema::hasTable('members') ? Member::where('status', 'approved')->latest()->get() : collect();

        return view('admin.members', compact('pendingMembers', 'approvedMembers'));
    }

    public function approveMember($id)
    {
        DB::transaction(function () use ($id) {
            $member = Member::query()->lockForUpdate()->findOrFail($id);
            $user = $member->user()->lockForUpdate()->first();

            if (! $user || $user->role !== 'member') {
                throw ValidationException::withMessages([
                    'member' => 'Data anggota belum terhubung dengan akun login anggota yang valid.',
                ]);
            }

            // Jika akun sudah punya NIA, gunakan nomor tersebut.
            // Jika data anggota sudah punya NIA, gunakan itu agar tidak berganti.
            $nia = $user->nia ?: $member->nia;
            if (! $nia) {
                $nia = $user::generateNia();
            }

            // Jangan mengambil NIA yang sudah dipakai akun lain.
            if ($user::query()->where('nia', $nia)->whereKeyNot($user->getKey())->exists()) {
                throw ValidationException::withMessages([
                    'member' => 'NIA anggota sudah dipakai akun lain. Periksa data sebelum menyetujui.',
                ]);
            }

            $user->update(['status' => 'approved', 'nia' => $nia]);
            $member->update(['status' => 'approved', 'nia' => $nia]);
        });

        return back()->with('success', 'Anggota berhasil di-ACC dan akun login diaktifkan!');
    }

    public function rejectMember($id)
    {
        DB::transaction(function () use ($id) {
            $member = Member::query()->lockForUpdate()->findOrFail($id);
            $user = $member->user()->lockForUpdate()->first();

            if (! $user || $user->role !== 'member') {
                throw ValidationException::withMessages([
                    'member' => 'Data anggota belum terhubung dengan akun login anggota yang valid.',
                ]);
            }

            $member->update(['status' => 'rejected']);
            $user->update(['status' => 'rejected']);
        });

        return back()->with('success', 'Pendaftaran anggota ditolak dan akun login dinonaktifkan.');
    }

    public function updateMember(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'banom' => 'required|string',
            'gender' => 'nullable|string',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
        ]);

        $member = Member::findOrFail($id);

        if ($request->hasFile('photo')) {
            if ($member->photo && Storage::disk('public')->exists($member->photo)) {
                Storage::disk('public')->delete($member->photo);
            }
            $member->photo = $request->file('photo')->store('members', 'public');
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
