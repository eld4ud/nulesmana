@extends('layouts.public')
@section('title', 'Berita & Agenda | Nulesmana')
@push('styles')
<style>
.news-page{--forest:#183C2F;--ivory:#F5F4F0;--muted:#66766B;--line:#D6DDD4;background:var(--ivory);color:var(--forest);font-family:'DM Sans',sans-serif}
.news-page *{box-sizing:border-box}
.news-page a{color:inherit;text-decoration:none}
.news-page input,.news-page button{font-family:inherit}
.news-wrap{width:min(100% - 40px,1240px);margin:auto}
.news-display{font-family:'Bebas Neue',Impact,sans-serif;font-weight:400;letter-spacing:.012em}
.news-header{border-bottom:1px solid var(--line)}
.news-head-main{display:flex;align-items:center;justify-content:space-between;gap:18px;padding:28px 0 22px}
.news-logo{font-family:'Bebas Neue',Impact,sans-serif;font-size:35px;line-height:1;letter-spacing:.02em}
.news-logo span,.news-heading span{color:#83A18B}
.news-back{font-size:12px;font-weight:700;text-decoration:none}
.news-back:hover,.news-page a:hover .news-story-title{color:#4C765C}
.news-head-meta{display:flex;justify-content:space-between;gap:15px;border-top:1px solid var(--line);padding:12px 0;font-size:10px;font-weight:800;letter-spacing:.17em;text-transform:uppercase}
.news-head-meta span:last-child{color:var(--muted)}
.news-intro{padding:48px 0 35px;border-bottom:1px solid var(--line)}
.news-eyebrow{font-size:10px;font-weight:800;letter-spacing:.2em;text-transform:uppercase;color:#688472}
.news-heading{font-size:clamp(70px,10vw,132px);line-height:.84;margin:15px 0 0}
.news-intro-bottom{display:flex;align-items:end;justify-content:space-between;gap:20px;margin-top:22px}
.news-intro-bottom p{max-width:570px;font-size:14px;line-height:1.8;color:var(--muted)}
.news-count{flex-shrink:0;font-size:11px;font-weight:800;letter-spacing:.08em;text-transform:uppercase}
.news-toolbar{display:flex;align-items:center;justify-content:space-between;gap:20px;padding:24px 0;border-bottom:1px solid var(--line)}
.news-toolbar h2{font-size:28px;line-height:1;margin:0}
.news-search{display:flex;width:min(100%,430px);background:#fff;border:1px solid #B8C9BC}
.news-search:focus-within{outline:2px solid #A0B9A6;outline-offset:2px}
.news-search input{flex:1;min-width:0;border:0;outline:0;padding:13px 14px;background:transparent;color:var(--forest);font-size:13px}
.news-search button{border:0;padding:0 19px;background:var(--forest);color:#fff;font-size:12px;font-weight:700;cursor:pointer}
.news-search button:hover,.news-page-btn.active{background:#285440}
.news-search-note{display:flex;flex-wrap:wrap;gap:12px;align-items:center;padding-top:17px;font-size:12px;color:var(--muted)}
.news-search-note a{font-weight:800;text-decoration:underline}
.news-lead-layout{display:grid;grid-template-columns:minmax(0,1.7fr) minmax(0,1fr);gap:38px;padding:33px 0 43px;border-bottom:1px solid var(--line)}
.news-picture{display:block;width:100%;overflow:hidden;background:#E1E8DF}
.news-picture img{display:block;width:100%;height:100%;object-fit:cover;transition:transform .4s ease}
.news-page a:hover .news-picture img{transform:scale(1.025)}
.news-picture-empty{display:flex;align-items:center;justify-content:center;width:100%;height:100%;min-height:110px;color:#84998A;font-size:27px}
.news-lead-picture{aspect-ratio:16/10}
.news-meta{display:flex;flex-wrap:wrap;align-items:center;gap:9px;color:var(--muted);font-size:10px;font-weight:800;letter-spacing:.1em;text-transform:uppercase}
.news-meta .news-type{color:var(--forest)}
.news-meta .news-dot{height:4px;width:4px;border-radius:50%;background:#9AAB9D}
.news-lead .news-meta{margin-top:20px}
.news-story-title{margin:0;color:var(--forest);overflow-wrap:anywhere;transition:color .2s ease}
.news-lead-title{margin-top:9px;font-size:clamp(26px,3vw,42px);font-weight:800;letter-spacing:-.04em;line-height:1.2}
.news-excerpt{color:var(--muted);font-size:13px;line-height:1.8}
.news-lead-excerpt{margin-top:12px;max-width:700px}
.news-read-more{display:inline-block;margin-top:17px;border-bottom:1px solid var(--forest);padding-bottom:5px;font-size:11px;font-weight:800;text-transform:uppercase;letter-spacing:.04em}
.news-side{min-width:0;padding-left:32px;border-left:1px solid var(--line)}
.news-side>h2{margin:0;padding-bottom:14px;border-bottom:1px solid var(--line);font-size:28px}
.news-side article{padding:19px 0;border-bottom:1px solid var(--line)}
.news-side-link{display:grid;grid-template-columns:125px minmax(0,1fr);gap:15px;align-items:start}
.news-side-picture{aspect-ratio:4/3}
.news-side-title{margin-top:8px;font-size:14px;font-weight:800;line-height:1.4}
.news-section{padding:38px 0 44px}
.news-section-top{display:flex;justify-content:space-between;align-items:baseline;gap:15px;margin-bottom:24px}
.news-section-top h2{font-size:38px;line-height:1;margin:0}
.news-section-top small{font-size:11px;color:var(--muted)}
.news-grid{display:grid;grid-template-columns:repeat(3,minmax(0,1fr));gap:35px 23px}
.news-grid article{min-width:0}
.news-grid-picture{aspect-ratio:16/10}
.news-grid .news-meta{margin-top:14px}
.news-grid-title{font-size:18px;font-weight:800;line-height:1.4;letter-spacing:-.02em;margin-top:9px}
.news-grid .news-excerpt{margin-top:8px}
.news-empty{text-align:center;padding:85px 15px}
.news-empty h2{font-size:47px;line-height:1;margin:0 0 12px}
.news-empty p{max-width:480px;margin:auto;color:var(--muted);font-size:13px;line-height:1.8}
.news-empty a{display:inline-block;margin-top:21px;border-bottom:1px solid var(--forest);font-size:12px;font-weight:800;padding-bottom:5px}
.news-pagination{border-top:1px solid var(--line);padding:27px 0 56px}
.news-pagination>p{text-align:center;color:var(--muted);font-size:12px;margin:0 0 17px}
.news-page-links{display:flex;justify-content:center;gap:7px;flex-wrap:wrap}
.news-page-btn{min-width:38px;height:38px;display:inline-flex;align-items:center;justify-content:center;padding:0 11px;border:1px solid #BECDBF;font-size:12px;font-weight:800}
.news-page-btn.active{background:var(--forest);border-color:var(--forest);color:white}
.news-page-btn.disabled{opacity:.35}
.news-page-btn:not(.active):not(.disabled):hover{background:#E1E9E1}
.news-ellipsis{padding:10px 3px;color:var(--muted);font-size:12px}
.news-footer{padding:40px 0 24px;background:var(--forest);color:#fff}
.news-footer-row{display:flex;justify-content:space-between;gap:25px;align-items:start}
.news-footer-brand{font-size:38px;line-height:1;margin:0}
.news-footer p{font-size:12px;color:#CAD7CD;margin-top:11px}
.news-footer a{font-size:12px;font-weight:700}
.news-copyright{border-top:1px solid #FFFFFF30;padding-top:16px;margin-top:35px;font-size:10px;color:#C5D4C8}
@media(max-width:900px){.news-lead-layout{grid-template-columns:1fr}.news-side{border-left:0;border-top:1px solid var(--line);padding-left:0;padding-top:22px}.news-side-link{grid-template-columns:150px minmax(0,1fr)}.news-grid{grid-template-columns:repeat(2,minmax(0,1fr))}}
@media(max-width:600px){.news-wrap{width:min(100% - 30px,1240px)}.news-head-main{padding:22px 0 17px}.news-logo{font-size:30px}.news-head-meta span:last-child{display:none}.news-intro{padding:37px 0 28px}.news-heading{font-size:clamp(66px,17vw,95px)}.news-intro-bottom{align-items:start;flex-direction:column;gap:8px}.news-intro-bottom p{font-size:13px}.news-toolbar{align-items:stretch;flex-direction:column;gap:13px}.news-search{width:100%}.news-side-link{grid-template-columns:108px minmax(0,1fr)}.news-grid{grid-template-columns:1fr}.news-section-top h2{font-size:32px}.news-footer-row{flex-direction:column}.news-lead-title{font-size:30px}}
@media(prefers-reduced-motion:reduce){.news-page *{transition:none!important}}
</style>
@endpush
@section('content')
@php
    $items = collect($newsList->items())->values();
    $search = trim((string) ($search ?? request('search', '')));
    $firstPage = $newsList->currentPage() === 1 && $search === '';
    $featured = $firstPage ? $items->first() : null;
    $sideItems = $firstPage ? $items->slice(1, 2) : collect();
    $gridItems = $firstPage ? $items->slice(3) : $items;
    $picture = function ($item) {
        $path = trim((string) ($item->image ?? ''));
        if ($path === '') return null;
        if (\Illuminate\Support\Str::startsWith($path, ['http://', 'https://', '/'])) return $path;
        if (\Illuminate\Support\Str::startsWith($path, 'storage/')) return asset($path);
        return \Illuminate\Support\Facades\Storage::disk('public')->url($path);
    };
    $published = fn ($item) => ($item->event_date ?: $item->created_at) ? \Carbon\Carbon::parse($item->event_date ?: $item->created_at)->translatedFormat('d M Y') : '-';
    $type = fn ($item) => $item->event_date ? 'Agenda' : 'Berita';
    $summary = fn ($item, $limit) => \Illuminate\Support\Str::limit(trim(preg_replace('/\s+/u', ' ', strip_tags((string) ($item->content ?? '')))), $limit);
    $current = $newsList->currentPage();
    $last = $newsList->lastPage();
    $startPage = max(1, $current - 2);
    $endPage = min($last, $current + 2);
@endphp
<div class="news-page">
    <header class="news-header">
        <div class="news-wrap">
            <div class="news-head-main">
                <a href="{{ route('home') }}" class="news-logo" aria-label="Beranda Nulesmana">NULESMANA<span>.</span></a>
                <a href="{{ route('home') }}" class="news-back">← Kembali ke beranda</a>
            </div>
            <div class="news-head-meta"><span>Jurnal Warga / Berita & Agenda</span><span>Portal Ranting NU Lesmana</span></div>
        </div>
    </header>
    <main class="news-wrap">
        <section class="news-intro">
            <p class="news-eyebrow">Cerita, informasi, dan kegiatan warga</p>
            <h1 class="news-heading news-display">BERITA <span>&</span><br>AGENDA<span>.</span></h1>
            <div class="news-intro-bottom">
                <p>Liputan kegiatan, pengajian, agenda, dan informasi terbaru dari warga Ranting NU Lesmana.</p>
                <span class="news-count">{{ $newsList->total() }} publikasi</span>
            </div>
        </section>
        <section class="news-toolbar" aria-label="Pencarian berita">
            <h2 class="news-display">JELAJAHI PUBLIKASI</h2>
            <form method="GET" action="{{ route('public.news.index') }}" class="news-search" role="search">
                <input type="search" name="search" value="{{ $search }}" maxlength="100" placeholder="Cari berita atau agenda..." aria-label="Cari berita">
                <button type="submit">Cari</button>
            </form>
        </section>
        @if($search !== '')
            <div class="news-search-note"><span>Hasil untuk <strong>“{{ $search }}”</strong>: {{ $newsList->total() }} publikasi</span><a href="{{ route('public.news.index') }}">Hapus pencarian</a></div>
        @endif
        @if($featured)
            <section class="news-lead-layout" aria-label="Publikasi utama">
                <article class="news-lead">
                    <a href="{{ route('public.news.show', $featured->id) }}" class="news-story">
                        <div class="news-picture news-lead-picture">
                            @if($picture($featured))<img src="{{ $picture($featured) }}" alt="{{ $featured->title }}" fetchpriority="high">
                            @else<div class="news-picture-empty" aria-hidden="true">▧</div>@endif
                        </div>
                        <div class="news-meta"><span class="news-type">{{ $type($featured) }}</span><span class="news-dot"></span><span>{{ $published($featured) }}</span></div>
                        <h2 class="news-story-title news-lead-title">{{ $featured->title }}</h2>
                        <p class="news-excerpt news-lead-excerpt">{{ $summary($featured, 210) }}</p>
                        <span class="news-read-more">Baca artikel lengkap ↗</span>
                    </a>
                </article>
                <aside class="news-side">
                    <h2 class="news-display">KABAR LAINNYA</h2>
                    @forelse($sideItems as $item)
                        <article>
                            <a href="{{ route('public.news.show', $item->id) }}" class="news-side-link news-story">
                                <div class="news-picture news-side-picture">
                                    @if($picture($item))<img src="{{ $picture($item) }}" alt="{{ $item->title }}" loading="lazy">
                                    @else<div class="news-picture-empty" aria-hidden="true">▧</div>@endif
                                </div>
                                <div><div class="news-meta"><span class="news-type">{{ $type($item) }}</span><span>{{ $published($item) }}</span></div><h3 class="news-story-title news-side-title">{{ $item->title }}</h3></div>
                            </a>
                        </article>
                    @empty
                        <p class="news-excerpt" style="margin-top:18px">Berita berikutnya akan tampil di sini.</p>
                    @endforelse
                </aside>
            </section>
        @endif
        @if($gridItems->isNotEmpty())
            <section class="news-section" aria-label="Daftar publikasi">
                <div class="news-section-top">
                    <h2 class="news-display">{{ $search !== '' ? 'HASIL PENCARIAN' : ($current > 1 ? 'ARSIP PUBLIKASI' : 'PUBLIKASI TERBARU') }}</h2>
                    <small>Halaman {{ $current }} dari {{ $last }}</small>
                </div>
                <div class="news-grid">
                    @foreach($gridItems as $item)
                        <article>
                            <a href="{{ route('public.news.show', $item->id) }}" class="news-story">
                                <div class="news-picture news-grid-picture">
                                    @if($picture($item))<img src="{{ $picture($item) }}" alt="{{ $item->title }}" loading="lazy">
                                    @else<div class="news-picture-empty" aria-hidden="true">▧</div>@endif
                                </div>
                                <div class="news-meta"><span class="news-type">{{ $type($item) }}</span><span class="news-dot"></span><span>{{ $published($item) }}</span></div>
                                <h3 class="news-story-title news-grid-title">{{ $item->title }}</h3>
                                <p class="news-excerpt">{{ $summary($item, 110) }}</p>
                            </a>
                        </article>
                    @endforeach
                </div>
            </section>
        @elseif(!$featured)
            <section class="news-empty">
                <h2 class="news-display">{{ $search !== '' ? 'BERITA TIDAK DITEMUKAN.' : 'BELUM ADA PUBLIKASI.' }}</h2>
                <p>{{ $search !== '' ? 'Tidak ada berita atau agenda yang sesuai. Coba kata kunci lainnya.' : 'Berita dan agenda kegiatan akan muncul setelah pengurus memublikasikannya.' }}</p>
                @if($search !== '')<a href="{{ route('public.news.index') }}">Lihat semua berita →</a>@endif
            </section>
        @endif
        @if($newsList->hasPages())
            <nav class="news-pagination" aria-label="Navigasi halaman berita">
                <p>Menampilkan {{ $newsList->firstItem() }}–{{ $newsList->lastItem() }} dari {{ $newsList->total() }} publikasi</p>
                <div class="news-page-links">
                    @if($newsList->onFirstPage())<span class="news-page-btn disabled" aria-disabled="true">←</span>
                    @else<a class="news-page-btn" href="{{ $newsList->previousPageUrl() }}" aria-label="Halaman sebelumnya">←</a>@endif
                    @if($startPage > 1)
                        <a class="news-page-btn" href="{{ $newsList->url(1) }}">1</a>
                        @if($startPage > 2)<span class="news-ellipsis">…</span>@endif
                    @endif
                    @for($page = $startPage; $page <= $endPage; $page++)
                        @if($page === $current)<span class="news-page-btn active" aria-current="page">{{ $page }}</span>
                        @else<a class="news-page-btn" href="{{ $newsList->url($page) }}">{{ $page }}</a>@endif
                    @endfor
                    @if($endPage < $last)
                        @if($endPage < $last - 1)<span class="news-ellipsis">…</span>@endif
                        <a class="news-page-btn" href="{{ $newsList->url($last) }}">{{ $last }}</a>
                    @endif
                    @if($newsList->hasMorePages())<a class="news-page-btn" href="{{ $newsList->nextPageUrl() }}" aria-label="Halaman berikutnya">→</a>
                    @else<span class="news-page-btn disabled" aria-disabled="true">→</span>@endif
                </div>
            </nav>
        @endif
    </main>
    <footer class="news-footer">
        <div class="news-wrap">
            <div class="news-footer-row">
                <div><h2 class="news-footer-brand news-display">NULESMANA.</h2><p>Portal berita dan agenda warga Ranting NU Lesmana.</p></div>
                <a href="{{ route('home') }}">← Kembali ke beranda</a>
            </div>
            <div class="news-copyright">© {{ date('Y') }} NU Lesmana. Seluruh hak dilindungi.</div>
        </div>
    </footer>
</div>
@endsection
