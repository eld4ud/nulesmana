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

/* Navbar di semua halaman memakai komponen yang sama dengan beranda. */
.news-page{padding-top:104px}
.news-topline{display:flex;justify-content:space-between;align-items:center;gap:16px;padding:18px 0;border-bottom:1px solid var(--line)}
.news-topline a{display:inline-flex;align-items:center;gap:8px;font-size:12px;font-weight:750}
.news-topline span{font-size:10px;font-weight:750;letter-spacing:.16em;text-transform:uppercase;color:var(--muted)}
.news-intro{padding:53px 0 43px}
.news-heading{font-size:clamp(66px,9vw,115px);line-height:.88}
.news-search-shell{position:relative;width:min(100%,540px);z-index:30}
.news-search{width:100%;height:58px;display:flex;align-items:center;gap:9px;border:1px solid #CDD9CD;background:#FFFFFF;border-radius:999px;padding:6px 7px 6px 19px;box-shadow:0 5px 25px rgba(24,60,47,.04);transition:border-color .2s ease,box-shadow .2s ease}
.news-search:focus-within{outline:none;border-color:#6C937A;box-shadow:0 0 0 4px rgba(24,60,47,.08)}
.news-search-icon{font-size:21px;color:#668674;flex-shrink:0}
.news-search input{flex:1;min-width:0;border:0;outline:0;background:transparent;color:var(--forest);font-size:13px;padding:8px 0}
.news-search input::-webkit-search-cancel-button{cursor:pointer}
.news-search button{display:inline-flex;align-items:center;justify-content:center;height:44px;min-width:78px;padding:0 20px;background:var(--forest);color:#fff;border:0;border-radius:999px;cursor:pointer;font-size:12px;font-weight:800;transition:background .2s ease}
.news-search button:hover{background:#285440}
.news-suggest[hidden]{display:none!important}
.news-suggest{position:absolute;top:calc(100% + 10px);left:0;right:0;z-index:40;background:white;border:1px solid #D7E0D5;box-shadow:0 20px 50px rgba(15,47,31,.14);border-radius:19px;overflow:hidden}
.news-suggest-top{display:flex;align-items:center;justify-content:space-between;gap:12px;padding:14px 18px 11px;border-bottom:1px solid #EEF0EB;color:#718374;font-size:10px;font-weight:800;letter-spacing:.12em;text-transform:uppercase}
.news-suggest-top kbd{font-family:inherit;font-size:10px;font-weight:600;letter-spacing:0;text-transform:none}
.news-suggest-list{max-height:336px;overflow-y:auto}
.news-suggest-item{display:flex;align-items:center;justify-content:space-between;gap:14px;width:100%;padding:13px 18px;border-bottom:1px solid #F0F2EE;transition:background .15s ease}
.news-suggest-item:last-child{border-bottom:0}
.news-suggest-item:hover,.news-suggest-item.is-selected{background:#F1F6F0}
.news-suggest-copy{display:flex;flex-direction:column;gap:5px;min-width:0}
.news-suggest-title{font-size:13px;font-weight:750;line-height:1.4;color:#173C2F;overflow:hidden;text-overflow:ellipsis;white-space:nowrap}
.news-suggest-meta{font-size:11px;color:#7C8B80}
.news-suggest-arrow{color:#597B62;font-size:17px;flex-shrink:0}
.news-suggest-message{padding:18px;color:var(--muted);font-size:12px;line-height:1.65}
.news-search-note a{border-bottom:1px solid var(--forest);text-decoration:none}
.news-picture{border-radius:12px}
.news-page-btn{border-radius:999px;min-width:42px;height:42px;padding:0 13px;transition:background .2s ease}
.news-page-btn.active{background:var(--forest);border-color:var(--forest);color:#fff}
.news-page-links a.news-page-btn.active{color:#fff}
.news-pagination-meta{font-weight:650}
.news-pagination-pages{font-size:12px;color:var(--muted);margin-top:14px;text-align:center}
.news-page a:focus-visible,.news-search button:focus-visible{outline:2px solid #183C2F;outline-offset:3px}
@media(max-width:900px){
.news-page{padding-top:100px}
.news-intro{padding:40px 0 33px}
}
@media(max-width:600px){
.news-page{padding-top:94px}
.news-topline{padding:12px 0}
.news-topline span{display:none}
.news-intro{padding:27px 0 28px}
.news-heading{font-size:clamp(64px,16vw,88px)}
.news-toolbar{gap:17px;padding:23px 0}
.news-search{height:54px;padding-left:15px}
.news-search button{height:41px;padding:0 16px;min-width:68px}
.news-suggest{border-radius:16px}
.news-suggest-top kbd{display:none}
.news-page-btn.page-number:not(.active){display:none}
.news-page-btn{min-width:43px;height:43px}
.news-page-links{gap:10px}
.news-lead-layout{gap:23px}
.news-grid{gap:27px}
}


/* Perbaikan ring biru bawaan browser/Tailwind di kolom input. Fokus tetap terlihat di bingkai oval. */
.news-page #news-search-form input#news-search-input,
.news-page #news-search-form input#news-search-input:focus,
.news-page #news-search-form input#news-search-input:focus-visible,
.news-page #news-search-form input#news-search-input:active{
    -webkit-appearance:none!important;
    appearance:none!important;
    display:block;
    flex:1 1 auto;
    min-width:0;
    height:auto;
    background:transparent!important;
    border:0!important;
    border-radius:0!important;
    box-shadow:none!important;
    outline:0!important;
    padding:8px 0!important;
    margin:0!important;
    color:#183C2F!important;
    caret-color:#183C2F;
    font-family:'DM Sans',sans-serif!important;
    font-size:13px;
    line-height:1.5;
}
.news-page #news-search-form input#news-search-input::-webkit-search-decoration,
.news-page #news-search-form input#news-search-input::-webkit-search-results-button,
.news-page #news-search-form input#news-search-input::-webkit-search-results-decoration{display:none}
.news-page #news-search-form:focus-within{border-color:#7D9D84;box-shadow:0 0 0 3px rgba(24,60,47,.12)}
/* Editorial layout: utamakan satu publikasi besar tanpa mengganggu kepadatan delapan artikel. */
.news-lead-layout{grid-template-columns:minmax(0,1.7fr) minmax(0,.93fr);gap:44px;padding-top:42px;padding-bottom:54px}
.news-lead-layout.news-lead-only{grid-template-columns:minmax(0,1fr)}
.news-lead-only .news-lead{max-width:820px;margin-inline:auto;width:100%}
.news-feature-label{display:inline-flex;align-items:center;gap:9px;margin-bottom:15px;color:#64816D;font-size:10px;font-weight:800;letter-spacing:.16em;text-transform:uppercase}
.news-feature-dot{width:7px;height:7px;border-radius:50%;background:#B69A63}
.news-lead-picture{aspect-ratio:16/9;border-radius:15px}
.news-side-picture{border-radius:10px}
.news-grid-picture{border-radius:11px}
.news-side>h2{font-size:26px}
.news-side-title{font-size:15px;line-height:1.4}
.news-lead-title{font-size:clamp(29px,3.3vw,45px);line-height:1.12}
.news-section{padding-top:44px;padding-bottom:52px}
.news-grid{column-gap:24px;row-gap:39px}
.news-grid article{min-width:0}
.news-grid .news-meta{margin-top:13px}
.news-read-more{transition:color .2s,border-color .2s}
.news-page a.news-story:hover .news-read-more{color:#427A56;border-color:#427A56}
/* Pagination selalu memberi tahu posisi halaman, namun kontrol baru tampil jika >8 publikasi. */
.news-pagination{padding-top:30px;padding-bottom:64px}
.news-pagination-pages{margin-top:14px;line-height:1.6}
.news-pagination:not(:has(.news-page-links)) .news-pagination-pages{margin-top:0}
.news-page-btn{border-radius:999px}
/* Animasi halus saat konten memasuki layar. Bila JavaScript gagal, semua konten tetap terlihat. */
@media(prefers-reduced-motion:no-preference){
    .news-page.news-animate [data-news-reveal]{opacity:0;transform:translateY(15px);transition:opacity .65s ease,transform .65s cubic-bezier(.2,.75,.25,1)}
    .news-page.news-animate [data-news-reveal].news-visible{opacity:1;transform:translateY(0)}
    .news-page .news-picture img{transition:transform .45s cubic-bezier(.2,.75,.25,1)}
}
@media(max-width:900px){
    .news-lead-layout{grid-template-columns:1fr;gap:25px}
    .news-lead-only .news-lead{max-width:none}
}
@media(max-width:600px){
    .news-lead-layout{padding:27px 0 38px}
    .news-lead-picture{aspect-ratio:16/10}
    .news-lead-title{font-size:clamp(28px,7.2vw,36px)}
    .news-grid{row-gap:30px}
    .news-section{padding-top:34px;padding-bottom:36px}
    .news-feature-label{font-size:9px;margin-bottom:12px}
    .news-pagination{padding-bottom:45px}
    .news-pagination-pages{font-size:11px}
}

/* FIX: Live search tampil di atas konten berita */
.news-toolbar {
    position: relative;
    z-index: 100;
    overflow: visible;
}
.news-search-shell {
    position: relative;
    z-index: 101;
    isolation: isolate;
}
.news-suggest {
    position: absolute;
    top: calc(100% + 10px);
    left: 0;
    right: 0;
    z-index: 102;
    background: #FFFFFF;
    opacity: 1;
    border: 1px solid #D7E0D5;
    border-radius: 18px;
    overflow: hidden;
    box-shadow: 0 20px 45px rgba(24, 60, 47, 0.14);
}
.news-lead-layout,
.news-section {
    position: relative;
}

/* FIX FINAL: URUTAN LAYER NAVBAR, SEARCH, BERITA */

/* Area pencarian tidak boleh mengalahkan navbar */
.news-page .news-toolbar {
    position: relative;
    z-index: 10;
    overflow: visible;
}

/* Kontainer pencarian */
.news-page .news-search-shell {
    position: relative;
    z-index: 11;
    isolation: isolate;
}

/* Dropdown tetap di atas gambar dan kartu berita */
.news-page .news-suggest {
    position: absolute;
    top: calc(100% + 10px);
    left: 0;
    right: 0;
    z-index: 12;
    background: #FFFFFF;
    border: 1px solid #D7E0D5;
    border-radius: 18px;
    box-shadow: 0 20px 45px rgba(24, 60, 47, 0.14);
    overflow: hidden;
}

/* Konten berita di belakang dropdown */
.news-page .news-lead-layout,
.news-page .news-section {
    position: relative;
    z-index: 1;
}

/* Hasil pencarian */
.news-page .news-suggest-item {
    background: #FFFFFF;
}

.news-page .news-suggest-item:hover,
.news-page .news-suggest-item.is-selected {
    background: #EDF4ED;
}


</style>
@endpush
@section('content')
@php
    $items = collect($newsList->items())->values();
    $search = trim((string) ($search ?? request('search', '')));
    // 8 publikasi per halaman: 1 utama, 2 samping, 5 dalam grid.
    // Pembagian ini juga berlaku di halaman 2, 3, dan hasil pencarian.
    $featured = $items->first();
    $sideItems = $items->slice(1, 2);
    $gridItems = $items->slice(3);
    $picture = function ($item) {
        $path = trim((string) ($item->image ?? ''));
        if ($path === '') return null;
        if (\Illuminate\Support\Str::startsWith($path, ['http://', 'https://', '/'])) return $path;
        if (\Illuminate\Support\Str::startsWith($path, 'storage/')) return asset($path);
        return \Illuminate\Support\Facades\Storage::disk('public')->url($path);
    };
    $published = fn ($item) => $item->created_at?->translatedFormat('d M Y') ?? '-';
    $eventDate = fn ($item) => $item->event_date ? \Carbon\Carbon::parse($item->event_date)->translatedFormat('d M Y') : null;
    $type = fn ($item) => $item->event_date ? 'Agenda' : 'Berita';
    $summary = fn ($item, $limit) => \Illuminate\Support\Str::limit(trim(preg_replace('/\s+/u', ' ', strip_tags((string) ($item->content ?? '')))), $limit);
    $current = $newsList->currentPage();
    $last = $newsList->lastPage();
    $startPage = max(1, $current - 2);
    $endPage = min($last, $current + 2);
@endphp
<x-site-navbar />
<div class="news-page">
    <div class="news-wrap">
        <div class="news-topline">
            <a href="{{ route('home') }}"><i class="ph ph-arrow-left" aria-hidden="true"></i> Kembali ke beranda</a>
            <span>Jurnal warga / Portal NU Lesmana</span>
        </div>

        <section class="news-intro" data-news-reveal>
            <p class="news-eyebrow">Cerita, informasi, dan kegiatan warga</p>
            <h1 class="news-heading news-display">BERITA <span>&</span><br>AGENDA<span>.</span></h1>
            <div class="news-intro-bottom">
                <p>Berita kegiatan dan agenda warga NU Lesmana, diurutkan dari publikasi terbaru sampai yang paling lama.</p>
                <span class="news-count">{{ $newsList->total() }} publikasi</span>
            </div>
        </section>
        <section class="news-toolbar" aria-label="Pencarian berita" data-news-reveal>
            <h2 class="news-display">JELAJAHI PUBLIKASI</h2>
            <div class="news-search-shell" id="news-search-shell">
                <form method="GET" action="{{ route('public.news.index') }}" class="news-search" id="news-search-form" role="search" autocomplete="off">
                    <i class="ph ph-magnifying-glass news-search-icon" aria-hidden="true"></i>
                    <input id="news-search-input" type="search" name="search" value="{{ $search }}" maxlength="100"
                        placeholder="Cari berita atau agenda..." aria-label="Cari publikasi"
                        role="combobox" aria-haspopup="listbox" aria-controls="news-suggest-list" aria-expanded="false" aria-autocomplete="list">
                    <button type="submit">Cari</button>
                </form>
                <div class="news-suggest" id="news-suggest-panel" hidden>
                    <div class="news-suggest-top"><span>Saran publikasi</span><kbd>↑ ↓ pilih · Enter buka</kbd></div>
                    <div class="news-suggest-list" id="news-suggest-list" role="listbox" aria-label="Saran berita"></div>
                </div>
            </div>
        </section>
        @if($search !== '')
            <div class="news-search-note"><span>Hasil untuk <strong>“{{ $search }}”</strong>: {{ $newsList->total() }} publikasi</span><a href="{{ route('public.news.index') }}">Hapus pencarian</a></div>
        @endif
        @if($featured)
            <section class="news-lead-layout {{ $sideItems->isEmpty() ? 'news-lead-only' : '' }}" aria-label="Publikasi utama">
                <article class="news-lead" data-news-reveal>
                    <div class="news-feature-label"><span class="news-feature-dot"></span> Pilihan utama halaman ini</div>
                    <a href="{{ route('public.news.show', $featured->id) }}" class="news-story">
                        <div class="news-picture news-lead-picture">
                            @if($picture($featured))<img src="{{ $picture($featured) }}" alt="{{ $featured->title }}" fetchpriority="high">
                            @else<div class="news-picture-empty" aria-hidden="true">▧</div>@endif
                        </div>
                        <div class="news-meta"><span class="news-type">{{ $type($featured) }}</span><span class="news-dot"></span><span>Terbit {{ $published($featured) }}</span>@if($eventDate($featured))<span>Acara {{ $eventDate($featured) }}</span>@endif</div>
                        <h2 class="news-story-title news-lead-title">{{ $featured->title }}</h2>
                        <p class="news-excerpt news-lead-excerpt">{{ $summary($featured, 210) }}</p>
                        <span class="news-read-more">Baca artikel lengkap ↗</span>
                    </a>
                </article>
                @if($sideItems->isNotEmpty())
                <aside class="news-side">
                    <h2 class="news-display">KABAR LAINNYA</h2>
                    @foreach($sideItems as $item)
                        <article data-news-reveal>
                            <a href="{{ route('public.news.show', $item->id) }}" class="news-side-link news-story">
                                <div class="news-picture news-side-picture">
                                    @if($picture($item))<img src="{{ $picture($item) }}" alt="{{ $item->title }}" loading="lazy">
                                    @else<div class="news-picture-empty" aria-hidden="true">▧</div>@endif
                                </div>
                                <div><div class="news-meta"><span class="news-type">{{ $type($item) }}</span><span>Terbit {{ $published($item) }}</span>@if($eventDate($item))<span>Acara {{ $eventDate($item) }}</span>@endif</div><h3 class="news-story-title news-side-title">{{ $item->title }}</h3></div>
                            </a>
                        </article>
                    @endforeach
                </aside>
                @endif
            </section>
        @endif
        @if($gridItems->isNotEmpty())
            <section class="news-section" aria-label="Daftar publikasi">
                <div class="news-section-top">
                    <h2 class="news-display">{{ $search !== '' ? 'HASIL PENCARIAN' : ($current > 1 ? 'LANJUTAN PUBLIKASI' : 'PUBLIKASI LAINNYA') }}</h2>
                    <small>Halaman {{ $current }} dari {{ $last }}</small>
                </div>
                <div class="news-grid">
                    @foreach($gridItems as $item)
                        <article data-news-reveal>
                            <a href="{{ route('public.news.show', $item->id) }}" class="news-story">
                                <div class="news-picture news-grid-picture">
                                    @if($picture($item))<img src="{{ $picture($item) }}" alt="{{ $item->title }}" loading="lazy">
                                    @else<div class="news-picture-empty" aria-hidden="true">▧</div>@endif
                                </div>
                                <div class="news-meta"><span class="news-type">{{ $type($item) }}</span><span class="news-dot"></span><span>Terbit {{ $published($item) }}</span>@if($eventDate($item))<span>Acara {{ $eventDate($item) }}</span>@endif</div>
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
        @if($newsList->total() > 0)
            <nav class="news-pagination" aria-label="Navigasi halaman berita" data-news-reveal>
                <p class="news-pagination-meta">Menampilkan {{ $newsList->firstItem() }}–{{ $newsList->lastItem() }} dari {{ $newsList->total() }} publikasi</p>
                @if($newsList->hasPages())
                <div class="news-page-links">
                    @if($newsList->onFirstPage())<span class="news-page-btn disabled" aria-disabled="true">←</span>
                    @else<a class="news-page-btn" href="{{ $newsList->previousPageUrl() }}" aria-label="Halaman sebelumnya">←</a>@endif
                    @if($startPage > 1)
                        <a class="news-page-btn page-number" href="{{ $newsList->url(1) }}">1</a>
                        @if($startPage > 2)<span class="news-ellipsis">…</span>@endif
                    @endif
                    @for($page = $startPage; $page <= $endPage; $page++)
                        @if($page === $current)<span class="news-page-btn page-number active" aria-current="page">{{ $page }}</span>
                        @else<a class="news-page-btn page-number" href="{{ $newsList->url($page) }}">{{ $page }}</a>@endif
                    @endfor
                    @if($endPage < $last)
                        @if($endPage < $last - 1)<span class="news-ellipsis">…</span>@endif
                        <a class="news-page-btn page-number" href="{{ $newsList->url($last) }}">{{ $last }}</a>
                    @endif
                    @if($newsList->hasMorePages())<a class="news-page-btn" href="{{ $newsList->nextPageUrl() }}" aria-label="Halaman berikutnya">→</a>
                    @else<span class="news-page-btn disabled" aria-disabled="true">→</span>@endif
                </div>
                @endif
                <p class="news-pagination-pages">Halaman {{ $current }} dari {{ $last }}{{ $last === 1 ? ' · Halaman berikutnya muncul setelah 8 publikasi' : '' }}</p>
            </nav>
        @endif
    </div>
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

@push('scripts')
<script>
(function () {
    'use strict';
    const shell = document.getElementById('news-search-shell');
    const input = document.getElementById('news-search-input');
    const panel = document.getElementById('news-suggest-panel');
    const list = document.getElementById('news-suggest-list');
    if (!shell || !input || !panel || !list) return;

    const endpoint = @json(route('public.news.index'));
    let timer = null;
    let currentRequest = 0;
    let selectedIndex = -1;

    function setExpanded(open) {
        panel.hidden = !open;
        input.setAttribute('aria-expanded', open ? 'true' : 'false');
        if (!open) {
            selectedIndex = -1;
            input.removeAttribute('aria-activedescendant');
        }
    }

    function showMessage(message) {
        list.replaceChildren();
        const line = document.createElement('p');
        line.className = 'news-suggest-message';
        line.textContent = message;
        list.appendChild(line);
        setExpanded(true);
    }

    function getOptions() {
        return Array.from(list.querySelectorAll('.news-suggest-item'));
    }

    function highlight(index) {
        const options = getOptions();
        if (!options.length) return;
        selectedIndex = (index + options.length) % options.length;
        options.forEach(function (option, position) {
            const active = position === selectedIndex;
            option.classList.toggle('is-selected', active);
            option.setAttribute('aria-selected', active ? 'true' : 'false');
            if (active) input.setAttribute('aria-activedescendant', option.id);
        });
    }

    function renderResults(results) {
        list.replaceChildren();
        if (!results.length) {
            showMessage('Belum ada berita yang cocok. Coba kata kunci lain.');
            return;
        }

        results.forEach(function (item, index) {
            const anchor = document.createElement('a');
            anchor.className = 'news-suggest-item';
            anchor.href = item.url;
            anchor.id = 'news-suggest-option-' + index;
            anchor.setAttribute('role', 'option');
            anchor.setAttribute('aria-selected', 'false');

            const copy = document.createElement('span');
            copy.className = 'news-suggest-copy';
            const title = document.createElement('span');
            title.className = 'news-suggest-title';
            title.textContent = item.title;
            const meta = document.createElement('span');
            meta.className = 'news-suggest-meta';
            meta.textContent = item.type + ' · Terbit ' + item.date;
            copy.append(title, meta);

            const arrow = document.createElement('i');
            arrow.className = 'ph ph-arrow-up-right news-suggest-arrow';
            arrow.setAttribute('aria-hidden', 'true');
            anchor.append(copy, arrow);
            anchor.addEventListener('mouseenter', function () { highlight(index); });
            list.appendChild(anchor);
        });

        selectedIndex = -1;
        setExpanded(true);
    }

    function searchLive() {
        const query = input.value.trim();
        const requestId = ++currentRequest;
        window.clearTimeout(timer);

        if (!query) {
            setExpanded(false);
            list.replaceChildren();
            return;
        }

        timer = window.setTimeout(function () {
            showMessage('Mencari berita...');
            fetch(endpoint + '?suggest=1&search=' + encodeURIComponent(query), {
                headers: { 'Accept': 'application/json', 'X-Requested-With': 'XMLHttpRequest' }
            }).then(function (response) {
                if (!response.ok) throw new Error('Pencarian gagal');
                return response.json();
            }).then(function (data) {
                if (requestId !== currentRequest || input.value.trim() !== query) return;
                renderResults(Array.isArray(data.results) ? data.results : []);
            }).catch(function () {
                if (requestId === currentRequest) showMessage('Saran belum bisa dimuat. Tekan Cari untuk mencari seperti biasa.');
            });
        }, 260);
    }

    input.addEventListener('input', searchLive);
    input.addEventListener('focus', function () {
        if (input.value.trim()) searchLive();
    });

    input.addEventListener('keydown', function (event) {
        if (event.key === 'Escape') {
            setExpanded(false);
            return;
        }
        if (panel.hidden) return;
        if (event.key === 'ArrowDown' || event.key === 'ArrowUp') {
            if (!getOptions().length) return;
            event.preventDefault();
            highlight(event.key === 'ArrowDown' ? selectedIndex + 1 : (selectedIndex < 0 ? getOptions().length - 1 : selectedIndex - 1));
        }
        if (event.key === 'Enter' && selectedIndex >= 0) {
            const option = getOptions()[selectedIndex];
            if (option) {
                event.preventDefault();
                window.location.assign(option.href);
            }
        }
    });

    document.addEventListener('pointerdown', function (event) {
        if (!shell.contains(event.target)) {
            ++currentRequest;
            window.clearTimeout(timer);
            setExpanded(false);
        }
    });
})();
</script>
@endpush


@push('scripts')
<script>
(function(){
    'use strict';
    const page = document.querySelector('.news-page');
    if (!page) return;
    const items = Array.from(page.querySelectorAll('[data-news-reveal]'));
    if (!items.length || !('IntersectionObserver' in window) || window.matchMedia('(prefers-reduced-motion: reduce)').matches) return;
    const observer = new IntersectionObserver(function(entries, instance){
        entries.forEach(function(entry){
            if (!entry.isIntersecting) return;
            entry.target.classList.add('news-visible');
            instance.unobserve(entry.target);
        });
    }, { threshold:0.06, rootMargin:'0px 0px 45px 0px' });
    page.classList.add('news-animate');
    items.forEach(function(item){observer.observe(item)});
    // Jika tab lama dipulihkan, pastikan konten tidak tertahan dalam posisi tersembunyi.
    window.addEventListener('pageshow', function(event){
        if (event.persisted) items.forEach(function(item){item.classList.add('news-visible')});
    });
})();
</script>
@endpush
