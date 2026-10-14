<!DOCTYPE html>

<html lang="id" class="scroll-smooth">

<head>

    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Ranting NU Lesmana - Portal Resmi Warga</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <script src="https://cdn.tailwindcss.com"></script>

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

        /* Bentuk blob hero */

        .blob   { border-radius: 62% 38% 54% 46% / 52% 46% 54% 48%; }

        .blob-2 { border-radius: 40% 60% 45% 55% / 60% 42% 58% 40%; }

        .dots   { background-image: radial-gradient(#14532d 1.6px, transparent 1.6px); background-size: 14px 14px; }

        /* Struktur piramid */

        .org-row { position: relative; display: grid; grid-template-columns: minmax(0,1fr); gap: 1rem; max-width: 22rem; margin: 1.5rem auto 0; padding-top: 1.5rem; }

        .org-row.first { margin-top: 0; padding-top: 0; }

        .org-row:not(.first)::after { content: ''; position: absolute; top: -1.5rem; left: 50%; width: 2px; height: 1.5rem; margin-left: -1px; background: rgba(20,83,45,.35); }

        .org-card { position: relative; }

        .org-row:not(.first) .org-card::before { content: ''; position: absolute; left: 50%; top: -1rem; width: 2px; height: 1rem; margin-left: -1px; background: rgba(20,83,45,.35); }

        .org-row:not(.first) .org-card:first-child::before { top: -1.5rem; height: 1.5rem; }

        @media (min-width: 768px) {

            .org-row { grid-template-columns: repeat(var(--n), minmax(0,1fr)); max-width: calc(var(--n) * 19rem); }

            .org-row:not(.first) .org-card::before,

            .org-row:not(.first) .org-card:first-child::before { top: -1.5rem; height: 1.5rem; }

            .org-row.multi::before { content: ''; position: absolute; top: 0; height: 2px; background: rgba(20,83,45,.35);

                left: calc((100% - (var(--n) - 1) * 1rem) / var(--n) / 2);

                right: calc((100% - (var(--n) - 1) * 1rem) / var(--n) / 2); }

        }

    </style>

</head>

<body class="bg-[#f6f7f3] text-gray-900 min-h-screen relative overflow-x-hidden selection:bg-[#203d2e] selection:text-white">

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

                    <a href="{{ route('kia.info') }}" class="flex items-center justify-center gap-2 text-xs sm:text-sm font-black px-5 sm:px-7 py-3.5 sm:py-4 rounded-lg transition shadow-sm text-center bg-[#203d2e] text-white hover:bg-[#2f533c]">

                        <i class="ph ph-identification-card text-base sm:text-lg"></i> Lihat KIA

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

            <!-- VISUAL KANAN -->

            <div class="w-full lg:w-1/2">

                <div class="grid grid-cols-8 gap-3 sm:gap-4 w-full max-w-[34rem] mx-auto lg:mr-0">

                    <div class="col-span-5 h-56 sm:h-[17rem] rounded-2xl sm:rounded-2xl overflow-hidden bg-white shadow-sm flex items-center justify-center p-8 sm:p-12">

                        <img src="https://www.freepnglogos.com/uploads/logo-nu-png/free-transparent-logo-nu-3.png" alt="Logo NU" class="w-full h-full object-contain">

                    </div>

                    <div class="col-span-3 h-56 sm:h-[17rem] rounded-2xl bg-white shadow-sm flex flex-col items-center justify-center text-center px-3 py-5 sm:px-5">

                        <div class="w-9 h-9 sm:w-12 sm:h-12 rounded-full bg-[#203d2e] text-[#dce8d8] flex items-center justify-center text-lg sm:text-2xl mb-2 sm:mb-3 shrink-0">

                            <i class="ph ph-calendar-check"></i>

                        </div>

                        <p class="text-[9px] sm:text-[10px] font-black text-[#2f533c] uppercase tracking-wider">Agenda Terdekat</p>

                        <p class="text-[11px] sm:text-base font-bold leading-snug text-gray-900 mt-1 break-words">Lailatul Ijtima' & Doa Bersama</p>

                        <p class="text-[9px] sm:text-xs italic text-gray-500 mt-1 sm:mt-2 break-words">Setiap Malam Jumat Kliwon di Masjid Jami'</p>

                    </div>

                    <div class="col-span-3 h-56 sm:h-[17rem] rounded-2xl bg-[#203d2e] text-white shadow-sm flex flex-col items-center justify-between text-center px-3 py-5 sm:py-8">

                        <div class="w-7 h-7 sm:w-10 sm:h-10 rounded-full bg-white text-[#203d2e] flex items-center justify-center text-base sm:text-xl">

                            <i class="ph ph-users-three"></i>

                        </div>

                        <div>

                            <p class="font-display text-5xl sm:text-6xl leading-none">{{ ($ipnuCount ?? 0) + ($ippnuCount ?? 0) + ($ansorCount ?? 0) + ($fatayatCount ?? 0) }}</p>

                            <p class="text-[10px] sm:text-xs italic text-[#d5e2d5] mt-1">Total Kader Terverifikasi</p>

                        </div>

                        <div class="w-10 h-10 sm:w-14 sm:h-14 rounded-full bg-[#d6e2d6] text-[#203d2e] flex items-center justify-center font-black text-xs sm:text-base ring-4 ring-white/20">NU</div>

                    </div>

                    <div class="relative col-span-5 h-56 sm:h-[17rem] rounded-2xl sm:rounded-2xl overflow-hidden bg-[#14271e] shadow-sm">

                        <img src="https://tse4.mm.bing.net/th/id/OIP.IH5IAS6MFALaYyTOuSISagHaE2?r=0&rs=1&pid=ImgDetMain&o=7&rm=3" alt="Kaderisasi Banser" class="w-full h-full object-cover">

                        <div class="absolute inset-0 bg-gradient-to-t from-green-950/60 via-transparent to-transparent"></div>

                        <span class="absolute bottom-3 left-3 sm:bottom-4 sm:left-4 bg-white/95 text-[#203d2e] text-[10px] sm:text-xs font-black px-3 py-1.5 rounded-full flex items-center gap-1.5">

                            <i class="ph ph-star-fill"></i> 5 Banom Aktif

                        </span>

                    </div>

                </div>

            </div>

        </div>

    </main>

    <!-- ================= STRUKTUR ORGANISASI (PIRAMID) ================= -->

    <section id="struktur-banom" class="max-w-7xl mx-auto px-4 sm:px-6 py-8 sm:py-12 scroll-mt-28">

        <div class="bg-white rounded-xl sm:rounded-2xl p-6 sm:p-10 lg:p-12 shadow-sm border border-gray-100">

            <div class="mb-6 sm:mb-8 text-center max-w-xl mx-auto">

                <h2 class="font-display text-4xl sm:text-6xl text-gray-900">STRUKTUR ORGANISASI BANOM</h2>

                <p class="text-xs sm:text-sm text-gray-500 font-semibold mt-1.5">Susunan kepengurusan Badan Otonom NU Lesmana masa 2026.</p>

            </div>

            <div class="flex items-center justify-start lg:justify-center gap-2 sm:gap-3 overflow-x-auto pb-4 mb-6 sm:mb-8 no-scrollbar">

                <button onclick="switchTab('ipnu')" id="tab-ipnu" class="tab-btn bg-[#203d2e] text-white text-[11px] sm:text-xs font-black px-4 sm:px-6 py-2.5 sm:py-3 rounded-full transition shrink-0 font-linktree">IPNU (Putra)</button>

                <button onclick="switchTab('ippnu')" id="tab-ippnu" class="tab-btn bg-gray-100 hover:bg-gray-200 text-gray-700 text-[11px] sm:text-xs font-black px-4 sm:px-6 py-2.5 sm:py-3 rounded-full transition shrink-0 font-linktree">IPPNU (Putri)</button>

                <button onclick="switchTab('ansor')" id="tab-ansor" class="tab-btn bg-gray-100 hover:bg-gray-200 text-gray-700 text-[11px] sm:text-xs font-black px-4 sm:px-6 py-2.5 sm:py-3 rounded-full transition shrink-0 font-linktree">GP Ansor / Banser</button>

                <button onclick="switchTab('fatayat')" id="tab-fatayat" class="tab-btn bg-gray-100 hover:bg-gray-200 text-gray-700 text-[11px] sm:text-xs font-black px-4 sm:px-6 py-2.5 sm:py-3 rounded-full transition shrink-0 font-linktree">Fatayat NU</button>

                <button onclick="switchTab('muslimat')" id="tab-muslimat" class="tab-btn bg-gray-100 hover:bg-gray-200 text-gray-700 text-[11px] sm:text-xs font-black px-4 sm:px-6 py-2.5 sm:py-3 rounded-full transition shrink-0 font-linktree">Muslimat NU</button>

            </div>

            <div id="tab-content" class="pb-2"></div>

        </div>

    </section>

    <!-- ================= BERITA ================= -->

    <section id="berita" class="max-w-7xl mx-auto px-4 sm:px-6 py-8 sm:py-12 scroll-mt-28">

        <div class="bg-white rounded-xl sm:rounded-2xl p-6 sm:p-10 lg:p-12 shadow-sm border border-gray-100">

            <div class="flex flex-col sm:flex-row sm:items-end sm:justify-between gap-4 mb-8">

                <div>

                    <span class="bg-[#203d2e] text-[#dce8d8] text-[10px] font-black px-3 py-1.5 rounded-full uppercase tracking-wider">Informasi Terbaru</span>

                    <h2 class="font-display text-4xl sm:text-6xl text-gray-900 mt-3">BERITA & AGENDA</h2>

                    <p class="text-xs sm:text-sm text-gray-600 font-semibold mt-1 max-w-lg">

                        Seputar liputan majelis, pengajian rutin, dan kegiatan sosial warga Ranting NU Lesmana.

                    </p>

                </div>

                <a href="{{ url('/news') }}" class="inline-flex items-center gap-2 text-xs sm:text-sm font-black text-gray-900 hover:text-[#203d2e] transition whitespace-nowrap">

                    Lihat Semua Berita <i class="ph ph-arrow-up-right text-lg"></i>

                </a>

            </div>

            @php

                $newsItems = collect($publishedNews ?? [])->take(3);

                $mainNews = $newsItems->first();

                $sideNews = $newsItems->skip(1);

            @endphp

            @if($mainNews)

                <div class="grid grid-cols-1 lg:grid-cols-5 gap-6 items-start">

                    <div class="lg:col-span-3 group p-3 rounded-2xl border border-gray-200 bg-gradient-to-br from-white to-white shadow-sm hover:shadow-md transition duration-300">

                        <a href="{{ url('/news/' . $mainNews->id) }}" class="block">

                            <div class="relative h-56 sm:h-80 lg:h-[390px] overflow-hidden rounded-xl bg-[#14271e]">

                                @if($mainNews->image)

                                    <img src="{{ \Illuminate\Support\Facades\Storage::url($mainNews->image) }}" alt="{{ $mainNews->title }}" class="w-full h-full object-cover group-hover:scale-105 transition duration-700">

                                @else

                                    <img src="https://images.unsplash.com/photo-1542601906990-b4d3fb778b09?auto=format&fit=crop&w=1200&q=80" alt="Ilustrasi berita" class="w-full h-full object-cover">

                                @endif

                                <div class="absolute inset-0 bg-gradient-to-t from-black/90 via-black/30 to-transparent"></div>

                                <div class="absolute top-4 left-4">

                                    <span class="bg-[#d6e2d6] text-gray-900 text-[10px] sm:text-xs font-black px-3 py-2 rounded-lg uppercase tracking-wider shadow-lg">Berita Utama</span>

                                </div>

                                <div class="absolute bottom-0 left-0 right-0 p-5 sm:p-7">

                                    <div class="flex items-center gap-2 text-white/90 text-[10px] sm:text-xs font-bold mb-2">

                                        <i class="ph ph-calendar-blank text-base"></i>

                                        {{ $mainNews->event_date

                                            ? \Carbon\Carbon::parse($mainNews->event_date)->translatedFormat('d F Y')

                                            : ($mainNews->created_at ? $mainNews->created_at->translatedFormat('d F Y') : 'Tanggal tidak tersedia') }}

                                    </div>

                                    <h3 class="text-xl sm:text-3xl font-black text-white leading-tight break-words drop-shadow-lg group-hover:text-[#e5eee2] transition">

                                        {{ $mainNews->title }}

                                    </h3>

                                </div>

                            </div>

                        </a>

                        <div class="pt-4 px-1">

                            <p class="text-xs sm:text-sm text-gray-800 font-medium leading-relaxed whitespace-pre-line break-words">{{ $mainNews->content ?? 'Tidak ada deskripsi berita.' }}</p>

                            <div class="flex items-center justify-between mt-4 pt-4 border-t border-[#203d2e]/20">

                                <span class="text-[10px] sm:text-xs text-gray-700 font-semibold">

                                    <i class="ph ph-clock mr-1"></i>{{ $mainNews->created_at ? $mainNews->created_at->diffForHumans() : 'Baru saja' }}

                                </span>

                                <a href="{{ url('/news/' . $mainNews->id) }}" class="text-xs font-black text-gray-900 hover:text-[#203d2e] transition">

                                    Baca Selengkapnya <i class="ph ph-arrow-right ml-1"></i>

                                </a>

                            </div>

                        </div>

                    </div>

                    <div class="lg:col-span-2 flex flex-col gap-5">

                        @forelse($sideNews as $news)

                            <article class="group flex flex-col sm:flex-row gap-4 p-3 rounded-2xl border border-gray-200 bg-gradient-to-br from-white to-white shadow-sm hover:shadow-md transition duration-300">

                                <a href="{{ url('/news/' . $news->id) }}" class="w-full sm:w-36 lg:w-40 h-44 sm:h-28 lg:h-32 shrink-0 overflow-hidden rounded-xl bg-[#14271e]">

                                    @if($news->image)

                                        <img src="{{ \Illuminate\Support\Facades\Storage::url($news->image) }}" alt="{{ $news->title }}" class="w-full h-full object-cover group-hover:scale-105 transition duration-500">

                                    @else

                                        <img src="https://images.unsplash.com/photo-1542601906990-b4d3fb778b09?auto=format&fit=crop&w=800&q=80" alt="Ilustrasi berita" class="w-full h-full object-cover">

                                    @endif

                                </a>

                                <div class="flex flex-col justify-between flex-1 min-w-0">

                                    <div>

                                        <span class="text-[9px] sm:text-[10px] font-black text-[#2f533c] uppercase tracking-wider">Berita Terbaru</span>

                                        <a href="{{ url('/news/' . $news->id) }}">

                                            <h3 class="text-sm sm:text-base font-extrabold text-gray-900 leading-snug mt-1 break-words group-hover:text-[#203d2e] transition">{{ $news->title }}</h3>

                                        </a>

                                        <p class="text-[11px] sm:text-xs text-gray-700 font-medium mt-2 leading-relaxed whitespace-pre-line break-words">{{ $news->content ?? 'Tidak ada deskripsi berita.' }}</p>

                                    </div>

                                    <div class="flex items-center justify-between mt-3">

                                        <span class="text-[10px] text-gray-700 font-semibold">

                                            <i class="ph ph-calendar-blank mr-1"></i>{{ $news->created_at ? $news->created_at->translatedFormat('d M Y') : 'Baru saja' }}

                                        </span>

                                        <a href="{{ url('/news/' . $news->id) }}" class="text-[10px] font-black text-gray-900 hover:text-[#203d2e] transition whitespace-nowrap">Baca →</a>

                                    </div>

                                </div>

                            </article>

                        @empty

                            <div class="flex items-center justify-center text-center py-8">

                                <p class="text-xs text-gray-600 font-semibold">Belum ada berita lainnya.</p>

                            </div>

                        @endforelse

                    </div>

                </div>

            @else

                <div class="py-16 text-center">

                    <i class="ph ph-newspaper text-6xl text-[#203d2e]"></i>

                    <h3 class="text-lg font-black text-gray-900 mt-3">Belum Ada Berita</h3>

                    <p class="text-xs text-gray-600 font-medium mt-2">Berita terbaru akan ditampilkan di sini.</p>

                </div>

            @endif

        </div>

    </section>

    <!-- ================= STATISTIK ================= -->

    <section id="statistik" class="max-w-7xl mx-auto px-4 sm:px-6 py-6 sm:py-8 scroll-mt-28">

        <div class="bg-gray-900 text-white rounded-xl sm:rounded-2xl p-6 sm:p-10 lg:p-12 shadow-sm">

            <div class="text-center max-w-xl mx-auto mb-8 sm:mb-10">

                <h2 class="font-display text-4xl sm:text-5xl">STATISTIK ANGGOTA BANOM</h2>

                <p class="text-xs text-gray-400 mt-1">Jumlah kader & anggota resmi yang terverifikasi di Ranting Lesmana.</p>

            </div>

            <div class="grid grid-cols-2 md:grid-cols-4 gap-4 sm:gap-6 text-center">

                <div class="bg-white/10 backdrop-blur-md rounded-2xl p-4 sm:p-6 border border-white/10">

                    <h4 class="text-3xl sm:text-5xl font-display text-[#dce8d8]">{{ $ipnuCount ?? 0 }}</h4>

                    <p class="text-[10px] sm:text-xs font-bold text-gray-300 uppercase mt-1">Kader IPNU</p>

                </div>

                <div class="bg-white/10 backdrop-blur-md rounded-2xl p-4 sm:p-6 border border-white/10">

                    <h4 class="text-3xl sm:text-5xl font-display text-[#dce8d8]">{{ $ippnuCount ?? 0 }}</h4>

                    <p class="text-[10px] sm:text-xs font-bold text-gray-300 uppercase mt-1">Kader IPPNU</p>

                </div>

                <div class="bg-white/10 backdrop-blur-md rounded-2xl p-4 sm:p-6 border border-white/10">

                    <h4 class="text-3xl sm:text-5xl font-display text-[#dce8d8]">{{ $ansorCount ?? 0 }}</h4>

                    <p class="text-[10px] sm:text-xs font-bold text-gray-300 uppercase mt-1">GP Ansor / Banser</p>

                </div>

                <div class="bg-white/10 backdrop-blur-md rounded-2xl p-4 sm:p-6 border border-white/10">

                    <h4 class="text-3xl sm:text-5xl font-display text-[#dce8d8]">{{ $fatayatCount ?? 0 }}</h4>

                    <p class="text-[10px] sm:text-xs font-bold text-gray-300 uppercase mt-1">Fatayat NU</p>

                </div>

            </div>

        </div>

    </section>

    <!-- KOTAK SARAN: pendaftaran akun dipusatkan di /daftar-anggota -->
    <section id="saran" class="max-w-7xl mx-auto px-4 sm:px-6 py-12 sm:py-16 scroll-mt-28">
        <div class="grid lg:grid-cols-[.8fr_1.2fr] gap-8 lg:gap-16 items-start border-t border-[#d8d9d2] pt-10">
            <div>
                <p class="text-xs uppercase tracking-[.2em] font-bold text-[#416051] mb-3">Ruang aspirasi</p>
                <h2 class="font-display text-5xl sm:text-6xl text-[#18271f] leading-none">SUARA WARGA.</h2>
                <p class="text-sm text-gray-600 leading-relaxed mt-5 max-w-sm">Punya masukan atau ide untuk kegiatan Ranting NU Lesmana? Kirim melalui formulir ini.</p>
                <a href="{{ route('member.signup') }}" class="inline-flex mt-6 text-sm font-bold text-[#173d30] underline underline-offset-4">Ingin bergabung menjadi anggota? Daftar di sini →</a>
            </div>
            <form action="{{ route('feedback.send') }}" method="POST" class="bg-white border border-[#e2e3dc] rounded-2xl p-6 sm:p-8 space-y-4">
                @csrf
                <div class="grid sm:grid-cols-2 gap-4">
                    <div>
                        <label for="feedback-name" class="block text-xs font-bold mb-2">Nama lengkap</label>
                        <input id="feedback-name" type="text" name="name" value="{{ old('name') }}" required maxlength="150" placeholder="Nama Anda" class="w-full border border-gray-300 rounded-lg px-4 py-3 text-sm focus:outline-none focus:border-[#173d30]">
                    </div>
                    <div>
                        <label for="feedback-email" class="block text-xs font-bold mb-2">Email</label>
                        <input id="feedback-email" type="email" name="email" value="{{ old('email') }}" required maxlength="255" placeholder="nama@email.com" class="w-full border border-gray-300 rounded-lg px-4 py-3 text-sm focus:outline-none focus:border-[#173d30]">
                    </div>
                </div>
                <div>
                    <label for="feedback-message" class="block text-xs font-bold mb-2">Pesan atau saran</label>
                    <textarea id="feedback-message" name="message" rows="4" required maxlength="3000" placeholder="Tuliskan masukan Anda..." class="w-full border border-gray-300 rounded-lg px-4 py-3 text-sm focus:outline-none focus:border-[#173d30]">{{ old('message') }}</textarea>
                </div>
                <button type="submit" class="inline-flex items-center justify-center gap-2 bg-[#173d30] hover:bg-[#102b21] text-white text-sm font-bold px-7 py-3.5 rounded-lg transition">
                    <i class="ph ph-paper-plane-tilt"></i> Kirim aspirasi
                </button>
            </form>
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
              <a class="hover:text-white" href="{{ route('page.profil') }}">Profil Organisasi</a>
              <a class="hover:text-white" href="#struktur-banom">Struktur Banom</a>
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
              <a class="hover:text-white" href="{{ route('kia.info') }}">Informasi KIA</a>
              <a class="hover:text-white" href="#saran">Kotak Aspirasi</a>
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
        $whatsappChannelUrl = ''; // https://whatsapp.com/channel/0029VbDQNYVGU3BES9BBQ03W
    @endphp
    @if($whatsappChannelUrl)
        <a href="{{ $whatsappChannelUrl }}" target="_blank" rel="noopener noreferrer"
           aria-label="Buka Saluran WhatsApp NU Lesmana" title="Ikuti Saluran WhatsApp NU Lesmana"
           class="fixed bottom-5 right-5 sm:bottom-7 sm:right-7 z-50 inline-flex items-center gap-2 bg-[#173d30] text-white px-4 py-3 rounded-full border border-white/20 shadow-lg hover:bg-[#102b21] transition">
            <i class="ph ph-whatsapp-logo text-2xl" aria-hidden="true"></i>
            <span class="hidden sm:inline text-xs font-bold">Saluran NU Lesmana</span>
        </a>
    @endif

    <script>

        // SLIDER HERO + KARTU AGENDA

        const slideData = [

            { tag: 'Agenda Terdekat', title: "Lailatul Ijtima' & Doa Bersama", sub: "Setiap Malam Jumat Kliwon di Masjid Jami'" },

            { tag: 'Kaderisasi', title: 'Pelatihan Banser & Ansor', sub: 'Siap Menjaga Ulama & NKRI' }

        ];

        const slides = document.querySelectorAll('.slide-item');

        let currentSlide = 0;

        // DATA DUMMY STRUKTUR (level 1 = puncak, level 2 = tengah, level 3 = dasar)

        const structures = {

            ipnu: [

                { level: 1, role: 'Ketua Umum', name: 'Rekan Ahmad Fauzi', desc: 'Koordinator Pelajar Putra' },

                { level: 2, role: 'Sekretaris', name: 'Rekan M. Rizky', desc: 'Administrasi & Keanggotaan' },

                { level: 2, role: 'Bendahara', name: 'Rekan David Setiawan', desc: 'Keuangan & Infaq Kader' },

                { level: 3, role: 'Divisi Kaderisasi', name: 'Rekan Ali Mustofa', desc: 'Koordinator Divisi' },

                { level: 3, role: 'Divisi Dakwah', name: 'Rekan Zaki Maulana', desc: 'Koordinator Divisi' },

                { level: 3, role: 'Divisi Humas', name: 'Rekan Fajar Nugroho', desc: 'Koordinator Divisi' }

            ],

            ippnu: [

                { level: 1, role: 'Ketua Umum', name: 'Rekanita Siti Nurhaliza', desc: 'Koordinator Pelajar Putri' },

                { level: 2, role: 'Sekretaris', name: 'Rekanita Nur Aini', desc: 'Administrasi & Persuratan' },

                { level: 2, role: 'Bendahara', name: 'Rekanita Anisa Rahma', desc: 'Keuangan & Kas Pelajar' },

                { level: 3, role: 'Divisi Kaderisasi', name: 'Rekanita Laila Safitri', desc: 'Koordinator Divisi' },

                { level: 3, role: 'Divisi Dakwah', name: 'Rekanita Putri Ayu', desc: 'Koordinator Divisi' },

                { level: 3, role: 'Divisi Humas', name: 'Rekanita Dina Marlina', desc: 'Koordinator Divisi' }

            ],

            ansor: [

                { level: 1, role: 'Ketua Ranting', name: 'Sahabat Budi Santoso', desc: 'Pimpinan GP Ansor' },

                { level: 2, role: 'Kasatkorkel Banser', name: 'Sahabat Hasan Basri', desc: 'Komandan Banser Lesmana' },

                { level: 2, role: 'Sekretaris', name: 'Sahabat Tri Wibowo', desc: 'Administrasi & Organisasi' },

                { level: 3, role: 'Divisi Kaderisasi', name: 'Sahabat Yusuf Hidayat', desc: 'Koordinator Divisi' },

                { level: 3, role: 'Divisi Dakwah', name: 'Sahabat Imam Syafii', desc: 'Koordinator Divisi' },

                { level: 3, role: 'Divisi Humas', name: 'Sahabat Rudi Hartono', desc: 'Koordinator Divisi' }

            ],

            fatayat: [

                { level: 1, role: 'Ketua Ranting', name: 'Sahabatin Hj. Maria Ulfah', desc: 'Pimpinan Fatayat NU' },

                { level: 2, role: 'Sekretaris', name: 'Sahabatin Dewi Lestari', desc: 'Sekretaris Pengurus' },

                { level: 2, role: 'Bendahara', name: 'Sahabatin Fitriani', desc: 'Pengelola Kas Fatayat' },

                { level: 3, role: 'Divisi Kaderisasi', name: 'Sahabatin Nur Fadilah', desc: 'Koordinator Divisi' },

                { level: 3, role: 'Divisi Dakwah', name: 'Sahabatin Rina Wati', desc: 'Koordinator Divisi' },

                { level: 3, role: 'Divisi Humas', name: 'Sahabatin Salma Aulia', desc: 'Koordinator Divisi' }

            ],

            muslimat: [

                { level: 1, role: 'Ketua Ranting', name: 'Ibu Nyai Hj. Aminah', desc: 'Penasehat & Ketua Muslimat' },

                { level: 2, role: 'Sekretaris', name: 'Ibu Hj. Khadijah', desc: 'Sekretaris Ranting' },

                { level: 2, role: 'Bendahara', name: 'Ibu Hj. Siti Zulaikha', desc: 'Bendahara Umum' },

                { level: 3, role: 'Divisi Pengajian', name: 'Ibu Hj. Fatimah', desc: 'Koordinator Divisi' },

                { level: 3, role: 'Divisi Sosial', name: 'Ibu Hj. Zainab', desc: 'Koordinator Divisi' },

                { level: 3, role: 'Divisi Humas', name: 'Ibu Hj. Rahmah', desc: 'Koordinator Divisi' }

            ]

        };

        const levelStyle = {

            1: { box: 'bg-[#203d2e] border-[#203d2e]', icon: 'bg-[#d6e2d6] text-[#203d2e]', pill: 'bg-[#d6e2d6] text-gray-900', name: 'text-white', desc: 'text-[#d5e2d5]' },

            2: { box: 'bg-[#f1f5ef] border-[#d7e2d5]',   icon: 'bg-[#203d2e] text-[#dce8d8]', pill: 'bg-[#203d2e] text-[#e5eee2]', name: 'text-gray-900', desc: 'text-gray-600' },

            3: { box: 'bg-gray-50 border-gray-200',    icon: 'bg-[#203d2e] text-[#dce8d8]', pill: 'bg-[#e9f0e8] text-[#2f533c]', name: 'text-gray-900', desc: 'text-gray-500' }

        };

        function orgCard(item) {

            const s = levelStyle[item.level] || levelStyle[3];

            return `

                <div class="org-card ${s.box} border rounded-2xl p-4 sm:p-5 text-center shadow-sm flex flex-col items-center gap-2">

                    <div class="w-11 h-11 rounded-xl ${s.icon} flex items-center justify-center text-2xl"><i class="ph ph-user-circle"></i></div>

                    <span class="text-[9px] sm:text-[10px] font-black ${s.pill} px-2.5 py-0.5 rounded-full uppercase tracking-wider">${item.role}</span>

                    <h4 class="text-sm sm:text-base font-extrabold ${s.name} leading-snug break-words">${item.name}</h4>

                    <p class="text-[11px] sm:text-xs font-semibold ${s.desc}">${item.desc}</p>

                </div>`;

        }

        function switchTab(banomKey) {

            document.querySelectorAll('.tab-btn').forEach(btn => {

                btn.classList.remove('bg-[#203d2e]', 'text-white');

                btn.classList.add('bg-gray-100', 'text-gray-700');

            });

            const activeBtn = document.getElementById('tab-' + banomKey);

            activeBtn.classList.remove('bg-gray-100', 'text-gray-700');

            activeBtn.classList.add('bg-[#203d2e]', 'text-white');

            const data = structures[banomKey] || [];

            const levels = {};

            data.forEach(m => { (levels[m.level] = levels[m.level] || []).push(m); });

            document.getElementById('tab-content').innerHTML = Object.keys(levels)

                .sort((a, b) => a - b)

                .map((lv, i) => {

                    const members = levels[lv];

                    return `<div class="org-row ${i === 0 ? 'first' : ''} ${members.length > 1 ? 'multi' : ''}" style="--n:${members.length}">

                                ${members.map(orgCard).join('')}

                            </div>`;

                }).join('');

        }

        switchTab('ipnu');

    </script>
 
        <x-whatsapp-channel
            url="https://whatsapp.com/channel/0029VbDQNYVGU3BES9BBQ03W"
        />

</body>

</html>
