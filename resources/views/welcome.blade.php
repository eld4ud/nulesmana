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
            font-family: 'DM Sans', system-ui, sans-serif;
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
            display: grid;
            grid-template-columns: repeat(2, minmax(0, 1fr));
            gap: 12px;
            max-width: 450px;
            margin-top: 12px;
        }

        #nu-skeleton .nu-sk-button {
            height: 52px;
            border-radius: 10px;
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

    <link href="https://fonts.googleapis.com/css2?family=Amiri:wght@400;700&family=Bebas+Neue&family=DM+Sans:ital,opsz,wght@0,9..40,100..1000;1,9..40,100..1000&display=swap" rel="stylesheet">

    <script src="https://unpkg.com/@phosphor-icons/web"></script>

    <style>

        body { font-family: 'DM Sans', sans-serif; }

        .font-arabic { font-family: 'Amiri', serif; font-weight: 400; }

        .font-linktree { font-family: 'DM Sans', sans-serif; }

        .font-display { font-family: 'Bebas Neue', sans-serif; font-weight: 400; letter-spacing: .02em; }

        .slide-item { transition: opacity 0.8s ease-in-out; }

        .no-scrollbar::-webkit-scrollbar { display: none; }

        .no-scrollbar { scrollbar-width: none; }

        .rating-picker label { color: #d5d9d1; }

        .rating-picker input:checked ~ label,

        .rating-picker label:hover,

        .rating-picker label:hover ~ label { color: #b77b18; }

        .rating-picker input:focus-visible + label { outline: 2px solid #183C2F; border-radius: 5px; }

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

    </style>

</head>

<body class="bg-[#f6f7f3] text-gray-900 min-h-screen relative overflow-x-hidden selection:bg-[#203d2e] selection:text-white">

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

    <!-- ================= HERO ================= -->

    <main class="max-w-7xl mx-auto px-4 sm:px-6 pt-4 sm:pt-8 pb-12 sm:pb-16">

        <div class="flex flex-col lg:flex-row items-center gap-10 lg:gap-6">

            <!-- TEKS KIRI -->

            <div class="w-full lg:w-1/2 flex flex-col items-center lg:items-start text-center lg:text-left">

                <div class="mb-5 text-center lg:text-left">

                    <p lang="ar" dir="rtl" class="font-arabic text-[1.65rem] sm:text-4xl text-[#173d30] leading-[1.8]">السَّلَامُ عَلَيْكُمْ وَرَحْمَةُ اللَّهِ وَبَرَكَاتُهُ</p>

                    <p class="text-[11px] sm:text-xs tracking-[.16em] uppercase font-semibold text-gray-500 mt-1">Selamat datang di Portal NU Lesmana</p>

                </div>

                <h1 class="font-display text-6xl sm:text-8xl lg:text-[6.5rem] xl:text-[7.5rem] leading-[0.92] text-gray-900 mb-5 sm:mb-6">

                    PORTAL RESMI <br>

                    <span class="text-[#203d2e]">LESMANA.</span>

                </h1>

                <p class="text-sm sm:text-base lg:text-lg font-semibold text-gray-800 mb-6 sm:mb-8 leading-relaxed max-w-lg">

                    Pusat informasi kegiatan majelis, berita agenda keagamaan, serta layanan pendaftaran anggota Badan Otonom Ranting NU dengan verifikasi NIA otomatis.

                </p>

                <div class="grid grid-cols-2 gap-3 sm:gap-4 w-full sm:max-w-md">

                    <a href="{{ route('member.signup') }}" class="flex items-center justify-center gap-2 text-xs sm:text-sm font-black px-5 sm:px-7 py-3.5 sm:py-4 rounded-lg transition shadow-sm text-center bg-gray-900 text-white hover:bg-[#2f533c]">

                        <i class="ph ph-user-plus text-base sm:text-lg"></i> Daftar Sekarang

                    </a>

                    <a
                        href="{{ auth()->check() && auth()->user()->role === 'member' && auth()->user()->status === 'approved' ? route('member.kia') : route('member.signup') }}"
                        class="inline-flex items-center justify-center gap-2 rounded-xl px-6 py-3.5 text-sm font-bold"
                        style="background-color: #183C2F; color: #FFFFFF;"
                    >
                        <i class="ph ph-identification-card text-xl"></i>
                        <span>Cek KIA</span>
                    </a>

                    @auth

                        <a href="{{ auth()->user()->role === 'admin' ? route('admin.dashboard') : route('member.dashboard') }}" class="flex items-center justify-center gap-2 text-xs sm:text-sm font-black px-5 sm:px-7 py-3.5 sm:py-4 rounded-lg transition shadow-sm text-center bg-white border-2 border-gray-900 text-gray-900 hover:bg-gray-50">

                            <i class="ph ph-squares-four text-base sm:text-lg"></i> {{ auth()->user()->role === 'admin' ? 'Panel Admin' : 'Akun Saya' }}

                        </a>

                    @else

                        <a href="{{ route('member.login') }}" class="flex items-center justify-center gap-2 text-xs sm:text-sm font-black px-5 sm:px-7 py-3.5 sm:py-4 rounded-lg transition shadow-sm text-center bg-white border-2 border-gray-900 text-gray-900 hover:bg-gray-50">

                            <i class="ph ph-sign-in text-base sm:text-lg"></i> Login Anggota

                        </a>

                    @endauth

                    <a href="{{ route('page.profil') }}" class="flex items-center justify-center gap-2 text-xs sm:text-sm font-black px-5 sm:px-7 py-3.5 sm:py-4 rounded-lg transition shadow-sm text-center border-2 border-gray-900 text-gray-900 hover:bg-gray-900 hover:text-white">

                        <i class="ph ph-info text-base sm:text-lg"></i> Profil NU Lesmana

                    </a>

                </div>

            </div>

            <!-- FOTO KH. HASYIM ASY'ARI: satu fokus visual, tanpa ornamen -->
            <div class="w-full lg:w-1/2">
                <figure class="relative mx-auto max-w-[35rem] overflow-hidden rounded-[1.65rem] bg-[#15392B] lg:ml-auto lg:mr-0">
                    <div class="relative h-[350px] sm:h-[460px] lg:h-[510px]">
                        {{-- Sumber foto dipertahankan dari hero versi sebelumnya. --}}
                        
                        <img
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

    <!-- BENEFITS / CARA KERJA -->
    <section id="manfaat" class="max-w-7xl mx-auto px-4 sm:px-6 py-16 sm:py-24">
        <div data-reveal class="text-center mb-12">
            <p class="text-[11px] font-bold tracking-[.22em] uppercase text-[#6d8274] mb-3">Portal digital warga</p>
            <h2 class="text-4xl sm:text-6xl font-semibold tracking-[-.06em] text-[#183C2F]">Satu portal, lebih mudah.</h2>
            <p class="text-sm text-[#657268] mt-4 max-w-xl mx-auto">Dari pendaftaran anggota sampai informasi kegiatan, semua tersedia dalam satu tempat.</p>
        </div>
        <div class="grid md:grid-cols-3 gap-3">
            @foreach([
                ['01', 'Daftar anggota.', 'Buat akun dan ikuti proses verifikasi keanggotaan.', 'ph-user-plus'],
                ['02', 'Akses layanan.', 'Lihat informasi akun dan layanan kartu anggota digital.', 'ph-identification-card'],
                ['03', 'Ikuti kegiatan.', 'Temukan berita dan agenda terbaru warga NU Lesmana.', 'ph-newspaper']
            ] as [$number, $heading, $description, $icon])
                <div data-reveal class="group min-h-[300px] bg-[#eeefeb] rounded-[22px] p-7 sm:p-9 flex flex-col border border-[#e2e6de] hover:bg-[#e7ebe5] transition-colors duration-300">
                    <span class="text-xs font-bold text-[#76917e]">{{ $number }}</span>
                    <h3 class="mt-6 text-3xl sm:text-4xl font-medium tracking-[-.06em] text-[#183C2F] leading-tight">{{ $heading }}</h3>
                    <p class="mt-3 text-sm text-[#66746a] leading-6">{{ $description }}</p>
                    <div class="mt-auto pt-9 flex justify-end">
                        <span class="w-16 h-16 rounded-2xl bg-white border border-[#dbe2d9] flex items-center justify-center text-[#183C2F]">
                            <i class="ph {{ $icon }} text-3xl" aria-hidden="true"></i>
                        </span>
                    </div>
                </div>
            @endforeach
        </div>
        <div class="mt-8 text-center">
            <a href="{{ route('member.signup') }}" class="inline-flex items-center gap-3 rounded-full bg-[#183C2F] text-white px-7 py-3 text-xs font-bold hover:bg-[#29523f] transition">
                Mulai daftar <i class="ph ph-arrow-up-right text-base" aria-hidden="true"></i>
            </a>
        </div>
    </section>

    <!-- GALERI COVERFLOW: mouse wheel, drag, touch, dan putaran tanpa akhir -->
    @php
        $galleryNews = collect($publishedNews ?? [])->filter(fn ($item) => filled($item->image))->take(8)->values();
    @endphp
    <section id="galeri" class="py-16 sm:py-24 scroll-mt-28 overflow-hidden">
        <div class="max-w-7xl mx-auto px-4 sm:px-6">
            <div data-reveal class="text-center mb-8 sm:mb-12">
                <p class="text-[11px] font-bold tracking-[.22em] uppercase text-[#6d8274] mb-3">Dokumentasi kegiatan</p>
                <h2 class="text-4xl sm:text-6xl font-semibold tracking-[-.06em] text-[#183C2F]">Cerita dari Lesmana.</h2>
                <p class="text-sm text-[#657268] mt-4">Geser dengan mouse, scroll, atau sentuh untuk melihat momen lainnya.</p>
            </div>
        </div>
        @if($galleryNews->isNotEmpty())
            <div class="nulesmana-coverflow relative mx-auto max-w-[1440px] select-none"
                 data-coverflow tabindex="0" role="region"
                 aria-label="Galeri dokumentasi kegiatan NU Lesmana">
                <div class="coverflow-stage relative h-[255px] sm:h-[340px] lg:h-[415px] overflow-hidden cursor-grab active:cursor-grabbing touch-pan-y">
                    @foreach($galleryNews as $photo)
                        <a class="coverflow-slide absolute top-1/2 left-1/2 block w-[280px] h-[158px] sm:w-[400px] sm:h-[225px] lg:w-[520px] lg:h-[293px] rounded-[20px] overflow-hidden bg-[#e4e8e1] shadow-lg outline-offset-4 focus-visible:outline-2 focus-visible:outline-[#183C2F]"
                           href="{{ route('public.news.show', $photo->id) }}"
                           aria-label="Baca berita: {{ $photo->title }}" draggable="false">
                            <img src="{{ \Illuminate\Support\Facades\Storage::url($photo->image) }}"
                                 alt="{{ $photo->title }}" loading="lazy" draggable="false"
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
            const count = slides.length;
            if (!count) return;
            let index = 0;
            let startX = null;
            let startY = null;
            let lastWheel = 0;
            let dragging = false;
            let suppressClick = false;

            const render = () => {
                const mobile = window.innerWidth < 640;
                const spacing = mobile ? 150 : window.innerWidth < 1024 ? 230 : 320;
                slides.forEach((slide, i) => {
                    // Posisi melingkar: foto setelah urutan terakhir kembali ke awal.
                    let distance = (i - index + count) % count;
                    if (distance > count / 2) distance -= count;
                    // Untuk jumlah genap, kartu di sisi belakang tetap konsisten.
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
            carousel.querySelector('.coverflow-prev').addEventListener('click', () => move(-1));
            carousel.querySelector('.coverflow-next').addEventListener('click', () => move(1));
            carousel.addEventListener('keydown', event => {
                if (event.key === 'ArrowLeft' || event.key === 'ArrowRight') {
                    event.preventDefault();
                    move(event.key === 'ArrowRight' ? 1 : -1);
                }
            });
            stage.addEventListener('wheel', event => {
                if (count <= 1) return;
                // Scroll vertikal di atas galeri menggerakkan carousel.
                // Trackpad/mouse yang mengirim banyak event dibatasi per langkah.
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
                dragging = false;
            });
            stage.addEventListener('pointermove', event => {
                if (startX === null) return;
                if (Math.abs(event.clientX - startX) > 12) dragging = true;
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
                dragging = false;
            });
            stage.addEventListener('pointercancel', () => { startX = null; startY = null; dragging = false; });
            stage.addEventListener('click', event => {
                if (suppressClick) { event.preventDefault(); event.stopPropagation(); return; }
                const slide = event.target.closest('.coverflow-slide');
                if (!slide) return;
                const target = slides.indexOf(slide);
                if (target !== index) {
                    event.preventDefault();
                    // Klik foto samping memindahkan fokus, klik foto tengah membuka berita.
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

<section id="saran" class="max-w-7xl mx-auto px-4 sm:px-6 py-16 sm:py-24 scroll-mt-28">

    <!-- HEADER -->

    <div data-reveal="up"

         class="flex flex-col md:flex-row md:items-end justify-between gap-5 border-t border-[#d8d9d2] pt-12 mb-10">

        <div>

            <p class="text-xs uppercase tracking-[.24em] font-extrabold text-[#416051] mb-3">

                Cerita dari warga

            </p>

            <h2 class="font-display text-6xl sm:text-8xl text-[#18271f] leading-none">

                SUARA WARGA.

            </h2>

            <p class="text-sm text-gray-600 leading-relaxed mt-4 max-w-xl">

                Ulasan, pengalaman, dan masukan untuk kegiatan NU Lesmana.

                Semua warga boleh ikut menyampaikan pendapat.

            </p>

        </div>

        <div class="text-xs font-bold text-[#416051] bg-[#e6eee5] rounded-full px-5 py-3 self-start">

            Ulasan publik • 1–5 bintang

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

    <!-- AMBIL ULASAN PUBLIK -->

    @php

        $publicReviews = \Illuminate\Support\Facades\Schema::hasTable('reviews')

            ? \App\Models\Review::query()

                ->where('is_visible', true)

                ->latest()

                ->take(6)

                ->get()

            : collect();

    @endphp

    <!-- DAFTAR ULASAN -->

    <div class="grid md:grid-cols-2 xl:grid-cols-3 gap-4 sm:gap-5 mb-12">

        @forelse($publicReviews as $review)

            <article data-reveal="up"

                     class="review-card {{ $loop->iteration % 3 === 2 ? 'bg-[#183C2F] text-white border-[#183C2F]' : 'bg-white text-[#183C2F] border-[#e0e5dc]' }} border rounded-2xl p-6 sm:p-7 transition-all duration-300 hover:-translate-y-1">

                <!-- BINTANG -->

                <div class="flex items-center gap-1 text-[#b77b18] mb-5"

                     aria-label="{{ $review->rating }} dari 5 bintang">

                    @for($star = 1; $star <= 5; $star++)

                        <i class="ph {{ $star <= $review->rating ? 'ph-star-fill' : 'ph-star' }} text-lg"></i>

                    @endfor

                </div>

                <!-- PESAN -->

                <p class="text-sm leading-7 whitespace-pre-line break-words">

                    {{ $review->message }}

                </p>

                <!-- IDENTITAS -->

                <div class="border-t border-current/15 mt-6 pt-5 flex justify-between items-center gap-3">

                    <div>

                        <p class="font-extrabold text-sm">

                            {{ $review->name ?: 'Anonim' }}

                        </p>

                        <p class="text-[11px] opacity-60 mt-1">

                            {{ $review->created_at?->diffForHumans() }}

                        </p>

                    </div>

                    @if($review->is_verified_member)

                        <span class="text-[10px] font-bold text-[#183C2F] bg-[#e6eee5] px-3 py-1.5 rounded-full">

                            Anggota terverifikasi

                        </span>

                    @endif

                </div>

            </article>

        @empty

            <div data-reveal="up"

                 class="md:col-span-2 xl:col-span-3 bg-white rounded-2xl border border-[#e0e5dc] p-10 text-center">

                <i class="ph ph-chat-circle-dots text-4xl text-[#183C2F]"></i>

                <p class="font-bold text-lg mt-3">

                    Belum ada ulasan warga

                </p>

                <p class="text-sm text-gray-500 mt-2">

                    Jadilah orang pertama yang berbagi pengalaman.

                </p>

            </div>

        @endforelse

    </div>

    <!-- FORM ULASAN -->

    <div data-reveal="up"

         class="grid lg:grid-cols-[.85fr_1.15fr] gap-8 lg:gap-16 items-start">

        <!-- TEKS KIRI -->

        <div>

            <p class="text-xs uppercase tracking-[.2em] font-bold text-[#416051] mb-3">

                Berikan ulasan

            </p>

            <h3 class="font-display text-5xl sm:text-6xl leading-none text-[#18271f]">

                PENDAPATMU<br>BERARTI.

            </h3>

            <p class="text-sm text-gray-600 leading-7 mt-5 max-w-sm">

                Ceritakan pengalamanmu, beri penilaian, atau tulis masukan

                untuk pengurus. Ulasan akan tampil setelah berhasil dikirim.

            </p>

        </div>

        <!-- FORM KANAN -->

        <form id="form-ulasan"

              action="{{ route('reviews.store') }}"

              method="POST"

              class="landing-form rounded-[1.5rem] border border-[#DEE5DB] bg-white p-6 sm:p-9 space-y-6">

            @csrf

            <!-- RATING -->

            <div>

                <label class="mb-3 block text-sm font-bold text-[#183C2F]">

                    Penilaian kamu <span class="text-red-600">*</span>

                </label>

                <div class="flex flex-row-reverse justify-end gap-2 rating-picker"

                     role="radiogroup"

                     aria-label="Penilaian bintang">

                    @for($rating = 5; $rating >= 1; $rating--)

                        <input

                            class="sr-only"

                            type="radio"

                            id="rating-{{ $rating }}"

                            name="rating"

                            value="{{ $rating }}"

                            {{ (int) old('rating', 5) === $rating ? 'checked' : '' }}

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

                    class="inline-flex w-full items-center justify-center gap-3 rounded-xl bg-[#183C2F] px-7 py-4 text-sm font-bold text-white hover:bg-[#245541] sm:w-auto">

                <i class="ph ph-paper-plane-tilt text-lg"></i>

                Kirim Ulasan

            </button>

        </form>

    </div>

</section>

<!-- CSS RATING INTERAKTIF -->

<style>

    .rating-picker label {

        color: #d1d5db;

        transition: color .2s ease, transform .2s ease;

    }

    .rating-picker input:checked ~ label,

    .rating-picker label:hover,

    .rating-picker label:hover ~ label {

        color: #b77b18;

    }

    .rating-picker input:focus-visible + label {

        outline: 2px solid #183C2F;

        outline-offset: 4px;

        border-radius: 4px;

    }

    #form-ulasan {

        scroll-margin-top: 120px;

    }

</style>

    <!-- FAQ -->
    <section id="faq" class="max-w-5xl mx-auto px-4 sm:px-6 py-16 sm:py-24 scroll-mt-28">
        <div data-reveal class="text-center mb-12">
            <p class="text-[11px] font-bold tracking-[.22em] uppercase text-[#6d8274] mb-3">Pusat informasi</p>
            <h2 class="text-4xl sm:text-6xl font-semibold tracking-[-.06em] text-[#183C2F]">Pertanyaan umum.</h2>
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

              <a class="hover:text-white" href="{{ route('page.profil') }}">Profil Organisasi</a>

              <a class="hover:text-white" href="{{ route('struktur.organisasi') }}">Struktur Banom</a>

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


</body>

</html>
