
@extends('layouts.public')

@section('title', 'Berita - Nulesmana')

@section('content')
@php
    $items = collect($newsList->items())->values();

    $imgOf = fn($n) => $n->image
        ? \Illuminate\Support\Facades\Storage::url($n->image)
        : null;

    $dateOf = fn($n) => (
        $n->event_date
            ? \Carbon\Carbon::parse($n->event_date)
            : $n->created_at
    )?->translatedFormat('d M Y') ?? '-';

    $tagOf = fn($n) => $n->event_date ? 'Agenda' : 'Berita';
@endphp

<div class="min-h-screen bg-white text-neutral-950">

    {{-- HEADER BERITA --}}
    <header class="border-b border-neutral-200">
        <div class="max-w-[1440px] mx-auto px-5 lg:px-10">
            <div class="flex items-center justify-between py-5 border-b border-neutral-200">
                <a href="{{ url('/') }}"
                   class="text-2xl sm:text-3xl font-black tracking-tighter">
                    ■ NEWS<span class="text-neutral-400">.</span>
                </a>

                <nav class="hidden md:flex items-center gap-7 text-xs font-bold">
                    <a href="{{ url('/news') }}" class="hover:text-neutral-500">Berita</a>
                    <a href="{{ url('/news') }}" class="hover:text-neutral-500">Agenda</a>
                    <a href="{{ url('/') }}" class="hover:text-neutral-500">Beranda</a>
                </nav>
            </div>

            <div class="flex items-center justify-between gap-4 py-3 text-[10px] sm:text-xs">
                <span class="font-bold uppercase tracking-[0.16em]">
                    Nulesmana / Portal Warga
                </span>
                <span class="text-neutral-500">
                    Ranting NU Pasiraman Lor
                </span>
            </div>
        </div>
    </header>

    <main class="max-w-[1440px] mx-auto px-5 lg:px-10">

        {{-- JUDUL HALAMAN --}}
        <section class="py-8 sm:py-10">
            <div class="flex items-end justify-between gap-5">
                <div>
                    <p class="text-[10px] font-bold uppercase tracking-[0.25em] text-neutral-500 mb-3">
                        Informasi dan kabar terbaru
                    </p>
                    <h1 class="text-4xl sm:text-6xl font-black tracking-[-0.06em] leading-none">
                        Latest Stories<span class="text-neutral-400">.</span>
                    </h1>
                    <p class="mt-4 text-sm text-neutral-600 max-w-xl leading-6">
                        Liputan kegiatan, pengajian, agenda, dan cerita warga
                        Ranting NU Pasiraman Lor.
                    </p>
                </div>

                <span class="hidden sm:block text-xs text-neutral-500 whitespace-nowrap">
                    {{ $newsList->total() }} publikasi
                </span>
            </div>
        </section>

        @if($items->isEmpty())

            <section class="py-24 text-center border-y border-neutral-200">
                <i class="ph ph-newspaper text-5xl text-neutral-400"></i>
                <h2 class="text-xl font-bold mt-4">Belum ada berita</h2>
                <p class="text-sm text-neutral-500 mt-2">
                    Publikasi terbaru akan muncul di sini.
                </p>
            </section>

        @else

            @php
                $featured = $items->first();
                $secondary = $items->slice(1, 4);
                $remaining = $items->slice(5);
            @endphp

            {{-- EDITORIAL GRID --}}
            <section class="grid grid-cols-1 lg:grid-cols-12 gap-7 lg:gap-8 pb-12">

                {{-- BERITA UTAMA --}}
                <article class="lg:col-span-7 min-w-0">
                    <a href="{{ url('/news/' . $featured->id) }}"
                       class="group block">

                        <div class="aspect-[16/10] bg-neutral-100 overflow-hidden">
                            @if($imgOf($featured))
                                <img
                                    src="{{ $imgOf($featured) }}"
                                    alt="{{ $featured->title }}"
                                    class="w-full h-full object-cover group-hover:scale-[1.02] transition duration-500"
                                >
                            @else
                                <div class="w-full h-full flex items-center justify-center">
                                    <i class="ph ph-image text-5xl text-neutral-300"></i>
                                </div>
                            @endif
                        </div>

                        <div class="pt-5">
                            <div class="flex items-center gap-3 text-[10px] font-bold uppercase tracking-[0.15em]">
                                <span class="text-neutral-900">{{ $tagOf($featured) }}</span>
                                <span class="w-1 h-1 bg-neutral-400 rounded-full"></span>
                                <span class="text-neutral-500">{{ $dateOf($featured) }}</span>
                            </div>

                            <h2 class="mt-3 text-3xl sm:text-4xl xl:text-5xl font-black leading-[1.08] tracking-[-0.045em] group-hover:text-neutral-500 transition">
                                {{ $featured->title }}
                            </h2>

                            <p class="mt-4 text-sm leading-7 text-neutral-600 max-w-2xl">
                                {{ \Illuminate\Support\Str::limit(strip_tags($featured->content), 230) }}
                            </p>

                            <span class="inline-flex items-center gap-2 mt-5 text-xs font-bold">
                                Baca selengkapnya
                                <i class="ph ph-arrow-up-right text-base"></i>
                            </span>
                        </div>
                    </a>
                </article>

                {{-- BERITA SAMPING --}}
                <aside class="lg:col-span-5 border-t lg:border-t-0 lg:border-l border-neutral-200 pt-6 lg:pt-0 lg:pl-7">

                    <div class="flex items-center justify-between pb-4 border-b border-neutral-200">
                        <h2 class="text-sm font-black uppercase tracking-wider">
                            Top Stories
                        </h2>
                        <i class="ph ph-list text-lg"></i>
                    </div>

                    @if($secondary->isNotEmpty())
                        <div class="divide-y divide-neutral-200">
                            @foreach($secondary as $item)
                                <article class="py-5 first:pt-5">
                                    <a href="{{ url('/news/' . $item->id) }}"
                                       class="group grid grid-cols-[112px_minmax(0,1fr)] sm:grid-cols-[135px_minmax(0,1fr)] gap-4">

                                        <div class="aspect-[4/3] bg-neutral-100 overflow-hidden">
                                            @if($imgOf($item))
                                                <img
                                                    src="{{ $imgOf($item) }}"
                                                    alt="{{ $item->title }}"
                                                    loading="lazy"
                                                    class="w-full h-full object-cover group-hover:scale-105 transition duration-500"
                                                >
                                            @else
                                                <div class="w-full h-full flex items-center justify-center">
                                                    <i class="ph ph-image text-3xl text-neutral-300"></i>
                                                </div>
                                            @endif
                                        </div>

                                        <div class="min-w-0">
                                            <p class="text-[10px] font-bold uppercase tracking-[0.13em] text-neutral-500">
                                                {{ $tagOf($item) }}
                                            </p>

                                            <h3 class="mt-2 text-sm sm:text-base font-bold leading-snug group-hover:text-neutral-500 transition">
                                                {{ $item->title }}
                                            </h3>

                                            <p class="mt-2 text-[10px] text-neutral-500">
                                                {{ $dateOf($item) }}
                                            </p>
                                        </div>
                                    </a>
                                </article>
                            @endforeach
                        </div>
                    @else
                        <p class="py-6 text-sm text-neutral-500">
                            Belum ada publikasi lainnya.
                        </p>
                    @endif

                    {{-- IDENTITAS PORTAL --}}
                    <div class="mt-5 border border-neutral-200 p-5">
                        <p class="text-lg font-black tracking-tight">
                            NULESMANA<span class="text-neutral-400">.</span>
                        </p>
                        <p class="text-xs leading-6 text-neutral-600 mt-2">
                            Portal informasi dan dokumentasi warga
                            Ranting NU Pasiraman Lor.
                        </p>
                        <a href="{{ url('/') }}"
                           class="inline-flex items-center gap-2 text-xs font-bold mt-4 hover:underline">
                            Kunjungi beranda
                            <i class="ph ph-arrow-up-right"></i>
                        </a>
                    </div>
                </aside>
            </section>

            {{-- PUBLIKASI LAINNYA --}}
            @if($remaining->isNotEmpty())
                <section class="border-t border-neutral-300 pt-8 pb-12">
                    <div class="flex items-end justify-between gap-4 mb-7">
                        <div>
                            <p class="text-[10px] uppercase tracking-[0.2em] text-neutral-500 font-bold">
                                Jelajahi lebih lanjut
                            </p>
                            <h2 class="text-2xl sm:text-3xl font-black tracking-tight mt-2">
                                Latest Stories
                            </h2>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-x-6 gap-y-9">
                        @foreach($remaining as $item)
                            <article class="group min-w-0">
                                <a href="{{ url('/news/' . $item->id) }}"
                                   class="block">

                                    <div class="aspect-[16/10] bg-neutral-100 overflow-hidden">
                                        @if($imgOf($item))
                                            <img
                                                src="{{ $imgOf($item) }}"
                                                alt="{{ $item->title }}"
                                                loading="lazy"
                                                class="w-full h-full object-cover group-hover:scale-105 transition duration-500"
                                            >
                                        @else
                                            <div class="w-full h-full flex items-center justify-center">
                                                <i class="ph ph-image text-4xl text-neutral-300"></i>
                                            </div>
                                        @endif
                                    </div>

                                    <p class="mt-4 text-[10px] font-bold uppercase tracking-[0.15em] text-neutral-500">
                                        {{ $tagOf($item) }} · {{ $dateOf($item) }}
                                    </p>

                                    <h3 class="mt-2 text-lg font-bold leading-snug group-hover:text-neutral-500 transition">
                                        {{ $item->title }}
                                    </h3>

                                    <p class="mt-2 text-sm leading-6 text-neutral-600">
                                        {{ \Illuminate\Support\Str::limit(strip_tags($item->content), 110) }}
                                    </p>
                                </a>
                            </article>
                        @endforeach
                    </div>
                </section>
            @endif

            {{-- PAGINATION --}}
            @if($newsList->hasPages())
                <div class="border-t border-neutral-200 py-7">
                    {{ $newsList->links() }}
                </div>
            @endif

        @endif
    </main>

    {{-- FOOTER --}}
    <footer class="bg-neutral-950 text-white mt-6">
        <div class="max-w-[1440px] mx-auto px-5 lg:px-10 py-9">
            <div class="flex flex-col sm:flex-row justify-between gap-5">
                <div>
                    <p class="text-xl font-black tracking-tight">
                        NULESMANA<span class="text-neutral-400">.</span>
                    </p>
                    <p class="text-xs text-neutral-400 mt-2">
                        Portal Resmi Warga Ranting NU Pasiraman Lor
                    </p>
                </div>

                <a href="{{ url('/') }}"
                   class="text-xs text-neutral-300 hover:text-white">
                    ← Kembali ke beranda
                </a>
            </div>

            <div class="border-t border-neutral-800 mt-7 pt-5 text-[10px] text-neutral-500">
                © {{ date('Y') }} Nulesmana. Seluruh hak cipta dilindungi.
            </div>
        </div>
    </footer>
</div>
@endsection
