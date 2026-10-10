<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
{
    // Hitung total infaq (Masuk dikurangi Keluar)
    $infaqMasuk = InfaqTransaction::where('type', 'masuk')->sum('amount');
    $infaqKeluar = InfaqTransaction::where('type', 'keluar')->sum('amount');
    $totalInfaq = $infaqMasuk - $infaqKeluar;

    // Ambil 5 kegiatan terbaru
    $latestNews = News::latest()->take(5)->get();

    // Passing data ke file welcome.blade.php
    return view('welcome', compact('totalInfaq', 'latestNews'));
}
}
