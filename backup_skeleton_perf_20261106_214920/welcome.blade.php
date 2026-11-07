<!DOCTYPE html>
<html lang="id" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Skeleton styles: inline so they render before the large page styles/scripts. -->
    <style>
        #nu-skeleton {
            position: fixed;
            inset: 0;
            z-index: 99999;
            overflow: hidden;
            background: #F5F4F0;
            pointer-events: auto;
            font-family: 'DM Sans', sans-serif;
            opacity: 1;
            visibility: visible;
            transition: opacity 260ms ease, visibility 260ms ease;
        }
        #nu-skeleton.is-hidden {
            opacity: 0;
            visibility: hidden;
            pointer-events: none;
        }
        #nu-skeleton .nu-sk-wrap {
            max-width: 1280px;
            margin: 0 auto;
            padding: 24px 24px 50px;
        }
        #nu-skeleton .nu-sk-nav {
            height: 68px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 22px;
            padding: 0 28px;
            border: 1px solid #E7EBE5;
            border-radius: 999px;
            background: #FFFFFF;
        }
        #nu-skeleton .nu-sk-links {
            display: flex;
            align-items: center;
            gap: 18px;
        }
        #nu-skeleton .nu-sk-line,
        #nu-skeleton .nu-sk-block,
        #nu-skeleton .nu-sk-button {
            display: block;
            background: #DFE6DE;
            border-radius: 8px;
        }
        #nu-skeleton .nu-sk-line {
            height: 12px;
        }
        #nu-skeleton .nu-sk-hero {
            display: grid;
            grid-template-columns: minmax(0, 1fr) minmax(0, 1fr);
            gap: 40px;
            align-items: center;
            margin-top: 52px;
        }
        #nu-skeleton .nu-sk-copy {
            display: flex;
            flex-direction: column;
            gap: 18px;
            min-width: 0;
        }
        #nu-skeleton .nu-sk-title {
            height: 72px;
            background: #C6D4C9;
            border-radius: 11px;
        }
        #nu-skeleton .nu-sk-actions {
            display: flex;
            flex-wrap: wrap;
            gap: 12px;
            max-width: 440px;
            margin-top: 12px;
        }
        #nu-skeleton .nu-sk-button {
            width: 175px;
            height: 52px;
            border-radius: 999px;
        }
        #nu-skeleton .nu-sk-button:first-child {
            background: #183C2F;
        }
        #nu-skeleton .nu-sk-photo {
            height: min(510px, 52vw);
            border-radius: 26px;
            background: #CCD9CE;
        }
        #nu-skeleton .nu-sk-pulse {
            animation: nu-sk-pulse 1.5s ease-in-out infinite;
        }
        @keyframes nu-sk-pulse {
            0%, 100% { opacity: 1; }
            50% { opacity: .60; }
        }
        @media (max-width: 767px) {
            #nu-skeleton .nu-sk-wrap {
                padding: 16px 16px 36px;
            }
            #nu-skeleton .nu-sk-nav {
                height: 60px;
                padding: 0 19px;
            }
            #nu-skeleton .nu-sk-links {
                display: none;
            }
            #nu-skeleton .nu-sk-hero {
                grid-template-columns: 1fr;
                gap: 30px;
                margin-top: 36px;
            }
            #nu-skeleton .nu-sk-copy {
                gap: 14px;
            }
            #nu-skeleton .nu-sk-title {
                height: 50px;
            }
            #nu-skeleton .nu-sk-button {
                height: 48px;
            }
            #nu-skeleton .nu-sk-photo {
                height: 245px;
            }
        }
        @media (prefers-reduced-motion: reduce) {
            #nu-skeleton,
            #nu-skeleton .nu-sk-pulse {
                animation: none;
                transition: none;
            }
        }
    </style>
    <noscript><style>#nu-skeleton { display: none !important; }</style></noscript>
    <title>Ranting NU Lesmana - Portal Resmi Warga</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="{{ asset('css/nulesmana-animations.css') }}">
<script src="https://unpkg.com/@phosphor-icons/web"></script>
    <style>
        body { font-family: 'DM Sans', sans-serif; }
        .font-arabic { font-family: 'Amiri', serif; font-weight: 400; }
        .font-linktree { font-family: 'DM Sans', sans-serif; }
        .font-display { font-family: 'Bebas Neue', sans-serif; font-weight: 400; letter-spacing: .02em; }
        .slide-item { transition: opacity 0.8s ease-in-out; }
        .no-scrollbar::-webkit-scrollbar { display: none; }
        .no-scrollbar { scrollbar-width: none; }
        .rating-picker label { color: #d5d9d1; transition: color .2s ease, transform .2s ease; }
        .rating-picker input:checked ~ label,
        .rating-picker label:hover,
        .rating-picker label:hover ~ label { color: #b77b18; }
        .rating-picker input:focus-visible + label { outline: 2px solid #183C2F; outline-offset: 4px; border-radius: 5px; }
        #form-ulasan { scroll-margin-top: 120px; }
        /* Tipografi dan tampilan formulir landing page */
        #form-ulasan,
        .landing-form {
            font-family: 'DM Sans', sans-serif;
        }
        #form-ulasan label,
        .landing-form label {
            font-family: 'DM Sans', sans-serif;
            font-weight: 700;
            letter-spacing: 0;
        }
        #form-ulasan input:not([type="radio"]),
        #form-ulasan textarea,
        #form-ulasan select,
        .landing-form input:not([type="radio"]),
        .landing-form textarea,
        .landing-form select {
            width: 100%;
            background: #F8F9F6;
            border: 1px solid #DDE4DA;
            border-radius: 12px;
            color: #183C2F;
            font-family: 'DM Sans', sans-serif;
            font-size: 14px;
            font-weight: 500;
            line-height: 1.6;
            padding: 14px 16px;
            transition: border-color .18s ease, box-shadow .18s ease;
        }
        #form-ulasan input::placeholder,
        #form-ulasan textarea::placeholder,
        .landing-form input::placeholder,
        .landing-form textarea::placeholder {
            color: #8D9A8F;
            opacity: 1;
        }
        #form-ulasan input:focus,
        #form-ulasan textarea:focus,
        #form-ulasan select:focus,
        .landing-form input:focus,
        .landing-form textarea:focus,
        .landing-form select:focus {
            outline: none;
            border-color: #183C2F;
            box-shadow: 0 0 0 3px rgba(24, 60, 47, .10);
        }
        #form-ulasan input[readonly] {
            background: #EDF0E9;
            color: #55675A;
            cursor: not-allowed;
        }
        #form-ulasan .rating-picker input[type="radio"] {
            position: absolute;
            width: 1px;
            height: 1px;
            opacity: 0;
        }
        #form-ulasan button[type="submit"] {
            font-family: 'DM Sans', sans-serif;
            font-weight: 700;
            letter-spacing: 0;
        }

        /* Suara Warga: dua jalur review bergerak, minimal, forest green. */
        #saran .nu-review-showcase { position:relative; margin-top:28px; overflow:hidden; }
        #saran .nu-review-showcase::before,
        #saran .nu-review-showcase::after { content:""; position:absolute; top:0; bottom:0; width:clamp(20px,5vw,72px); z-index:2; pointer-events:none; }
        #saran .nu-review-showcase::before { left:0; background:linear-gradient(to right,#f6f7f3 0%,transparent 100%); }
        #saran .nu-review-showcase::after { right:0; background:linear-gradient(to left,#f6f7f3 0%,transparent 100%); }
        #saran .nu-review-row { overflow:hidden; padding:5px 0 12px; }
        #saran .nu-review-row + .nu-review-row { margin-top:3px; }
        #saran .nu-review-track { display:flex; width:max-content; animation:nu-review-move-left var(--nu-review-duration,55s) linear infinite; will-change:transform; }
        #saran .nu-review-track[data-direction="right"] { animation-name:nu-review-move-right; }
        #saran .nu-review-group { display:flex; width:max-content; flex:0 0 auto; gap:14px; padding-right:14px; }
        #saran .nu-review-card { display:flex; flex:0 0 clamp(245px,27vw,340px); width:clamp(245px,27vw,340px); min-height:170px; flex-direction:column; align-items:stretch; gap:12px; border:1px solid #D9E3D9; border-radius:18px; background:#FFFFFF; padding:20px 21px; font-family:'DM Sans',sans-serif; color:#183C2F; text-align:left; box-shadow:0 4px 14px rgba(24,60,47,.045); cursor:pointer; transition:transform .2s ease, border-color .2s ease, box-shadow .2s ease; }
        #saran .nu-review-card:hover { transform:translateY(-2px); border-color:#9FB7A6; box-shadow:0 9px 24px rgba(24,60,47,.09); }
        #saran .nu-review-card:focus-visible { outline:3px solid #77A58A; outline-offset:2px; }
        #saran .nu-review-avatar { display:flex; width:35px; height:35px; flex:0 0 auto; align-items:center; justify-content:center; border-radius:999px; background:#183C2F; color:#fff; font-size:13px; font-weight:800; }
        #saran .nu-review-preview { display:-webkit-box; -webkit-box-orient:vertical; -webkit-line-clamp:2; line-clamp:2; overflow:hidden; line-height:1.6; overflow-wrap:anywhere; font-size:13px; color:#4B6053; }
        #saran .nu-review-hint { display:flex; align-items:center; gap:9px; margin-top:14px; color:#809085; font-size:11px; }
        #saran .nu-review-row:has(.nu-review-card:focus-visible) .nu-review-track,
        #saran .nu-review-row.is-touched .nu-review-track,
        body.nu-review-modal-open #saran .nu-review-track { animation-play-state:paused; }
        @media(hover:hover){ #saran .nu-review-row:hover .nu-review-track { animation-play-state:paused; } }
        @keyframes nu-review-move-left { from{transform:translateX(0)} to{transform:translateX(-50%)} }
        @keyframes nu-review-move-right { from{transform:translateX(-50%)} to{transform:translateX(0)} }
        .nu-review-modal[hidden] { display:none!important; }
        .nu-review-modal { position:fixed; inset:0; z-index:99998; display:grid; place-items:center; overflow-y:auto; padding:18px; background:rgba(10,27,19,.68); backdrop-filter:blur(7px); -webkit-backdrop-filter:blur(7px); animation:nu-review-overlay-in .22s ease-out; }
        .nu-review-dialog { width:min(100%,540px); max-height:min(90dvh,760px); overflow-y:auto; border:1px solid #DCE4DA; border-radius:23px; background:#F9FAF7; padding:clamp(22px,4vw,35px); box-shadow:0 25px 80px rgba(5,28,17,.25); animation:nu-review-dialog-in .25s cubic-bezier(.16,1,.3,1); }
        .nu-review-dialog .nu-modal-message { white-space:pre-wrap; overflow-wrap:anywhere; font-size:15px; line-height:1.8; color:#3D5446; }
        .nu-review-dialog .nu-review-close { display:grid; width:40px; height:40px; place-items:center; border:1px solid #D9E3D9; border-radius:999px; background:#FFFFFF; color:#183C2F; }
        .nu-review-dialog .nu-review-close:hover { background:#EAF0E9; }
        @keyframes nu-review-overlay-in { from{opacity:0} to{opacity:1} }
        @keyframes nu-review-dialog-in { from{opacity:0;transform:translateY(10px) scale(.985)} to{opacity:1;transform:translateY(0) scale(1)} }
        #saran .landing-form { min-width:0; }
        #saran .landing-form textarea { min-width:0; resize:vertical; }
        #saran .rating-picker label { display:inline-flex; min-width:38px; min-height:44px; align-items:center; justify-content:center; }
        @media(max-width:640px){
            #saran { padding-top:64px; padding-bottom:76px; }
            #saran .nu-review-showcase { margin-left:-16px; margin-right:-16px; }
            #saran .nu-review-row { padding:5px 0 10px; }
            #saran .nu-review-group { gap:11px; padding-right:11px; }
            #saran .nu-review-card { flex-basis:250px; width:250px; min-height:157px; padding:16px 17px; border-radius:16px; }
            #saran .nu-review-hint { font-size:10px; }
            #saran .landing-form { border-radius:18px; padding:22px 18px; }
            #saran .rating-picker { gap:2px; }
            #saran .rating-picker label { font-size:30px; }
            .nu-review-dialog { border-radius:19px; padding:21px; max-height:88dvh; }
        }
        @media(prefers-reduced-motion:reduce){
            #saran .nu-review-showcase::before,#saran .nu-review-showcase::after { display:none; }
            #saran .nu-review-row { overflow-x:auto; scrollbar-width:thin; -webkit-overflow-scrolling:touch; }
            #saran .nu-review-track { animation:none!important; transform:none!important; will-change:auto; }
            #saran .nu-review-card:hover { transform:none; }
            .nu-review-modal,.nu-review-dialog { animation:none; }
        }
    </style>
    <!-- Animasi reveal cadangan: bekerja juga saat file animasi eksternal gagal dimuat. -->
    <style>
        html.nl-reveal-enabled [data-hero-enter] {
            opacity: 0;
            filter: blur(10px);
            transform: translate3d(0, 14px, 0);
            transition: opacity .75s ease, filter .75s ease, transform .75s ease;
        }
        html.nl-reveal-enabled [data-hero-enter].nl-hero-visible {
            opacity: 1;
            filter: blur(0);
            transform: translate3d(0, 0, 0);
        }
        html.nl-reveal-enabled [data-reveal] {
            opacity: 0;
            filter: blur(9px);
            transform: translate3d(0, 20px, 0);
            transition: opacity .7s ease, filter .7s ease, transform .7s cubic-bezier(.2,.75,.2,1);
        }
        html.nl-reveal-enabled [data-reveal].nl-reveal-visible {
            opacity: 1 !important;
            filter: blur(0) !important;
            transform: translate3d(0, 0, 0) !important;
        }
        @media (max-width: 640px) {
            html.nl-reveal-enabled [data-reveal] {
                filter: blur(5px);
                transform: translate3d(0, 12px, 0);
            }
        }
        @media (prefers-reduced-motion: reduce) {
            html.nl-reveal-enabled [data-hero-enter],
            html.nl-reveal-enabled [data-reveal] {
                opacity: 1 !important;
                filter: none !important;
                transform: none !important;
                transition: none !important;
            }
        }
    </style>
    <script>
        (function () {
            const reduceMotion = window.matchMedia && window.matchMedia('(prefers-reduced-motion: reduce)').matches;
            if (!('IntersectionObserver' in window) || reduceMotion) return;
            document.documentElement.classList.add('nl-reveal-enabled');
            document.addEventListener('DOMContentLoaded', function () {
                const items = document.querySelectorAll('[data-reveal]');
                const observer = new IntersectionObserver(function (entries, instance) {
                    entries.forEach(function (entry) {
                        if (!entry.isIntersecting) return;
                        entry.target.classList.add('nl-reveal-visible', 'is-visible', 'in-view');
                        instance.unobserve(entry.target);
                    });
                }, { threshold: 0.08, rootMargin: '0px 0px -5% 0px' });
                items.forEach(function (item) { observer.observe(item); });
            }, { once: true });
        })();
    </script>
    <!-- Manrope + Instrument Serif untuk hero publik -->
<!-- Nulesmana typography public only - tidak untuk admin -->
    <!-- Nulesmana publik V5: font lama yang dipakai komponen + font hero editorial -->
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <!-- Nulesmana V6 FIX: satu permintaan font publik + tipografi responsif -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link data-nu-v6-fonts rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Amiri:wght@400;700&amp;family=Bebas+Neue&amp;family=Instrument+Serif:ital@1&amp;family=Manrope:wght@500;600;700&amp;display=swap">
    <link rel="stylesheet" href="{{ asset('css/nulesmana-public-type.css') }}?v=61">
    <link rel="stylesheet" href="{{ asset('css/nulesmana-techtext.css') }}?v=61">
    <link data-nu-mobile-stable rel="stylesheet" href="{{ asset('css/nulesmana-mobile-stable.css') }}?v=1">
</head>
<body class="nu-public-v6 bg-[#F7F8F5] text-gray-900 min-h-screen relative overflow-x-hidden selection:bg-[#203d2e] selection:text-white">
    <!-- Skeleton overlay for the homepage. All elements are decorative placeholders. -->
    <div id="nu-skeleton" role="status" aria-label="Memuat halaman NU Lesmana">
        <div class="nu-sk-wrap" aria-hidden="true">
            <div class="nu-sk-nav">
                <span class="nu-sk-line nu-sk-pulse" style="width: 100px;"></span>
                <div class="nu-sk-links">
                    <span class="nu-sk-line nu-sk-pulse" style="width: 85px;"></span>
                    <span class="nu-sk-line nu-sk-pulse" style="width: 108px;"></span>
                    <span class="nu-sk-line nu-sk-pulse" style="width: 75px;"></span>
                </div>
                <span class="nu-sk-line nu-sk-pulse" style="width: 88px;"></span>
            </div>
            <div class="nu-sk-hero">
                <div class="nu-sk-copy">
                    <span class="nu-sk-line nu-sk-pulse" style="width: 58%;"></span>
                    <span class="nu-sk-title nu-sk-pulse"></span>
                    <span class="nu-sk-title nu-sk-pulse" style="width: 78%;"></span>
                    <span class="nu-sk-line nu-sk-pulse" style="width: 92%; margin-top: 12px;"></span>
                    <span class="nu-sk-line nu-sk-pulse" style="width: 67%;"></span>
                    <div class="nu-sk-actions">
                        <span class="nu-sk-button nu-sk-pulse"></span>
                        <span class="nu-sk-button nu-sk-pulse"></span>
                    </div>
                </div>
                <div class="nu-sk-photo nu-sk-pulse"></div>
            </div>
        </div>
    </div>

    <!-- NAVBAR + MENU MOBILE (komponen: resources/views/components/site-navbar.blade.php) -->
    <x-site-navbar />

    <!-- NOTIFIKASI -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 pt-28 sm:pt-32">
        @if(session('success'))
            <div class="bg-[#203d2e] text-white px-5 py-3.5 rounded-2xl font-bold shadow-lg flex items-center justify-between mb-4 text-xs sm:text-sm">
                <span><i class="ph ph-check-circle text-lg align-middle mr-2"></i> {{ session('success') }}</span>
                <button onclick="this.parentElement.remove()" class="text-white/80"><i class="ph ph-x text-base"></i></button>
            </div>
        @endif
    </div>

    <!-- HERO: tipografi ringan dan ruang putih lega -->
    <main id="nu-home-hero" class="max-w-7xl mx-auto px-4 sm:px-6 pt-8 sm:pt-12 lg:pt-14 pb-10 sm:pb-14">
        <div class="flex flex-col lg:flex-row items-center gap-12 lg:gap-16">
            <!-- TEKS KIRI -->
            <div data-hero-enter class="nu-v6-hero-copy w-full lg:w-1/2 flex flex-col items-center lg:items-start text-center lg:text-left">
                <div class="nu-v6-greeting mb-6 text-center lg:text-left">
                    <p lang="ar" dir="rtl" class="font-arabic text-[1.65rem] sm:text-4xl text-[#173d30] leading-[1.8]">السَّلَامُ عَلَيْكُمْ وَرَحْمَةُ اللَّهِ وَبَرَكَاتُهُ</p>
                    <p class="text-[11px] sm:text-xs tracking-[.16em] uppercase font-semibold text-gray-500 mt-1">Selamat datang di Portal NU Lesmana</p>
                </div>
                <h1 class="nu-tech-hero-title" aria-label="Portal Resmi NU Lesmana.">
    <span class="nu-tech-line nu-tech-line--sans" data-nu-tech-text="Portal Resmi"><span class="nu-tech-fallback" aria-hidden="true">Portal Resmi</span></span>
    <span class="nu-tech-line nu-tech-line--serif" data-nu-tech-text="NU Lesmana."><span class="nu-tech-fallback" aria-hidden="true">NU Lesmana.</span></span>
</h1>
                <p class="nu-v6-description nu-type-hero-description max-w-[34rem] mb-9 text-[15px] leading-[1.9] font-normal text-[#58675F] sm:mb-10 sm:text-[17px]">
                    Pusat informasi kegiatan majelis, berita agenda keagamaan, serta layanan pendaftaran anggota Badan Otonom Ranting NU dengan verifikasi NIA otomatis.
                </p>
                <div class="nu-v6-hero-actions flex w-full flex-wrap items-center justify-center gap-3.5 lg:justify-start">
                    <a href="{{ route('member.signup') }}" class="inline-flex min-h-[52px] items-center justify-center gap-3 rounded-full bg-[#183C2F] px-9 py-3.5 text-[13px] font-semibold text-white transition-colors hover:bg-[#285340] focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-4 focus-visible:outline-[#183C2F]">
                        Daftar Anggota <i class="ph ph-arrow-up-right text-lg" aria-hidden="true"></i>
                    </a>
                    <a href="{{ route('public.news.index') }}" class="inline-flex min-h-[52px] items-center justify-center gap-3 rounded-full border border-[#183C2F]/35 px-8 py-3.5 text-[13px] font-medium text-[#183C2F] transition-colors hover:border-[#183C2F] hover:bg-[#E8EFE7] focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-4 focus-visible:outline-[#183C2F]">
                        Berita &amp; Agenda <i class="ph ph-arrow-up-right text-lg" aria-hidden="true"></i>
                    </a>
                </div>
            </div>
            <!-- FOTO KH. Hasyim Asy'ari: satu fokus visual, tanpa ornamen -->
            <div class="w-full lg:w-1/2">
                <figure data-hero-enter class="relative mx-auto max-w-[35rem] overflow-hidden rounded-[1.65rem] bg-[#15392B] lg:ml-auto lg:mr-0">
                    <div class="relative h-[350px] sm:h-[460px] lg:h-[510px]">
                        {{-- Sumber foto dipertahankan dari hero versi sebelumnya. --}}
                        <img
                            id="nu-hero-image"
                            src="{{ asset('image/mbah_hasyim.webp') }}"
                            alt="KH Hasyim Asy'ari"
                            class="absolute inset-0 w-full h-full object-cover object-center"
                            fetchpriority="high"
                            decoding="async"
                        >
                        <div class="pointer-events-none absolute inset-x-0 bottom-0 h-48 bg-gradient-to-t from-[#0C2219]/95 via-[#0C2219]/50 to-transparent"></div>
                        <figcaption class="absolute bottom-0 left-0 right-0 px-6 pb-7 pt-12 text-white sm:px-8 sm:pb-8">
                            <p class="text-[10px] font-bold uppercase tracking-[.2em] text-white/70">
                                Tokoh Pendiri Nahdlatul Ulama
                            </p>
                            <p class="font-display mt-2 text-[2.3rem] leading-none sm:text-5xl">
                                KH. HASYIM ASY'ARI
                            </p>
                        </figcaption>
                    </div>
                </figure>
                <div class="mx-auto mt-3 flex max-w-[35rem] items-center justify-between gap-3 px-1 text-xs text-[#5D6F61] lg:ml-auto lg:mr-0">
                    <span class="inline-flex items-center gap-2 font-semibold">
                        <i class="ph ph-users-three text-lg text-[#183C2F]" aria-hidden="true"></i>
                        {{ ($ipnuCount ?? 0) + ($ippnuCount ?? 0) + ($ansorCount ?? 0) + ($fatayatCount ?? 0) }} kader terverifikasi
                    </span>
                    <span class="font-semibold">5 Badan Otonom</span>
                </div>
            </div>
        </div>
    </main>

    <!-- JARAK TRANSISI: sengaja tanpa card, ikon, atau tombol tambahan -->
    <div class="mx-auto max-w-7xl px-4 sm:px-6" aria-hidden="true">
        <div class="h-12 sm:h-20 lg:h-24"></div>
        <div class="flex items-center justify-between border-t border-[#DCE3DB] pt-5">
            <span class="text-[10px] font-medium uppercase tracking-[.2em] text-[#819083]">Jelajahi NU Lesmana</span>
            <i class="ph ph-arrow-down text-base text-[#819083]"></i>
        </div>
    </div>

    <!-- ABOUT NU LESMANA: editorial, teks kiri dan foto kanan -->
    <section id="tentang" class="mx-auto max-w-7xl scroll-mt-32 px-4 pt-12 pb-20 sm:px-6 sm:pt-16 sm:pb-28 lg:pb-32" aria-labelledby="about-heading">
        <div class="grid items-center gap-12 lg:grid-cols-2 lg:gap-24">
            <div data-reveal class="max-w-xl">
                <p class="mb-5 text-[11px] font-bold uppercase tracking-[.22em] text-[#738A78]">01 / Tentang Kami</p>
                <h2 id="about-heading" class="text-[clamp(2.7rem,5vw,4.85rem)] font-semibold leading-[1.06] tracking-[-.06em] text-[#183C2F]">About NU Lesmana<span class="text-[#B59A64]">.</span></h2>
                <h3 class="mt-8 text-lg font-semibold leading-[1.55] tracking-[-.025em] text-[#294637] sm:text-[22px]">Berakar dalam tradisi, hadir untuk masyarakat.</h3>
                <p class="mt-5 max-w-lg text-[15px] leading-[1.95] text-[#657268] sm:text-base">Pengurus Ranting Nahdlatul Ulama Lesmana merupakan bagian dari organisasi Nahdlatul Ulama di tingkat ranting. Melalui Nulesmana, warga dapat mengenal organisasi, memperoleh informasi, dan mengakses layanan keanggotaan dengan lebih mudah.</p>
                <a href="{{ route('struktur.organisasi') }}" class="group mt-10 inline-flex items-center gap-3 border-b border-[#183C2F]/35 pb-2 text-[13px] font-medium text-[#183C2F] transition-colors hover:border-[#183C2F]">
                    Lihat Struktur Organisasi <i class="ph ph-arrow-up-right text-lg transition-transform group-hover:translate-x-0.5 group-hover:-translate-y-0.5" aria-hidden="true"></i>
                </a>
            </div>
            <figure data-reveal class="relative min-h-[320px] overflow-hidden rounded-[22px] bg-[#E4ECE2] sm:min-h-[410px] lg:min-h-[490px]">
                <div class="absolute inset-0 flex flex-col justify-end bg-[#DCE7DC] p-8 sm:p-10" aria-hidden="true">
                    <span class="font-display text-[clamp(4rem,12vw,8rem)] leading-none text-[#183C2F]/15">NU</span>
                    <span class="font-display text-5xl leading-none text-[#183C2F] sm:text-6xl">LESMANA.</span>
                    <span class="mt-2 text-xs font-semibold uppercase tracking-[.2em] text-[#648171]">Pengurus Ranting Nahdlatul Ulama</span>
                </div>
                {{-- Foto asli bisa diletakkan di public/image/about-nu-lesmana.webp. Tampilan fallback tetap rapi jika belum ada. --}}
                <img src="{{ asset('image/about-nu-lesmana.webp') }}" alt="Dokumentasi Pengurus Ranting NU Lesmana" class="absolute inset-0 h-full w-full object-cover object-center" loading="lazy" decoding="async" onerror="this.hidden=true">
                <div class="pointer-events-none absolute inset-x-0 bottom-0 z-10 bg-gradient-to-t from-[#0B281C]/70 to-transparent px-6 pb-6 pt-24 text-white">
                    <p class="text-[10px] font-bold uppercase tracking-[.18em]">Pengurus Ranting NU Lesmana</p>
                </div>
            </figure>
        </div>
    </section>

    <!-- GALERI COVERFLOW: mouse wheel, drag, touch, dan putaran tanpa akhir -->
   @php
    $galleryNews = collect($publishedNews ?? [])->filter(fn ($item) => filled($item->image))->take(8)->values();
@endphp
<section id="galeri" class="py-20 sm:py-28 scroll-mt-28 overflow-hidden">
    <div class="max-w-7xl mx-auto px-4 sm:px-6">
        <div data-reveal class="text-center mb-8 sm:mb-12">
            <p class="text-[11px] font-bold tracking-[.22em] uppercase text-[#6d8274] mb-3">Dokumentasi kegiatan</p>
            <h2 class="text-[clamp(2.6rem,4.7vw,4.7rem)] font-semibold leading-[1.12] tracking-[-.06em] text-[#183C2F]">Cerita dari Lesmana.</h2>
            <p class="text-sm text-[#657268] mt-4">Geser dengan mouse, scroll, atau sentuh untuk melihat momen lainnya.</p>
        </div>
    </div>

    @if($galleryNews->isNotEmpty())
        <div class="nulesmana-coverflow relative mx-auto max-w-[1440px] select-none"
             data-coverflow tabindex="0" role="region"
             aria-label="Galeri dokumentasi kegiatan NU Lesmana">
            <div class="coverflow-stage relative h-[255px] sm:h-[340px] lg:h-[415px] overflow-hidden cursor-grab active:cursor-grabbing touch-pan-y">
                @foreach($galleryNews as $photo)
                    @php
                        $original = $photo->image;
                        $webp = preg_replace('/\.png$/i', '.webp', $original);

                        $imagePath = $webp !== $original
                            && \Illuminate\Support\Facades\Storage::disk('public')->exists($webp)
                            ? $webp
                            : $original;
                    @endphp

                    <a class="coverflow-slide absolute top-1/2 left-1/2 block w-[280px] h-[158px] sm:w-[400px] sm:h-[225px] lg:w-[520px] lg:h-[293px] rounded-[20px] overflow-hidden bg-[#e4e8e1] shadow-lg outline-offset-4 focus-visible:outline-2 focus-visible:outline-[#183C2F]"
                       href="{{ route('public.news.show', $photo->id) }}"
                       aria-label="Baca berita: {{ $photo->title }}" draggable="false">
                        <img src="{{ \Illuminate\Support\Facades\Storage::url($imagePath) }}"
                             alt="{{ $photo->title }}"
                             loading="lazy"
                             decoding="async"
                             draggable="false"
                             class="w-full h-full object-cover pointer-events-none">
                        <div class="absolute inset-x-0 bottom-0 pt-20 pb-5 px-5 bg-gradient-to-t from-black/80 to-transparent pointer-events-none">
                            <p class="text-white text-sm sm:text-base font-semibold leading-snug line-clamp-2">{{ $photo->title }}</p>
                        </div>
                    </a>
                @endforeach
            </div>

            <div class="max-w-7xl mx-auto px-4 sm:px-6 mt-3 flex items-center justify-between gap-4">
                <div class="flex items-center gap-3">
                    <span class="coverflow-current text-sm font-semibold text-[#183C2F] tabular-nums">01</span>
                    <span class="w-9 h-px bg-[#b8c7ba]"></span>
                    <span class="text-sm text-[#758779] tabular-nums">{{ str_pad((string)$galleryNews->count(), 2, '0', STR_PAD_LEFT) }}</span>
                </div>
                <div class="flex gap-2">
                    <button type="button" class="coverflow-prev w-11 h-11 rounded-full border border-[#b9c9bd] text-[#183C2F] hover:bg-[#183C2F] hover:text-white transition" aria-label="Foto sebelumnya"><i class="ph ph-arrow-left text-lg"></i></button>
                    <button type="button" class="coverflow-next w-11 h-11 rounded-full border border-[#b9c9bd] text-[#183C2F] hover:bg-[#183C2F] hover:text-white transition" aria-label="Foto berikutnya"><i class="ph ph-arrow-right text-lg"></i></button>
                </div>
            </div>
        </div>

        <div class="max-w-7xl mx-auto px-4 sm:px-6 mt-6 text-right">
            <a href="{{ route('public.news.index') }}" class="text-xs font-bold text-[#183C2F] inline-flex items-center gap-2 hover:underline">Lihat semua berita <i class="ph ph-arrow-up-right"></i></a>
        </div>
    @else
        <div class="max-w-7xl mx-auto px-4 sm:px-6">
            <div class="rounded-2xl bg-[#eeefeb] border border-[#dfe5dc] px-6 py-14 text-center">
                <p class="text-sm text-[#637569]">Dokumentasi muncul setelah berita dengan foto dipublikasikan.</p>
            </div>
        </div>
    @endif
</section>
<style>
    /* Galeri coverflow asli Nulesmana: efek 3D saat scroll, drag, dan sentuh. */
    .coverflow-slide {
        transform-origin: center center;
        transition: transform 650ms cubic-bezier(.2,.8,.2,1), opacity 550ms ease, filter 550ms ease;
        will-change: transform, opacity;
        backface-visibility: hidden;
    }
    .coverflow-stage { perspective: 1400px; }
    @media (prefers-reduced-motion: reduce) {
        .coverflow-slide { transition-duration: 0.01ms; }
    }
</style>
<script>
document.addEventListener('DOMContentLoaded', () => {
    document.querySelectorAll('[data-coverflow]').forEach(carousel => {
        const stage = carousel.querySelector('.coverflow-stage');
        const slides = Array.from(carousel.querySelectorAll('.coverflow-slide'));
        const current = carousel.querySelector('.coverflow-current');
        const previousButton = carousel.querySelector('.coverflow-prev');
        const nextButton = carousel.querySelector('.coverflow-next');
        const count = slides.length;
        if (!stage || !current || !previousButton || !nextButton || !count) return;
        let index = 0;
        let startX = null;
        let startY = null;
        let lastWheel = 0;
        let suppressClick = false;
        const render = () => {
            const mobile = window.innerWidth < 640;
            const spacing = mobile ? 150 : window.innerWidth < 1024 ? 230 : 320;
            slides.forEach((slide, i) => {
                let distance = (i - index + count) % count;
                if (distance > count / 2) distance -= count;
                const abs = Math.abs(distance);
                const visible = abs <= (mobile ? 2 : 3);
                const x = distance * spacing;
                const rotate = distance === 0 ? 0 : (distance < 0 ? 23 : -23);
                const scale = distance === 0 ? 1 : Math.max(.64, 1 - abs * .13);
                slide.style.transform = `translate(-50%, -50%) translateX(${x}px) rotateY(${rotate}deg) scale(${scale})`;
                slide.style.opacity = visible ? String(Math.max(.3, 1 - abs * .24)) : '0';
                slide.style.filter = distance === 0 ? 'saturate(1)' : 'saturate(.55)';
                slide.style.zIndex = String(100 - abs);
                slide.style.pointerEvents = visible ? 'auto' : 'none';
                slide.tabIndex = visible ? 0 : -1;
                slide.setAttribute('aria-hidden', visible ? 'false' : 'true');
            });
            current.textContent = String(index + 1).padStart(2, '0');
        };
        const move = step => {
            if (count <= 1) return;
            index = (index + step + count) % count;
            render();
        };
        previousButton.addEventListener('click', () => move(-1));
        nextButton.addEventListener('click', () => move(1));
        carousel.addEventListener('keydown', event => {
            if (event.key === 'ArrowLeft' || event.key === 'ArrowRight') {
                event.preventDefault();
                move(event.key === 'ArrowRight' ? 1 : -1);
            }
        });
        stage.addEventListener('wheel', event => {
            if (count <= 1) return;
            const delta = Math.abs(event.deltaX) > Math.abs(event.deltaY) ? event.deltaX : event.deltaY;
            if (Math.abs(delta) < 3) return;
            event.preventDefault();
            const now = performance.now();
            if (now - lastWheel < 390) return;
            lastWheel = now;
            move(delta > 0 ? 1 : -1);
        }, { passive: false });
        stage.addEventListener('pointerdown', event => {
            if (event.pointerType === 'mouse' && event.button !== 0) return;
            startX = event.clientX;
            startY = event.clientY;
        });
        stage.addEventListener('pointerup', event => {
            if (startX === null) return;
            const dx = event.clientX - startX;
            const dy = event.clientY - startY;
            if (Math.abs(dx) > 35 && Math.abs(dx) > Math.abs(dy)) {
                move(dx < 0 ? 1 : -1);
                suppressClick = true;
                setTimeout(() => { suppressClick = false; }, 100);
            }
            startX = null;
            startY = null;
        });
        stage.addEventListener('pointercancel', () => { startX = null; startY = null; });
        stage.addEventListener('click', event => {
            if (suppressClick) { event.preventDefault(); event.stopPropagation(); return; }
            const slide = event.target.closest('.coverflow-slide');
            if (!slide) return;
            const target = slides.indexOf(slide);
            if (target !== index) {
                event.preventDefault();
                const forward = (target - index + count) % count;
                move(forward <= count / 2 ? forward : forward - count);
            }
        }, true);
        window.addEventListener('resize', render, { passive: true });
        render();
    });
});
</script>
<!-- ULASAN DAN ASPIRASI WARGA -->
<section id="saran" class="max-w-7xl mx-auto px-4 sm:px-6 py-20 sm:py-28 scroll-mt-28">
    <!-- HEADER -->
    <div data-reveal="up"
         class="flex flex-col md:flex-row md:items-end justify-between gap-6 border-t border-[#d8d9d2] pt-10 sm:pt-12 mb-9 sm:mb-12">
        <div>
            <p class="text-xs uppercase tracking-[.24em] font-extrabold text-[#416051] mb-3">
                Cerita dari warga
            </p>
            <h2 class="font-display text-[clamp(3.3rem,10vw,6rem)] leading-none text-[#18271f]">
                SUARA WARGA.
            </h2>
            <p class="text-sm text-gray-600 leading-relaxed mt-4 max-w-xl">
                Ulasan, pengalaman, dan masukan untuk kegiatan NU Lesmana.
                Semua warga boleh ikut menyampaikan pendapat.
            </p>
        </div>
        <div class="self-start text-[11px] font-semibold uppercase tracking-[.14em] text-[#728579] md:mb-1">
            Ruang aspirasi terbuka
        </div>
    </div>
    <!-- NOTIFIKASI -->
    @if(session('success'))
        <div id="review-notification"
             class="mb-8 flex items-start gap-3 bg-[#e6eee5] border border-[#b8cdbb] text-[#183C2F] rounded-2xl p-5"
             role="status">
            <i class="ph ph-check-circle text-2xl"></i>
            <div class="flex-1">
                <p class="font-extrabold text-sm">Ulasan berhasil dikirim!</p>
                <p class="text-xs mt-1">{{ session('success') }}</p>
            </div>
            <button type="button"
                    onclick="this.closest('#review-notification').remove()"
                    class="text-[#183C2F] hover:opacity-60"
                    aria-label="Tutup notifikasi">
                <i class="ph ph-x text-lg"></i>
            </button>
        </div>
    @endif
    @if(session('error'))
        <div class="mb-8 flex items-start gap-3 bg-red-50 border border-red-200 text-red-700 rounded-2xl p-5"
             role="alert">
            <i class="ph ph-warning-circle text-2xl"></i>
            <div>
                <p class="font-extrabold text-sm">Ulasan gagal dikirim</p>
                <p class="text-xs mt-1">{{ session('error') }}</p>
            </div>
        </div>
    @endif
    @if($errors->any())
        <div class="mb-8 bg-red-50 border border-red-200 text-red-700 rounded-2xl p-5"
             role="alert">
            <p class="font-extrabold text-sm mb-2">
                Periksa kembali ulasanmu:
            </p>
            <ul class="list-disc pl-5 space-y-1 text-xs">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    <!-- SUARA WARGA BERGERAK: semua review dari database, tanpa filter dan pagination -->
    @php
        $reviewsTableExists = \Illuminate\Support\Facades\Schema::hasTable('reviews');
        $publicReviews = $reviewsTableExists
            ? \App\Models\Review::query()->where('is_visible', true)->latest()->get()->values()
            : collect();
        $reviewLanes = $publicReviews->count() === 1
            ? [$publicReviews, $publicReviews]
            : [
                $publicReviews->filter(fn ($review, $index) => $index % 2 === 0)->values(),
                $publicReviews->filter(fn ($review, $index) => $index % 2 === 1)->values()
            ];
    @endphp
    @if($publicReviews->isNotEmpty())
        <div class="mb-5 flex flex-wrap items-center justify-between gap-3 border-t border-[#D8DED6] pt-5">
            <p class="text-xs font-semibold text-[#718075]">{{ $publicReviews->count() }} ulasan warga · Klik kartu untuk membaca selengkapnya</p>
            <span class="inline-flex items-center gap-2 text-[11px] text-[#819185]"><i class="ph ph-arrows-left-right text-base" aria-hidden="true"></i> Ulasan bergerak otomatis</span>
        </div>
        <div class="nu-review-showcase" aria-label="Ulasan warga bergerak otomatis">
            @foreach($reviewLanes as $laneIndex => $laneReviews)
                @if($laneReviews->isNotEmpty())
                    <div class="nu-review-row" data-nu-review-row>
                        <div class="nu-review-track" data-direction="{{ $laneIndex === 0 ? 'left' : 'right' }}">
                            <div class="nu-review-group">
                                @foreach($laneReviews as $review)
                                    @php
                                        $reviewName = trim($review->name ?: 'Anonim');
                                        $reviewRating = max(1, min(5, (int) $review->rating));
                                    @endphp
                                    <button type="button" class="nu-review-card" data-nu-review-id="{{ $review->id }}" aria-label="Baca ulasan lengkap dari {{ $reviewName }}">
                                        <span class="flex items-center gap-3">
                                            <span class="nu-review-avatar" aria-hidden="true">{{ mb_strtoupper(mb_substr($reviewName, 0, 1)) }}</span>
                                            <span class="min-w-0 flex-1">
                                                <span class="block truncate text-[13px] font-bold text-[#183C2F]">{{ $reviewName }}</span>
                                                <span class="mt-0.5 block text-[10px] text-[#819185]">{{ $review->is_verified_member ? 'Anggota terverifikasi' : 'Pengunjung' }}</span>
                                            </span>
                                            <i class="ph ph-arrow-up-right text-[17px] text-[#A3B4A7]" aria-hidden="true"></i>
                                        </span>
                                        <span class="block tracking-[.1em] text-[#B9822C]" role="img" aria-label="{{ $reviewRating }} dari 5 bintang">
                                            @for($star = 1; $star <= 5; $star++)
                                                <span aria-hidden="true" class="text-[15px] {{ $star <= $reviewRating ? 'text-[#B9822C]' : 'text-[#D6DDD6]' }}">★</span>
                                            @endfor
                                        </span>
                                        <span class="nu-review-preview">{{ $review->message }}</span>
                                    </button>
                                @endforeach
                            </div>
                        </div>
                    </div>
                @endif
            @endforeach
        </div>
        <p class="nu-review-hint"><i class="ph ph-cursor-click text-base" aria-hidden="true"></i> Arahkan kursor atau sentuh kartu untuk menghentikan gerak, lalu klik untuk membaca.</p>
        <!-- Template popup dibuat sekali dari Blade; salinan animasi tidak menggandakan data di MySQL. -->
        @foreach($publicReviews as $review)
            @php
                $reviewName = trim($review->name ?: 'Anonim');
                $reviewRating = max(1, min(5, (int) $review->rating));
                $belongsToUser = auth()->check()
                    && $review->user_id !== null
                    && (int) $review->user_id === (int) auth()->id();
                $belongsToGuestSession = $review->user_id === null
                    && in_array((int) $review->id, array_map('intval', (array) session('review_owned_ids', [])), true);
                $canDeleteReview = $belongsToUser || $belongsToGuestSession;
            @endphp
            <template id="nu-review-detail-{{ $review->id }}">
                <div class="flex items-start justify-between gap-4">
                    <div class="flex items-center gap-3">
                        <span class="nu-review-avatar" aria-hidden="true">{{ mb_strtoupper(mb_substr($reviewName, 0, 1)) }}</span>
                        <div>
                            <h3 id="nu-review-modal-title" class="text-base font-bold text-[#183C2F]">{{ $reviewName }}</h3>
                            <p class="text-xs text-[#7B8B7F]">{{ $review->is_verified_member ? 'Anggota terverifikasi' : 'Pengunjung' }}</p>
                        </div>
                    </div>
                </div>
                <p class="mt-7 flex items-center gap-1" role="img" aria-label="{{ $reviewRating }} dari 5 bintang">
                    @for($star = 1; $star <= 5; $star++)
                        <span class="text-xl {{ $star <= $reviewRating ? 'text-[#B9822C]' : 'text-[#D5DDD4]' }}" aria-hidden="true">★</span>
                    @endfor
                </p>
                <p class="nu-modal-message mt-5">{{ $review->message }}</p>
                <div class="mt-7 flex flex-wrap items-center justify-between gap-3 border-t border-[#DEE5DB] pt-4">
                    <span class="text-[11px] font-semibold uppercase tracking-[.13em] text-[#819185]">Suara Warga</span>
                    <time class="text-xs text-[#819185]" datetime="{{ $review->created_at?->toIso8601String() }}">{{ $review->created_at?->translatedFormat('d F Y') }}</time>
                </div>
                @if($canDeleteReview)
                    <form method="POST" action="{{ route('reviews.destroy', $review) }}" class="mt-5" onsubmit="return confirm('Hapus ulasan milikmu secara permanen?');">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="rounded-full border border-[#E0C9C4] bg-[#FFF8F6] px-4 py-2.5 text-xs font-bold text-[#98392C] hover:bg-[#FCEAE6]">Hapus ulasan saya</button>
                    </form>
                @endif
            </template>
        @endforeach
        <div class="nu-review-modal" id="nuReviewModal" role="presentation" hidden>
            <div class="nu-review-dialog" role="dialog" aria-modal="true" aria-labelledby="nu-review-modal-title" tabindex="-1">
                <div class="flex items-center justify-between gap-3 border-b border-[#DDE6DB] pb-4">
                    <p class="text-[11px] font-bold uppercase tracking-[.16em] text-[#728679]">Ulasan warga</p>
                    <button type="button" class="nu-review-close" id="nuReviewClose" aria-label="Tutup ulasan"><i class="ph ph-x text-lg" aria-hidden="true"></i></button>
                </div>
                <div id="nuReviewModalContent" class="pt-5"></div>
            </div>
        </div>
    @else
        <div class="rounded-[20px] border border-[#DDE5DB] bg-white px-6 py-12 text-center">
            <i class="ph ph-chat-circle-dots text-3xl text-[#183C2F]" aria-hidden="true"></i>
            <p class="mt-3 font-bold text-[#183C2F]">Belum ada ulasan warga.</p>
            <p class="mt-1 text-sm text-[#718075]">Jadilah orang pertama yang berbagi pendapat.</p>
        </div>
    @endif
    <script>
    (function () {
        function initMovingReviews() {
            const root = document.getElementById('saran');
            if (!root) return;
            const rows = Array.from(root.querySelectorAll('[data-nu-review-row]'));
            const modal = document.getElementById('nuReviewModal');
            const content = document.getElementById('nuReviewModalContent');
            const close = document.getElementById('nuReviewClose');
            let focusBeforeModal = null;
            let previousBodyOverflow = '';
            let resizeTimer;
            const makeInaccessible = function (element) {
                element.setAttribute('aria-hidden', 'true');
                element.querySelectorAll('button').forEach(function (button) { button.tabIndex = -1; });
                if (element.matches('button')) element.tabIndex = -1;
            };
            function setupRow(row, index) {
                const track = row.querySelector('.nu-review-track');
                const group = track ? track.querySelector('.nu-review-group') : null;
                if (!track || !group) return;
                track.style.animation = 'none';
                track.querySelectorAll('[data-nu-track-copy]').forEach(function (element) { element.remove(); });
                group.querySelectorAll('[data-nu-repeat]').forEach(function (element) { element.remove(); });
                const originalCards = Array.from(group.children);
                if (!originalCards.length) return;
                const requiredWidth = Math.max(row.clientWidth + 40, 360);
                let repeats = 0;
                while (group.scrollWidth < requiredWidth && repeats < 30) {
                    originalCards.forEach(function (card) {
                        const copy = card.cloneNode(true);
                        copy.dataset.nuRepeat = '1';
                        makeInaccessible(copy);
                        group.appendChild(copy);
                    });
                    repeats++;
                }
                const secondGroup = group.cloneNode(true);
                secondGroup.dataset.nuTrackCopy = '1';
                makeInaccessible(secondGroup);
                track.appendChild(secondGroup);
                const distance = group.getBoundingClientRect().width;
                const pixelsPerSecond = index === 0 ? 33 : 28;
                track.style.setProperty('--nu-review-duration', Math.max(18, Math.round(distance / pixelsPerSecond)) + 's');
                void track.offsetWidth;
                track.style.animation = '';
            }
            rows.forEach(function (row, index) {
                setupRow(row, index);
                let touchTimer;
                row.addEventListener('touchstart', function () {
                    clearTimeout(touchTimer);
                    row.classList.add('is-touched');
                }, { passive: true });
                row.addEventListener('touchend', function () {
                    clearTimeout(touchTimer);
                    touchTimer = setTimeout(function () { row.classList.remove('is-touched'); }, 1800);
                }, { passive: true });
                row.addEventListener('touchcancel', function () { row.classList.remove('is-touched'); }, { passive: true });
            });
            window.addEventListener('resize', function () {
                clearTimeout(resizeTimer);
                resizeTimer = setTimeout(function () {
                    rows.forEach(setupRow);
                }, 220);
            }, { passive: true });
            if (!modal || !content || !close) return;
            function openReview(button) {
                const reviewId = button.dataset.nuReviewId;
                if (!reviewId || !/^\d+$/.test(reviewId)) return;
                const source = document.getElementById('nu-review-detail-' + reviewId);
                if (!source) return;
                focusBeforeModal = button;
                content.replaceChildren(source.content.cloneNode(true));
                previousBodyOverflow = document.body.style.overflow;
                document.body.style.overflow = 'hidden';
                document.body.classList.add('nu-review-modal-open');
                modal.hidden = false;
                close.focus();
            }
            function closeReview() {
                if (modal.hidden) return;
                modal.hidden = true;
                content.replaceChildren();
                document.body.style.overflow = previousBodyOverflow;
                document.body.classList.remove('nu-review-modal-open');
                if (focusBeforeModal && focusBeforeModal.isConnected) focusBeforeModal.focus({ preventScroll: true });
            }
            root.addEventListener('click', function (event) {
                const button = event.target.closest('[data-nu-review-id]');
                if (button && root.contains(button)) openReview(button);
            });
            close.addEventListener('click', closeReview);
            modal.addEventListener('click', function (event) { if (event.target === modal) closeReview(); });
            document.addEventListener('keydown', function (event) {
                if (modal.hidden) return;
                if (event.key === 'Escape') { event.preventDefault(); closeReview(); }
                if (event.key !== 'Tab') return;
                const focusable = Array.from(modal.querySelectorAll('button:not([disabled]), a[href], input:not([disabled]), textarea:not([disabled])'));
                if (!focusable.length) { event.preventDefault(); close.focus(); return; }
                const first = focusable[0];
                const last = focusable[focusable.length - 1];
                if (event.shiftKey && document.activeElement === first) { event.preventDefault(); last.focus(); }
                else if (!event.shiftKey && document.activeElement === last) { event.preventDefault(); first.focus(); }
            });
        }
        if (document.readyState === 'loading') document.addEventListener('DOMContentLoaded', initMovingReviews, { once: true });
        else initMovingReviews();
    })();
    </script>
    <!-- FORM ULASAN -->
    <div data-reveal="up"
         class="mt-16 grid min-w-0 items-start gap-10 border-t border-[#D8DED6] pt-12 sm:mt-20 sm:pt-16 lg:grid-cols-[.85fr_1.15fr] lg:gap-20">
        <!-- TEKS KIRI: singkat dan lega -->
        <div class="max-w-[440px] lg:pt-6">
            <p class="mb-4 text-xs font-bold uppercase tracking-[.2em] text-[#416051]">Berikan ulasan</p>
            <h3 class="font-display text-5xl leading-none text-[#18271F] sm:text-6xl">PENDAPATMU<br>BERARTI.</h3>
            <p class="mt-7 max-w-sm text-sm leading-8 text-[#53665A] sm:text-[15px]">
                Bagikan pengalaman, kritik, atau saran untuk NU Lesmana. Masukanmu membantu kami terus berkembang.
            </p>
            <div class="mt-9 border-t border-[#D6DFD4] pt-5">
                <p class="flex items-center gap-2 text-xs font-semibold text-[#738578]">
                    <i class="ph ph-users-three text-lg text-[#183C2F]" aria-hidden="true"></i>
                    Terbuka untuk anggota maupun pengunjung.
                </p>
            </div>
        </div>
        <!-- FORM KANAN -->
        <form id="form-ulasan"
              action="{{ route('reviews.store', [], false) }}"
              method="POST"
              class="landing-form rounded-[1.5rem] border border-[#DEE5DB] bg-white p-6 sm:p-9 space-y-6">
            @csrf
            <!-- RATING -->
            <div>
                <label class="mb-3 block text-sm font-bold text-[#183C2F]">
                    Penilaian kamu <span class="text-red-600">*</span>
                </label>
                <div class="flex flex-row-reverse justify-end gap-1 sm:gap-2 rating-picker"
                     role="radiogroup"
                     aria-label="Penilaian bintang">
                    @for($rating = 5; $rating >= 1; $rating--)
                        <input
                            class="sr-only"
                            type="radio"
                            id="rating-{{ $rating }}"
                            name="rating"
                            value="{{ $rating }}"
                            @checked((int) old('rating', 5) === $rating)
                            required
                        >
                        <label for="rating-{{ $rating }}"
                               class="cursor-pointer text-3xl sm:text-4xl"
                               title="{{ $rating }} bintang"
                               aria-label="{{ $rating }} bintang">
                            ★
                        </label>
                    @endfor
                </div>
                <p class="text-xs text-gray-500 mt-2">
                    Pilih 1 sampai 5 bintang.
                </p>
            </div>
            <!-- NAMA -->
            <div>
                <label for="review-name"
                       class="mb-2 block text-sm font-bold text-[#183C2F]">
                    Nama tampilan
                    <span class="text-gray-400 font-medium">
                        (opsional untuk tamu)
                    </span>
                </label>
                <input
                    id="review-name"
                    type="text"
                    name="name"
                    value="{{ old('name', auth()->user()?->name ?? '') }}"
                    maxlength="80"
                    @if(auth()->check()) readonly @endif
                    placeholder="Anonim"
                    class="w-full rounded-xl px-4 py-3.5 text-sm"
                >
                <p class="text-xs text-gray-500 mt-2">
                    Kosongkan jika ingin tampil sebagai Anonim.
                </p>
            </div>
            <!-- PESAN -->
            <div>
                <label for="review-message"
                       class="mb-2 block text-sm font-bold text-[#183C2F]">
                    Ulasan atau aspirasi
                    <span class="text-red-600">*</span>
                </label>
                <textarea
                    id="review-message"
                    name="message"
                    rows="5"
                    required
                    minlength="10"
                    maxlength="2000"
                    placeholder="Bagikan pengalaman atau masukanmu di sini..."
                    class="w-full rounded-xl px-4 py-3.5 text-sm leading-7"
                >{{ old('message') }}</textarea>
                <p class="text-xs text-gray-500 mt-2">
                    Minimal 10 karakter, maksimal 2.000 karakter.
                </p>
            </div>
            <!-- SUBMIT -->
            <button type="submit"
                    class="inline-flex w-full items-center justify-center gap-3 rounded-full bg-[#183C2F] px-8 py-4 text-sm font-bold text-white transition-colors hover:bg-[#245541] sm:w-auto">
                <i class="ph ph-paper-plane-tilt text-lg"></i>
                Kirim Ulasan
            </button>
        </form>
    </div>
</section>

    <!-- FAQ -->
    <section id="faq" class="max-w-5xl mx-auto px-4 sm:px-6 pt-20 pb-20 sm:pt-24 sm:pb-28 scroll-mt-28">
        <div data-reveal class="text-center mb-12">
            <p class="text-[11px] font-bold tracking-[.22em] uppercase text-[#6d8274] mb-3">Pusat informasi</p>
            <h2 class="text-[clamp(2.6rem,4.7vw,4.7rem)] font-semibold leading-[1.12] tracking-[-.06em] text-[#183C2F]">Pertanyaan umum.</h2>
            <p class="text-sm text-[#657268] mt-4">Informasi singkat seputar layanan Nulesmana.</p>
        </div>
        @foreach([
            ['Apa itu Nulesmana?', 'Nulesmana adalah portal informasi kegiatan, organisasi, dan layanan keanggotaan warga NU Lesmana.'],
            ['Bagaimana cara mendaftar menjadi anggota?', 'Pilih Daftar Anggota, isi data yang diminta, kemudian ikuti proses verifikasi dari pengurus.'],
            ['Bagaimana cara mengakses kartu anggota?', 'Masuk ke akun anggota dan buka layanan kartu digital yang tersedia sesuai status akunmu.'],
            ['Di mana saya bisa membaca berita dan agenda?', 'Buka halaman Berita & Agenda melalui menu navigasi website.'],
            ['Bagaimana cara mengirim ulasan atau saran?', 'Isi formulir Suara Warga di halaman ini, pilih penilaian, lalu kirim pesanmu.']
        ] as [$question, $answer])
            <details data-reveal class="group border-b border-[#d7ded5] py-5">
                <summary class="cursor-pointer list-none flex items-center justify-between gap-5 text-[#183C2F] font-semibold text-base sm:text-lg [&::-webkit-details-marker]:hidden">
                    <span>{{ $question }}</span>
                    <i class="ph ph-plus text-xl group-open:rotate-45 transition-transform" aria-hidden="true"></i>
                </summary>
                <p class="text-sm text-[#607065] leading-7 max-w-3xl pt-4">{{ $answer }}</p>
            </details>
        @endforeach
    </section>

    <!-- ALAMAT & SEKRETARIAT: wilayah terverifikasi, alamat gedung belum tersedia -->
    <section id="alamat" class="mx-auto max-w-7xl scroll-mt-32 px-4 pt-12 pb-20 sm:px-6 sm:pt-20 sm:pb-28" aria-labelledby="alamat-heading">
        <div data-reveal class="flex flex-col justify-between gap-5 border-t border-[#D8DED6] pt-9 sm:flex-row sm:items-end">
            <div>
                <p class="mb-3 text-[11px] font-bold uppercase tracking-[.22em] text-[#738A78]">05 / Lokasi Kami</p>
                <h2 id="alamat-heading" class="text-3xl font-semibold tracking-[-.055em] text-[#183C2F] sm:text-5xl">Alamat &amp; Sekretariat.</h2>
            </div>
            <p class="max-w-sm text-sm leading-7 text-[#69786E]">Berada di wilayah Desa Lesmana, Ajibarang, Kabupaten Banyumas, Jawa Tengah.</p>
        </div>
        <div class="mt-12 grid items-stretch gap-10 lg:grid-cols-[.85fr_1.15fr] lg:gap-16">
            <div data-reveal class="flex flex-col justify-between border-t border-[#D8DED6] py-7">
                <div>
                    <div class="mb-5 flex h-12 w-12 items-center justify-center rounded-full border border-[#D3DED2] text-[#183C2F]">
                        <i class="ph ph-map-pin text-2xl" aria-hidden="true"></i>
                    </div>
                    <p class="text-[11px] font-bold uppercase tracking-[.18em] text-[#708676]">Wilayah Pengurus Ranting NU Lesmana</p>
                    <address class="mt-5 not-italic text-[22px] font-semibold leading-[1.55] tracking-[-.035em] text-[#183C2F] sm:text-[28px]">
                        Desa Lesmana,<br>
                        Kecamatan Ajibarang,<br>
                        Kabupaten Banyumas,<br>
                        Jawa Tengah 53163.
                    </address>
                    <p class="mt-5 max-w-md text-sm leading-7 text-[#68796C]">Alamat jalan, RT/RW, dan titik sekretariat resmi akan dilengkapi setelah dikonfirmasi oleh pengurus. Lokasi pada peta menunjukkan wilayah Desa Lesmana, bukan titik kantor sekretariat.</p>
                </div>
                <div class="mt-8 flex flex-wrap items-center gap-3">
                    <a href="https://www.google.com/maps/search/?api=1&amp;query=Desa%20Lesmana%2C%20Ajibarang%2C%20Banyumas" target="_blank" rel="noopener noreferrer" class="inline-flex min-h-[48px] items-center justify-center gap-2 rounded-full bg-[#183C2F] px-6 py-3 text-xs font-bold text-white transition-colors hover:bg-[#285340]">
                        Lihat Wilayah di Maps <i class="ph ph-arrow-up-right text-base" aria-hidden="true"></i>
                    </a>
                    <a href="#saran" class="inline-flex min-h-[48px] items-center justify-center gap-2 rounded-full border border-[#183C2F]/35 px-6 py-3 text-xs font-bold text-[#183C2F] transition-colors hover:bg-[#E8EFE7]">
                        Sampaikan Masukan <i class="ph ph-arrow-up-right text-base" aria-hidden="true"></i>
                    </a>
                </div>
            </div>
            <div data-reveal class="relative min-h-[280px] overflow-hidden rounded-[22px] border border-[#D8DED6] bg-[#E6ECE4] sm:min-h-[350px]">
                <iframe title="Peta wilayah Desa Lesmana, Ajibarang, Banyumas" src="https://www.google.com/maps?q=Desa%20Lesmana%2C%20Ajibarang%2C%20Banyumas&amp;output=embed" class="absolute inset-0 h-full w-full border-0" loading="lazy" referrerpolicy="no-referrer-when-downgrade" allowfullscreen></iframe>
                <div class="pointer-events-none absolute bottom-4 left-4 rounded-full border border-[#D8DED6] bg-[#F5F4F0]/95 px-4 py-2 text-[10px] font-bold uppercase tracking-[.12em] text-[#183C2F] shadow-sm">Peta wilayah, bukan titik sekretariat</div>
            </div>
        </div>
    </section>

    <!-- FOOTER EDITORIAL -->
    <footer class="bg-[#14271e] text-white mt-8">
      <div class="max-w-7xl mx-auto px-6 py-14 sm:py-20">
        <div class="grid gap-10 md:grid-cols-3">
          <div>
            <p class="text-xs uppercase tracking-[.2em] text-white/60 mb-3">Pengurus Ranting Nahdlatul Ulama</p>
            <h2 class="font-display text-5xl sm:text-6xl">NU LESMANA.</h2>
            <p class="text-sm text-white/65 mt-4 max-w-xs leading-7">Portal informasi kegiatan, organisasi, dan layanan keanggotaan warga NU Lesmana.</p>
          </div>
          <div>
            <h3 class="text-sm font-bold mb-5">Jelajahi</h3>
            <nav class="flex flex-col gap-3 text-sm text-white/65">
              <a class="hover:text-white" href="{{ route('home') }}">Beranda</a>
              <a class="hover:text-white" href="{{ route('public.news.index') }}">Berita & Agenda</a>
              <a class="hover:text-white" href="#tentang">Tentang NU Lesmana</a>
              <a class="hover:text-white" href="{{ route('struktur.organisasi') }}">Struktur Banom</a>
              <a class="hover:text-white" href="#alamat">Alamat &amp; Sekretariat</a>
            </nav>
          </div>
          <div>
            <h3 class="text-sm font-bold mb-5">Keanggotaan</h3>
            <nav class="flex flex-col gap-3 text-sm text-white/65">
              <a class="hover:text-white" href="{{ route('member.signup') }}">Daftar Anggota</a>
              @auth
                <a class="hover:text-white" href="{{ auth()->user()->role === 'admin' ? route('admin.dashboard') : route('member.dashboard') }}">{{ auth()->user()->role === 'admin' ? 'Panel Admin' : 'Akun Saya' }}</a>
              @else
                <a class="hover:text-white" href="{{ route('member.login') }}">Login Anggota</a>
              @endauth
              <a class="hover:text-white" href="{{ route('kia.cek') }}">Cek KIA</a>
              <a class="hover:text-white" href="#saran">Ulasan & Aspirasi</a>
            </nav>
          </div>
        </div>
        <div class="border-t border-white/15 mt-14 pt-6 flex flex-col sm:flex-row justify-between gap-2 text-xs text-white/50">
          <span>© {{ date('Y') }} PRNU Lesmana. Seluruh hak dilindungi.</span>
          <span>Informasi • Pelayanan • Kebersamaan</span>
        </div>
      </div>
    </footer>
    {{-- Isi dengan tautan SALURAN WhatsApp resmi, misalnya URL yang disalin dari menu Bagikan Saluran. --}}
    @php
        $whatsappChannelUrl = 'https://whatsapp.com/channel/0029VbDQNYVGU3BES9BBQ03W';
    @endphp
    @if($whatsappChannelUrl)
        <a href="{{ $whatsappChannelUrl }}" target="_blank" rel="noopener noreferrer"
           aria-label="Buka Saluran WhatsApp NU Lesmana" title="Ikuti Saluran WhatsApp NU Lesmana"
           class="fixed bottom-5 right-5 sm:bottom-7 sm:right-7 z-50 inline-flex items-center gap-2 bg-[#173d30] text-white px-4 py-3 rounded-full border border-white/20 shadow-lg hover:bg-[#102b21] transition">
            <i class="ph ph-whatsapp-logo text-2xl" aria-hidden="true"></i>
            <span class="hidden sm:inline text-xs font-bold">Saluran NU Lesmana</span>
        </a>
    @endif
    <script src="{{ asset('js/nulesmana-animations.js') }}" defer></script>
    <script>
        (function () {
            const skeleton = document.getElementById('nu-skeleton');
            if (!skeleton) {
                return;
            }
            let dismissed = false;
            function hideSkeleton() {
                if (dismissed) {
                    return;
                }
                dismissed = true;
                skeleton.classList.add('is-hidden');
                document.querySelectorAll('[data-hero-enter]').forEach(function (element, index) {
                    window.setTimeout(function () { element.classList.add('nl-hero-visible'); }, index * 140);
                });
                window.setTimeout(function () {
                    skeleton.remove();
                }, 350);
            }
            function whenLayoutReady() {
                window.requestAnimationFrame(function () {
                    window.requestAnimationFrame(hideSkeleton);
                });
            }
            function waitForHeroImage() {
                const heroImage = document.getElementById('nu-hero-image');
                if (!heroImage || heroImage.complete) {
                    whenLayoutReady();
                    return;
                }
                heroImage.addEventListener('load', whenLayoutReady, { once: true });
                heroImage.addEventListener('error', whenLayoutReady, { once: true });
            }
            if (document.readyState === 'loading') {
                document.addEventListener('DOMContentLoaded', waitForHeroImage, { once: true });
            } else {
                waitForHeroImage();
            }
            // External images/fonts should never keep the overlay on screen indefinitely.
            window.setTimeout(whenLayoutReady, 5500);
            // Restored pages from the back/forward cache must be usable immediately.
            window.addEventListener('pageshow', function (event) {
                if (event.persisted) {
                    hideSkeleton();
                }
            });
        })();
    </script>
        <script defer src="{{ asset('js/nulesmana-techtext.js') }}?v=61"></script>
</body>
</html>
