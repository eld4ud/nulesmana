<?php

namespace App\Http\Controllers;

use App\Models\Member;
use App\Models\News;
use App\Mail\FeedbackMail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Schema;

class PublicController extends Controller
{
    public function index()
    {
        $publishedNews = Schema::hasTable('news') ? News::latest()->get() : collect();
        $ipnuCount = Schema::hasTable('members') ? Member::where('banom', 'IPNU')->where('status', 'approved')->count() : 0;
        $ippnuCount = Schema::hasTable('members') ? Member::where('banom', 'IPPNU')->where('status', 'approved')->count() : 0;
        $ansorCount = Schema::hasTable('members') ? Member::where('banom', 'Ansor')->where('status', 'approved')->count() : 0;
        $fatayatCount = Schema::hasTable('members') ? Member::where('banom', 'Fatayat')->where('status', 'approved')->count() : 0;

        return view('welcome', compact('publishedNews', 'ipnuCount', 'ippnuCount', 'ansorCount', 'fatayatCount'));
    }

    public function registerMember(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'banom' => 'required|string',
            'phone' => 'nullable|string|max:20',
        ]);

        Member::create([
            'name' => $request->name,
            'banom' => $request->banom,
            'phone' => $request->phone,
            'status' => 'pending',
        ]);

        return back()->with('success', 'Pendaftaran berhasil! Tunggu verifikasi/ACC dari Pengurus Admin.');
    }

    public function sendFeedback(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email',
            'message' => 'required|string',
        ]);

        try {
            $adminEmail = env('MAIL_FROM_ADDRESS', 'admin@nupasiramanlor.or.id');
            Mail::to($adminEmail)->send(new FeedbackMail($request->name, $request->email, $request->message));
            return back()->with('success', 'Saran berhasil terkirim ke email pengurus!');
        } catch (\Exception $e) {
            return back()->with('error', 'Gagal mengirim saran.');
        }
    }

    public function news()
    {
        $newsList = News::latest()->paginate(11);
        return view('news.index', compact('newsList'));
    }

    public function showNews($id)
    {
        $news = News::findOrFail($id);
        return view('news.show', compact('news'));
    }
}