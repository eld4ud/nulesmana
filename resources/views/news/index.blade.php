@extends('layouts.public')

@section('title', 'Berita & Agenda - Nulesmana')

@section('content')
@php
    $items = collect($newsList->items())->values();
    $imgOf = fn($n) => $n->image ? \Illuminate\Support\Facades\Storage::url($n->image) : null;
    $dateOf = fn($n) => ($n->event_date ? \Carbon\Carbon::parse($n->event_date) : $n->created_at)?->translatedFormat('d M Y') ?? '-';
    $tagOf = fn($n) => $n->event_date ? 'Agenda' : 'Berita';
    $featured = $items->first();
    $secondary = $items->slice(1, 4);
    $remaining = $items->slice(5);
@endphp

<div class="min-h-screen bg-[#F5F4F0] text-[#183C2F]">
    {{-- Header tunggal, tidak ada navbar tambahan atau ruang kosong tinggi. --}}
    <header class="border-b border-[#183C2F]/20">
        <div class="mx-auto max-w-[1600px] px-5 pt-7 pb-5 sm:px-8 lg:px-12 lg:pt-9">
            <div class="flex flex-wrap items-center justify-between gap-4">
                <a href="{{ route('home') }}" class="font-display text-3xl tracking-wide sm:text-4xl" aria-label="Beranda Nulesmana">NULESMANA<span class="text-[#769681]">.</span></a>
                <a href="{{ route('home') }}" class="inline-flex items-center gap-2 text-xs font-bold transition hover:opacity-60">
                    <i class="ph ph-arrow-left text-base"></i> Kembali ke beranda
                </a>
            </div>
            <div class="mt-5 flex flex-wrap items-center justify-between gap-3 border-t border-[#183C2F]/20 pt-3 text-[10px] font-bold uppercase tracking-[0.17em]">
                <span>Jurnal Warga / Berita & Agenda</span>
                <span class="text-[#668573]">Portal Ranting NU Lesmana</span>
            </div>
        </div>
    </header>

    <main class="mx-auto w-full max-w-[1600px] px-5 sm:px-8 lg:px-12">
        <section class="py-9 sm:py-12 lg:py-14">
            <div class="flex flex-wrap items-end justify-between gap-5">
                <div>
                    <p class="mb-3 text-[10px] font-bold uppercase tracking-[0.3em] text-[#648371]">Cerita, informasi, dan kegiatan warga</p>
                    <h1 class="font-display text-[clamp(4.8rem,11vw,10.5rem)] leading-[0.82] tracking-[0.005em]">BERITA <span class="text-[#769681]">&</span><br>AGENDA<span class="text-[#769681]">.</span></h1>
                    <p class="mt-6 max-w-2xl text-sm leading-7 text-[#51665B] sm:text-base">Liputan kegiatan, pengajian, agenda, dan cerita terbaru dari warga Ranting NU Lesmana.</p>
                </div>
                <span class="mb-1 text-xs font-bold uppercase tracking-wider">{{ $newsList->total() }} publikasi</span>
            </div>
        </section>

        @if($items->isEmpty())
            <section class="border-y border-[#183C2F]/20 py-24 text-center">
                <i class="ph ph-newspaper text-5xl text-[#769681]"></i>
                <h2 class="font-display mt-5 text-4xl">BELUM ADA PUBLIKASI.</h2>
                <p class="mt-2 text-sm text-[#51665B]">Berita dan agenda terbaru akan muncul di sini setelah dipublikasikan.</p>
            </section>
        @else
            <section class="grid grid-cols-1 gap-8 border-t border-[#183C2F]/20 pt-8 pb-14 lg:grid-cols-12 lg:gap-10">
                <article class="min-w-0 lg:col-span-8">
                    <a href="{{ route('public.news.show', $featured->id) }}" class="group block">
                        <div class="relative aspect-[16/10] overflow-hidden rounded-sm bg-[#DFE6DD] sm:aspect-[16/9]">
                            @if($imgOf($featured))
                                <img src="{{ $imgOf($featured) }}" alt="{{ $featured->title }}" class="h-full w-full object-cover transition duration-700 group-hover:scale-[1.035]">
                            @else
                                <div class="flex h-full w-full items-center justify-center"><i class="ph ph-image text-6xl text-[#93A99B]"></i></div>
                            @endif
                            <span class="absolute left-4 top-4 bg-[#183C2F] px-4 py-2 text-[10px] font-bold uppercase tracking-widest text-white">Publikasi utama</span>
                        </div>
                        <div class="mt-6 flex items-center gap-3 text-[10px] font-bold uppercase tracking-[0.16em]">
                            <span>{{ $tagOf($featured) }}</span><span class="h-1 w-1 rounded-full bg-[#769681]"></span><span class="text-[#648371]">{{ $dateOf($featured) }}</span>
                        </div>
                        <h2 class="mt-3 text-3xl font-extrabold leading-tight tracking-tight transition group-hover:text-[#668573] sm:text-5xl">{{ $featured->title }}</h2>
                        <p class="mt-4 max-w-3xl text-sm leading-7 text-[#51665B]">{{ \Illuminate\Support\Str::limit(strip_tags($featured->content), 240) }}</p>
                        <span class="mt-5 inline-flex items-center gap-2 text-xs font-extrabold uppercase tracking-wide">Baca artikel lengkap <i class="ph ph-arrow-up-right text-lg transition group-hover:translate-x-1 group-hover:-translate-y-1"></i></span>
                    </a>
                </article>

                <aside class="min-w-0 border-t border-[#183C2F]/20 pt-7 lg:col-span-4 lg:border-t-0 lg:border-l lg:pt-0 lg:pl-8">
                    <div class="flex items-center justify-between border-b border-[#183C2F]/20 pb-4">
                        <h2 class="font-display text-3xl">KABAR LAINNYA</h2><i class="ph ph-list text-xl"></i>
                    </div>
                    @forelse($secondary as $item)
                        <article class="border-b border-[#183C2F]/15 py-5">
                            <a href="{{ route('public.news.show', $item->id) }}" class="group grid grid-cols-[105px_minmax(0,1fr)] gap-4 sm:grid-cols-[145px_minmax(0,1fr)] lg:grid-cols-[100px_minmax(0,1fr)] xl:grid-cols-[140px_minmax(0,1fr)]">
                                <div class="aspect-[4/3] overflow-hidden bg-[#DFE6DD]">
                                    @if($imgOf($item))
                                        <img src="{{ $imgOf($item) }}" alt="{{ $item->title }}" loading="lazy" class="h-full w-full object-cover transition duration-500 group-hover:scale-105">
                                    @else
                                        <div class="flex h-full items-center justify-center"><i class="ph ph-image text-3xl text-[#93A99B]"></i></div>
                                    @endif
                                </div>
                                <div class="min-w-0">
                                    <p class="text-[10px] font-bold uppercase tracking-widest text-[#648371]">{{ $tagOf($item) }} · {{ $dateOf($item) }}</p>
                                    <h3 class="mt-2 text-sm font-extrabold leading-snug transition group-hover:text-[#668573] sm:text-base">{{ $item->title }}</h3>
                                </div>
                            </a>
                        </article>
                    @empty
                        <p class="py-6 text-sm text-[#51665B]">Belum ada publikasi lainnya.</p>
                    @endforelse
                    <div class="mt-7 bg-[#183C2F] p-6 text-white">
                        <p class="font-display text-4xl">NULESMANA.</p>
                        <p class="mt-2 text-xs leading-6 text-white/75">Ruang informasi dan dokumentasi kegiatan warga Ranting NU Lesmana.</p>
                        <a href="{{ route('home') }}" class="mt-5 inline-flex items-center gap-2 text-xs font-bold">Kunjungi beranda <i class="ph ph-arrow-up-right"></i></a>
                    </div>
                </aside>
            </section>

            @if($remaining->isNotEmpty())
                <section class="border-t border-[#183C2F]/20 py-10 sm:py-14">
                    <p class="text-[10px] font-bold uppercase tracking-[0.2em] text-[#648371]">Jelajahi lebih lanjut</p>
                    <h2 class="font-display mt-2 mb-8 text-5xl sm:text-6xl">PUBLIKASI LAINNYA.</h2>
                    <div class="grid grid-cols-1 gap-x-7 gap-y-10 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4">
                        @foreach($remaining as $item)
                            <article>
                                <a href="{{ route('public.news.show', $item->id) }}" class="group block">
                                    <div class="aspect-[16/10] overflow-hidden bg-[#DFE6DD]">
                                        @if($imgOf($item))
                                            <img src="{{ $imgOf($item) }}" alt="{{ $item->title }}" loading="lazy" class="h-full w-full object-cover transition duration-500 group-hover:scale-105">
                                        @else
                                            <div class="flex h-full items-center justify-center"><i class="ph ph-image text-4xl text-[#93A99B]"></i></div>
                                        @endif
                                    </div>
                                    <p class="mt-4 text-[10px] font-bold uppercase tracking-widest text-[#648371]">{{ $tagOf($item) }} · {{ $dateOf($item) }}</p>
                                    <h3 class="mt-2 text-lg font-extrabold leading-snug transition group-hover:text-[#668573]">{{ $item->title }}</h3>
                                    <p class="mt-2 text-sm leading-6 text-[#51665B]">{{ \Illuminate\Support\Str::limit(strip_tags($item->content), 120) }}</p>
                                </a>
                            </article>
                        @endforeach
                    </div>
                </section>
            @endif
            @if($newsList->hasPages())
                <div class="border-t border-[#183C2F]/20 py-8">{{ $newsList->links() }}</div>
            @endif
        @endif
    </main>

    <footer class="mt-12 bg-[#183C2F] text-white">
        <div class="mx-auto max-w-[1600px] px-5 py-10 sm:px-8 lg:px-12">
            <div class="flex flex-wrap items-start justify-between gap-6">
                <div><p class="font-display text-4xl">NULESMANA.</p><p class="mt-2 text-xs text-white/65">Portal berita dan agenda warga Ranting NU Lesmana.</p></div>
                <a href="{{ route('home') }}" class="inline-flex items-center gap-2 text-xs font-bold"><i class="ph ph-arrow-left"></i> Kembali ke beranda</a>
            </div>
            <p class="mt-8 border-t border-white/20 pt-5 text-[11px] text-white/55">© {{ date('Y') }} Nulesmana. Seluruh hak cipta dilindungi.</p>
        </div>
    </footer>
</div>
@endsection
