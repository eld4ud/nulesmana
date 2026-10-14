
@extends('layouts.public')

@section('title', $news->title . ' - Nulesmana')

@section('content')
@php
    $tanggal = $news->event_date
        ? \Carbon\Carbon::parse($news->event_date)->translatedFormat('d F Y')
        : ($news->created_at?->translatedFormat('d F Y') ?? '-');

    $gambar = $news->image
        ? \Illuminate\Support\Facades\Storage::url($news->image)
        : null;
@endphp

<div class="min-h-screen bg-white text-neutral-950">
    <article class="max-w-4xl mx-auto px-5 sm:px-8 py-10 sm:py-16">

        {{-- Navigasi kembali --}}
        <div class="flex items-center justify-between gap-4 mb-10">
            <a href="{{ route('public.news.index') }}"
               class="inline-flex items-center gap-2 text-sm font-semibold text-neutral-600 hover:text-black transition">
                <i class="ph ph-arrow-left text-lg"></i>
                Semua berita
            </a>

            <span class="text-xs font-bold uppercase tracking-[0.2em] text-neutral-400">
                Nulesmana / Berita
            </span>
        </div>

        {{-- Informasi artikel --}}
        <header class="border-b border-neutral-200 pb-8">
            <div class="flex flex-wrap items-center gap-3 mb-5">
                <span class="px-3 py-1 bg-neutral-950 text-white text-[10px] font-bold uppercase tracking-widest">
                    {{ $news->event_date ? 'Agenda' : 'Berita' }}
                </span>

                <span class="text-xs text-neutral-500">
                    {{ $tanggal }}
                </span>
            </div>

            <h1 class="text-3xl sm:text-5xl lg:text-6xl font-black tracking-tight leading-[1.1]">
                {{ $news->title }}
            </h1>

            <p class="mt-5 text-sm text-neutral-500">
                Dipublikasikan oleh Pengurus Ranting NU Pasiraman Lor
            </p>
        </header>

        {{-- Gambar utama --}}
        @if($gambar)
            <figure class="mt-8 mb-10">
                <img
                    src="{{ $gambar }}"
                    alt="{{ $news->title }}"
                    class="w-full max-h-[560px] object-cover"
                >
                <figcaption class="mt-3 text-xs text-neutral-500">
                    Dokumentasi kegiatan Ranting NU Pasiraman Lor.
                </figcaption>
            </figure>
        @endif

        {{-- Isi berita --}}
        <div class="max-w-3xl mx-auto">
            <div class="text-base sm:text-lg leading-8 text-neutral-700 whitespace-pre-line break-words">
                {{ $news->content }}
            </div>

            <div class="mt-12 pt-6 border-t border-neutral-200 flex flex-wrap justify-between items-center gap-4">
                <span class="text-xs text-neutral-500">
                    {{ $news->created_at?->diffForHumans() ?? '' }}
                </span>

                <a href="{{ route('public.news.index') }}"
                   class="inline-flex items-center gap-2 text-sm font-bold hover:underline underline-offset-4">
                    Baca berita lainnya
                    <i class="ph ph-arrow-up-right text-lg"></i>
                </a>
            </div>
        </div>
    </article>
</div>
@endsection
