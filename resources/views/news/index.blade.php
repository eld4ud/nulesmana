@extends('layouts.public')

@section('title', 'Semua Berita - Ranting NU Pasiraman Lor')

@section('content')
@php
    $items = collect($newsList->items())->values();

    // Helper kecil supaya markup di bawah tetap rapi
    $imgOf  = fn($n) => $n->image
        ? \Illuminate\Support\Facades\Storage::url($n->image)
        : 'https://images.unsplash.com/photo-1542601906990-b4d3fb778b09?auto=format&fit=crop&w=900&q=80';
    $dateOf = fn($n) => ($n->event_date ? \Carbon\Carbon::parse($n->event_date) : $n->created_at)?->translatedFormat('d F Y') ?? '-';
    $tagOf  = fn($n) => $n->event_date ? 'Agenda' : 'Berita';

    $feature = $items->get(0);                 // kartu besar kiri atas
    $banner  = $items->get(1);                 // banner kanan atas
    $grid    = $items->slice(2, 4);            // 4 berita kecil di bawah banner
    $list    = $items->slice(6, 4);            // daftar teks kiri bawah
    $closing = $items->get(10);                // kartu besar kanan bawah
@endphp

<!-- HEADER HALAMAN -->
<div class="mb-8 sm:mb-10 flex flex-col sm:flex-row sm:items-end sm:justify-between gap-4">
    <div>
        <a href="{{ url('/') }}#berita" class="inline-flex items-center gap-2 text-xs font-black text-gray-900 hover:text-green-900 transition mb-4">
            <i class="ph ph-arrow-left"></i> Kembali ke beranda
        </a>
        <h1 class="font-display text-5xl sm:text-7xl text-gray-900 leading-none">BERITA & AGENDA</h1>
        <p class="text-xs sm:text-sm text-gray-800 font-semibold mt-2 max-w-xl">
            Liputan majelis, pengajian rutin, dan kegiatan sosial warga Ranting NU Pasiraman Lor.
        </p>
    </div>
    <span class="self-start sm:self-end bg-green-900 text-lime-400 text-[10px] font-black px-3 py-1.5 rounded-full uppercase tracking-wider">
        {{ $newsList->total() }} tulisan
    </span>
</div>

@if($items->isEmpty())

    <div class="bg-white rounded-3xl p-12 shadow-xl text-center">
        <i class="ph ph-newspaper text-6xl text-green-900"></i>
        <h3 class="text-lg font-black text-gray-900 mt-3">Belum Ada Berita</h3>
        <p class="text-xs text-gray-600 font-medium mt-2">Berita terbaru akan ditampilkan di sini.</p>
    </div>

@else

<!-- ================= BENTO MAJALAH ================= -->
<div class="grid grid-cols-1 lg:grid-cols-2 gap-6 sm:gap-8 items-stretch">

    {{-- KIRI ATAS: BERITA UTAMA (foto besar) --}}
    @if($feature)
    <article class="group bg-white rounded-3xl p-4 sm:p-5 shadow-xl flex flex-col">
        <a href="{{ url('/news/' . $feature->id) }}" class="block">
            <div class="relative aspect-[4/3] overflow-hidden rounded-2xl bg-green-950">
                <img src="{{ $imgOf($feature) }}" alt="{{ $feature->title }}" class="w-full h-full object-cover group-hover:scale-105 transition duration-700">
                <span class="absolute bottom-3 left-3 bg-green-900 text-lime-300 text-[10px] font-black uppercase tracking-wider px-2.5 py-1 rounded-md">{{ $tagOf($feature) }}</span>
            </div>
        </a>
        <a href="{{ url('/news/' . $feature->id) }}" class="block mt-5">
            <h2 class="font-news text-xl sm:text-3xl font-black text-gray-900 leading-snug break-words group-hover:text-green-900 transition">{{ $feature->title }}</h2>
        </a>
        <div class="mt-auto pt-5 flex items-center gap-3">
            <div class="w-8 h-8 rounded-full bg-green-900 text-lime-300 flex items-center justify-center text-base shrink-0"><i class="ph ph-user"></i></div>
            <div class="text-[11px] sm:text-xs leading-tight">
                <p class="font-black text-gray-900">Pengurus Ranting</p>
                <p class="text-gray-500 font-semibold">{{ $dateOf($feature) }}</p>
            </div>
        </div>
    </article>
    @endif

    {{-- KANAN ATAS: BANNER + 4 BERITA KECIL --}}
    @if($banner)
    <div class="bg-white rounded-3xl p-4 sm:p-5 shadow-xl flex flex-col gap-5">
        <a href="{{ url('/news/' . $banner->id) }}" class="group block relative h-40 sm:h-52 overflow-hidden rounded-2xl bg-green-950">
            <img src="{{ $imgOf($banner) }}" alt="{{ $banner->title }}" class="w-full h-full object-cover group-hover:scale-105 transition duration-700">
            <div class="absolute inset-0 bg-gradient-to-t from-black/80 via-black/20 to-transparent"></div>
            <div class="absolute bottom-0 left-0 right-0 p-4">
                <span class="bg-lime-400 text-gray-900 text-[10px] font-black uppercase tracking-wider px-2.5 py-1 rounded-md">{{ $tagOf($banner) }}</span>
                <h3 class="font-news text-sm sm:text-lg font-black text-white leading-snug mt-2 break-words">{{ $banner->title }}</h3>
            </div>
        </a>

        @if($grid->isNotEmpty())
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-x-6 gap-y-5">
            @foreach($grid as $n)
                <a href="{{ url('/news/' . $n->id) }}" class="group flex gap-3 items-start">
                    <div class="w-16 h-16 shrink-0 overflow-hidden rounded-xl bg-green-950">
                        <img src="{{ $imgOf($n) }}" alt="{{ $n->title }}" class="w-full h-full object-cover group-hover:scale-110 transition duration-500">
                    </div>
                    <div class="min-w-0">
                        <span class="text-[10px] font-black text-green-800 uppercase tracking-wider">{{ $tagOf($n) }}</span>
                        <h4 class="font-news text-[13px] font-bold text-gray-900 leading-snug break-words group-hover:text-green-900 transition">{{ $n->title }}</h4>
                        <p class="text-[10px] text-gray-500 font-semibold mt-1">{{ $dateOf($n) }}</p>
                    </div>
                </a>
            @endforeach
        </div>
        @endif
    </div>
    @endif

    {{-- KIRI BAWAH: DAFTAR TEKS --}}
    @if($list->isNotEmpty())
    <div class="bg-white rounded-3xl p-4 sm:p-6 shadow-xl">
        <div class="flex items-center justify-between mb-2">
            <h3 class="font-display text-2xl text-gray-900">TULISAN LAINNYA</h3>
            <i class="ph ph-list-bullets text-xl text-green-900"></i>
        </div>
        <div class="divide-y divide-gray-200">
            @foreach($list as $n)
                <a href="{{ url('/news/' . $n->id) }}" class="group block py-4">
                    <span class="text-[10px] font-black text-green-800 uppercase tracking-wider">{{ $tagOf($n) }}</span>
                    <h4 class="font-news text-sm sm:text-base font-bold text-gray-900 leading-snug mt-1 break-words group-hover:text-green-900 transition">{{ $n->title }}</h4>
                    <p class="text-[11px] text-gray-500 font-semibold mt-1.5">{{ $dateOf($n) }}</p>
                </a>
            @endforeach
        </div>
    </div>
    @endif

    {{-- KANAN BAWAH: KARTU PENUTUP (foto besar) --}}
    @if($closing)
    <article class="group bg-white rounded-3xl p-4 sm:p-5 shadow-xl flex flex-col">
        <a href="{{ url('/news/' . $closing->id) }}" class="block">
            <div class="relative aspect-[16/10] overflow-hidden rounded-2xl bg-green-950">
                <img src="{{ $imgOf($closing) }}" alt="{{ $closing->title }}" class="w-full h-full object-cover group-hover:scale-105 transition duration-700">
                <span class="absolute bottom-3 left-3 bg-green-900 text-lime-300 text-[10px] font-black uppercase tracking-wider px-2.5 py-1 rounded-md">{{ $tagOf($closing) }}</span>
            </div>
        </a>
        <a href="{{ url('/news/' . $closing->id) }}" class="block mt-5">
            <h2 class="font-news text-lg sm:text-2xl font-black text-gray-900 leading-snug break-words group-hover:text-green-900 transition">{{ $closing->title }}</h2>
        </a>
        <div class="mt-auto pt-5 flex items-center gap-3">
            <div class="w-8 h-8 rounded-full bg-green-900 text-lime-300 flex items-center justify-center text-base shrink-0"><i class="ph ph-user"></i></div>
            <div class="text-[11px] sm:text-xs leading-tight">
                <p class="font-black text-gray-900">Pengurus Ranting</p>
                <p class="text-gray-500 font-semibold">{{ $dateOf($closing) }}</p>
            </div>
        </div>
    </article>
    @endif

</div>

<!-- PAGINATION -->
@if($newsList->hasPages())
    <div class="mt-10 bg-white rounded-2xl p-4 shadow-xl">{{ $newsList->links() }}</div>
@endif

@endif
@endsection