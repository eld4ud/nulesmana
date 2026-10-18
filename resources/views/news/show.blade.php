@extends('layouts.public')

@section('title', $news->title . ' - Nulesmana')

@section('content')
@php
    $tanggal = $news->event_date
        ? \Carbon\Carbon::parse($news->event_date)->translatedFormat('d F Y')
        : ($news->created_at?->translatedFormat('d F Y') ?? '-');
    $gambar = $news->image ? \Illuminate\Support\Facades\Storage::url($news->image) : null;
@endphp

<div class="min-h-screen bg-[#F5F4F0] text-[#183C2F]">
    <header class="border-b border-[#183C2F]/20">
        <div class="mx-auto flex w-full max-w-[1600px] flex-wrap items-center justify-between gap-4 px-5 py-7 sm:px-8 lg:px-12">
            <a href="{{ route('home') }}" class="font-display text-3xl sm:text-4xl">NULESMANA<span class="text-[#769681]">.</span></a>
            <a href="{{ route('public.news.index') }}" class="inline-flex items-center gap-2 text-xs font-bold transition hover:opacity-60"><i class="ph ph-arrow-left text-base"></i> Semua berita & agenda</a>
        </div>
    </header>

    <article>
        <div class="mx-auto w-full max-w-[1100px] px-5 pt-12 pb-8 sm:px-8 sm:pt-16 lg:pt-20">
            <div class="mb-6 flex flex-wrap items-center gap-3 text-[11px] font-bold uppercase tracking-[0.17em]">
                <span class="bg-[#183C2F] px-3 py-2 text-white">{{ $news->event_date ? 'Agenda' : 'Berita' }}</span>
                <span class="text-[#648371]">{{ $tanggal }}</span>
            </div>
            <h1 class="max-w-[1050px] text-4xl font-extrabold leading-[1.08] tracking-tight sm:text-6xl lg:text-7xl">{{ $news->title }}</h1>
            <div class="mt-8 flex flex-wrap items-center justify-between gap-3 border-t border-[#183C2F]/20 pt-5 text-xs text-[#51665B]">
                <span>Publikasi Pengurus Ranting NU Lesmana</span>
                <span>Jurnal Warga / {{ $news->event_date ? 'Agenda' : 'Berita' }}</span>
            </div>
        </div>

        {{-- Satu gambar utama, tanpa galeri tambahan. --}}
        @if($gambar)
            <figure class="mx-auto w-full max-w-[1500px] px-5 sm:px-8 lg:px-12">
                <div class="overflow-hidden bg-[#DFE6DD]">
                    <img src="{{ $gambar }}" alt="{{ $news->title }}" class="block max-h-[780px] w-full object-contain" fetchpriority="high">
                </div>
                <figcaption class="mt-3 text-xs text-[#648371]">Dokumentasi publikasi NU Lesmana.</figcaption>
            </figure>
        @endif

        <div class="mx-auto w-full max-w-[850px] px-5 pt-10 pb-20 sm:px-8 sm:pt-14 lg:pb-28">
            <div class="mb-8 flex items-center gap-3 border-b border-[#183C2F]/20 pb-5">
                <span class="h-2 w-2 rounded-full bg-[#183C2F]"></span>
                <span class="text-[10px] font-bold uppercase tracking-[0.25em]">Isi lengkap publikasi</span>
            </div>

            {{-- Gunakan escaping Blade: konten lengkap tetap aman dan paragraf asli dipertahankan. --}}
            <div class="whitespace-pre-line break-words text-base leading-[1.95] text-[#354F43] sm:text-lg">{{ $news->content }}</div>

            <div class="mt-16 flex flex-wrap items-center justify-between gap-5 border-t border-[#183C2F]/20 pt-7">
                <span class="text-xs text-[#648371]">{{ $news->created_at?->diffForHumans() ?? '' }}</span>
                <a href="{{ route('public.news.index') }}" class="inline-flex items-center gap-2 rounded-full bg-[#183C2F] px-6 py-3 text-xs font-bold text-white transition hover:bg-[#285B46]">Baca berita lainnya <i class="ph ph-arrow-up-right text-base"></i></a>
            </div>
        </div>
    </article>

    <footer class="bg-[#183C2F] text-white">
        <div class="mx-auto flex w-full max-w-[1600px] flex-wrap items-center justify-between gap-5 px-5 py-9 sm:px-8 lg:px-12">
            <div><p class="font-display text-4xl">NULESMANA.</p><p class="mt-1 text-xs text-white/65">Portal berita dan agenda warga.</p></div>
            <a href="{{ route('home') }}" class="text-xs font-bold hover:underline">Kembali ke beranda <i class="ph ph-arrow-up-right"></i></a>
        </div>
    </footer>
</div>
@endsection
