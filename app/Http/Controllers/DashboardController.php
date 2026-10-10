<?php

namespace App\Http\Controllers;

use App\Models\Member;
use App\Models\News;
use App\Models\InfaqTransaction;
use Illuminate\Support\Facades\Schema;
use Illuminate\Http\Request;

class DashboardController extends Controller
{

    // Tambahkan method ini di dalam DashboardController.php
    public function infaq()
  {
    $totalInfaq = 0;
    $infaqMasuk = 0;
    $infaqKeluar = 0;
    $infaqTransactions = collect();

    if (\Illuminate\Support\Facades\Schema::hasTable('infaq_transactions')) {
        $infaqMasuk = InfaqTransaction::where('type', 'masuk')->sum('amount');
        $infaqKeluar = InfaqTransaction::where('type', 'keluar')->sum('amount');
        $totalInfaq = $infaqMasuk - $infaqKeluar;

        // Ambil seluruh riwayat transaksi diurutkan dari terbaru
        $infaqTransactions = InfaqTransaction::latest()->get();
    }

    return view('infaq', compact('totalInfaq', 'infaqMasuk', 'infaqKeluar', 'infaqTransactions'));
   }

    public function index()
    {
        $totalMembers = 0;
        $recentMembers = collect();
        $latestNews = collect();
        $totalInfaq = 0;

        // Cek & ambil data Anggota jika tabel members ada
        if (Schema::hasTable('members')) {
            $totalMembers = Member::where('status', 'approved')->count();
            $recentMembers = Member::where('status', 'approved')->latest()->take(5)->get();
        }

        // Cek & ambil data Berita jika tabel news ada
        if (Schema::hasTable('news')) {
            $latestNews = News::latest()->take(4)->get();
        }

        // Cek & hitung Saldo Infaq jika tabel infaq_transactions ada
        if (Schema::hasTable('infaq_transactions')) {
            $infaqMasuk = InfaqTransaction::where('type', 'masuk')->sum('amount');
            $infaqKeluar = InfaqTransaction::where('type', 'keluar')->sum('amount');
            $totalInfaq = $infaqMasuk - $infaqKeluar;
        }

        return view('dashboard', compact('totalMembers', 'recentMembers', 'latestNews', 'totalInfaq'));
    }
}