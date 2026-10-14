<!DOCTYPE html>
<html lang="id" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ranting NU Lesmana - Portal Resmi Warga</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Bebas+Neue&family=DM+Sans:ital,opsz,wght@0,9..40,100..1000;1,9..40,100..1000&display=swap" rel="stylesheet">
    <script src="https://unpkg.com/@phosphor-icons/web"></script>
    <style>
        body { font-family: 'DM Sans', sans-serif; }
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
<body class="bg-[#d5f028] text-gray-900 min-h-screen relative overflow-x-hidden selection:bg-green-900 selection:text-white">

   <!-- NAVBAR -->
    <nav class="fixed top-4 sm:top-6 left-1/2 -translate-x-1/2 w-[92%] max-w-6xl bg-stone-950/90 backdrop-blur-md text-white rounded-full px-4 sm:px-6 py-2.5 sm:py-3 flex justify-between items-center z-50 shadow-2xl border border-white/10 transition-all duration-300">
        
        <!-- KIRI: Tombol Profil (jika login) ATAU Tombol Login/Daftar (jika belum login) -->
        <div class="flex items-center gap-3">
            @auth
                <!-- Dropdown Profil Member / Admin -->
                <div class="relative" x-data="{ open: false }">
                    <button @click="open = !open" class="flex items-center gap-2 bg-stone-9kt border border-white/15 hover:border-lime-400 text-stone-200 px-3 py-1.5 rounded-full text-xs font-bold transition">
                        <div class="w-7 h-7 rounded-full bg-lime-400 text-stone-950 flex items-center justify-center font-black">
                            {{ substr(auth()->user()->name, 0, 1) }}
                        </div>
                        <span class="hidden sm:inline-block max-w-[100px] truncate">{{ auth()->user()->name }}</span>
                        <i class="ph ph-caret-down text-xs"></i>
                    </button>

                    <!-- Menu Dropdown Profil -->
                    <div x-show="open" @click.outside="open = false" x-transition class="absolute left-0 mt-2 w-52 bg-stone-900 border border-white/10 rounded-2xl shadow-2xl py-2 z-50 text-xs font-semibold">
                        <div class="px-4 py-2 border-b border-white/10 text-stone-400">
                            <p class="text-[10px] uppercase tracking-wider">Masuk sebagai</p>
                            <p class="text-white font-bold truncate">{{ auth()->user()->email }}</p>
                        </div>

                        @if(auth()->user()->role === 'admin')
                            <a href="{{ route('admin.dashboard') }}" class="block px-4 py-2 text-stone-200 hover:bg-stone-800 hover:text-lime-400 transition">Panel Admin</a>
                        @else
                            <a href="{{ route('dashboard') }}" class="block px-4 py-2 text-stone-200 hover:bg-stone-800 hover:text-lime-400 transition">Dashboard Saya</a>
                        @endif

                        <a href="{{ route('profile.edit') }}" class="block px-4 py-2 text-stone-200 hover:bg-stone-800 hover:text-lime-400 transition">Informasi & Pengaturan</a>

                        <div class="border-t border-white/10 my-1"></div>

                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="w-full text-left px-4 py-2 text-red-400 hover:bg-stone-800 transition">Keluar (Logout)</button>
                        </form>
                    </div>
                </div>
            @else
                <div class="flex items-center gap-2">
                    <a href="{{ route('login') }}" class="text-xs font-bold text-stone-300 hover:text-lime-400 px-2 py-1 transition">
                        Login
                    </a>
                    <a href="#daftar" class="bg-lime-400 hover:bg-lime-300 text-stone-950 px-3.5 py-1.5 rounded-full text-[11px] font-black transition shadow-md">
                        Daftar
                    </a>
                </div>
            @endauth
        </div>

        <!-- TENGAH: Menu Navigasi Utama -->
        <div class="hidden md:flex items-center gap-6 font-bold text-stone-300 text-xs">
            <a href="#berita" class="hover:text-white transition">Berita & Agenda</a>
            <a href="#struktur-banom" class="hover:text-white transition">Struktur Organisasi</a>
            <a href="#statistik" class="hover:text-white transition">Statistik Banom</a>
            <a href="#cek-kartu" class="hover:text-white transition">Cek Kartu NIA</a>
            <a href="#saran" class="hover:text-white transition">Kotak Saran</a>
        </div>

        <!-- KANAN: Logo PRNU Lesmana -->
        <div class="flex items-center">
            <a href="#" class="flex items-center gap-2.5 sm:gap-3 pr-1">
                <div class="flex flex-col text-right hidden sm:flex">
                    <span class="font-black text-xs sm:text-sm tracking-tight text-white font-linktree leading-none">
                        PRNU <span class="text-lime-400">Lesmana</span>
                    </span>
                    <span class="text-[8px] sm:text-[9px] font-semibold text-stone-400 uppercase tracking-widest mt-0.5">Portal Resmi Warga</span>
                </div>
                <div class="w-8 h-8 sm:w-10 sm:h-10 bg-white rounded-full flex items-center justify-center text-stone-950 font-black shadow-md shrink-0">
                    <i class="ph ph-globe-hemisphere-west text-lg sm:text-xl"></i>
                </div>
            </a>
            <button onclick="toggleMobileMenu()" class="md:hidden text-white text-2xl p-1.5 focus:outline-none ml-2">
                <i class="ph ph-list" id="menuIcon"></i>
            </button>
        </div>
    </nav>
    
    <!-- MENU MOBILE -->
    <div id="mobileMenu" class="fixed top-20 left-1/2 -translate-x-1/2 w-[92%] bg-stone-950/95 text-white rounded-3xl p-6 shadow-2xl border border-white/10 z-40 hidden md:hidden flex flex-col gap-4 font-bold text-sm backdrop-blur-lg">
        <a href="#berita" onclick="toggleMobileMenu()" class="hover:text-lime-400 transition py-1 border-b border-white/10">Berita & Agenda</a>
        <a href="#struktur-banom" onclick="toggleMobileMenu()" class="hover:text-lime-400 transition py-1 border-b border-white/10">Struktur Organisasi</a>
        <a href="#statistik" onclick="toggleMobileMenu()" class="hover:text-lime-400 transition py-1 border-b border-white/10">Statistik Banom</a>
        <a href="#cek-kartu" onclick="toggleMobileMenu()" class="hover:text-lime-400 transition py-1 border-b border-white/10">Cek Kartu NIA</a>
        <a href="#saran" onclick="toggleMobileMenu()" class="hover:text-lime-400 transition py-1 border-b border-white/10">Kotak Saran</a>
        @auth
            @if(auth()->user()->role === 'admin')
                <a href="{{ route('admin.dashboard') }}" class="text-lime-400 py-1 font-bold">Panel Admin →</a>
            @else
                <a href="{{ route('dashboard') }}" class="text-lime-400 py-1 font-bold">Dashboard Member →</a>
            @endif
        @else
            <a href="{{ route('login') }}" class="text-lime-400 py-1 font-bold">Login →</a>
        @endauth
    </div>

    <!-- NOTIFIKASI -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 pt-24 sm:pt-28">
        @if(session('success'))
            <div class="bg-green-900 text-white px-5 py-3.5 rounded-2xl font-bold shadow-lg flex items-center justify-between mb-4 text-xs sm:text-sm">
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
                <p class="text-sm sm:text-base font-bold text-gray-800 mb-2">PENGURUS RANTING NAHDLATUL ULAMA</p>
                <h1 class="font-display text-6xl sm:text-8xl lg:text-[6.5rem] xl:text-[7.5rem] leading-[0.92] text-gray-900 mb-5 sm:mb-6">
                    PORTAL RESMI <br>
                    <span class="text-green-900">LESMANA.</span>
                </h1>
                <p class="text-sm sm:text-base lg:text-lg font-semibold text-gray-800 mb-6 sm:mb-8 leading-relaxed max-w-lg">
                    Pusat informasi kegiatan majelis, berita agenda keagamaan, serta layanan pendaftaran anggota Badan Otonom Ranting NU dengan verifikasi NIA otomatis.
                </p>
                <div class="flex flex-col sm:flex-row items-center gap-3 sm:gap-4 w-full sm:w-auto">
                    <a href="#berita" class="w-full sm:w-auto bg-gray-900 text-white text-xs sm:text-sm font-black px-6 sm:px-8 py-3.5 sm:py-4 rounded-full hover:bg-green-800 transition transform hover:scale-105 shadow-xl font-linktree text-center">
                        Lihat Berita Kegiatan
                    </a>
                    <a href="#cek-kartu" class="w-full sm:w-auto bg-white border-2 border-gray-900 text-gray-900 text-xs sm:text-sm font-black px-6 sm:px-8 py-3.5 sm:py-4 rounded-full hover:bg-gray-50 transition transform hover:scale-105 shadow-xl font-linktree text-center">
                        Cek Kartu NIA
                    </a>
                </div>
            </div>

            <!-- VISUAL KANAN -->
            <div class="w-full lg:w-1/2">
                <div class="grid grid-cols-8 gap-3 sm:gap-4 w-full max-w-[34rem] mx-auto lg:mr-0">

                    <div class="col-span-5 h-56 sm:h-[17rem] rounded-[2.2rem] sm:rounded-[3rem] overflow-hidden bg-white shadow-xl flex items-center justify-center p-8 sm:p-12">
                        <img src="https://www.freepnglogos.com/uploads/logo-nu-png/free-transparent-logo-nu-3.png" alt="Logo NU" class="w-full h-full object-contain">
                    </div>

                    <div class="col-span-3 h-56 sm:h-[17rem] rounded-full bg-white shadow-xl flex flex-col items-center justify-center text-center px-3 py-5 sm:px-5">
                        <div class="w-9 h-9 sm:w-12 sm:h-12 rounded-full bg-green-900 text-lime-400 flex items-center justify-center text-lg sm:text-2xl mb-2 sm:mb-3 shrink-0">
                            <i class="ph ph-calendar-check"></i>
                        </div>
                        <p class="text-[9px] sm:text-[10px] font-black text-green-800 uppercase tracking-wider">Agenda Terdekat</p>
                        <p class="text-[11px] sm:text-base font-bold leading-snug text-gray-900 mt-1 break-words">Lailatul Ijtima' & Doa Bersama</p>
                        <p class="text-[9px] sm:text-xs italic text-gray-500 mt-1 sm:mt-2 break-words">Setiap Malam Jumat Kliwon di Masjid Jami'</p>
                    </div>

                    <div class="col-span-3 h-56 sm:h-[17rem] rounded-full bg-green-900 text-white shadow-xl flex flex-col items-center justify-between text-center px-3 py-5 sm:py-8">
                        <div class="w-7 h-7 sm:w-10 sm:h-10 rounded-full bg-white text-green-900 flex items-center justify-center text-base sm:text-xl">
                            <i class="ph ph-users-three"></i>
                        </div>
                        <div>
                            <p class="font-display text-5xl sm:text-6xl leading-none">{{ ($ipnuCount ?? 0) + ($ippnuCount ?? 0) + ($ansorCount ?? 0) + ($fatayatCount ?? 0) }}</p>
                            <p class="text-[10px] sm:text-xs italic text-green-200 mt-1">Total Kader Terverifikasi</p>
                        </div>
                        <div class="w-10 h-10 sm:w-14 sm:h-14 rounded-full bg-lime-400 text-green-900 flex items-center justify-center font-black text-xs sm:text-base ring-4 ring-white/20">NU</div>
                    </div>

                    <div class="relative col-span-5 h-56 sm:h-[17rem] rounded-[2.2rem] sm:rounded-[3rem] overflow-hidden bg-green-950 shadow-xl">
                        <img src="https://tse4.mm.bing.net/th/id/OIP.IH5IAS6MFALaYyTOuSISagHaE2?r=0&rs=1&pid=ImgDetMain&o=7&rm=3" alt="Kaderisasi Banser" class="w-full h-full object-cover">
                        <div class="absolute inset-0 bg-gradient-to-t from-green-950/60 via-transparent to-transparent"></div>
                        <span class="absolute bottom-3 left-3 sm:bottom-4 sm:left-4 bg-white/95 text-green-900 text-[10px] sm:text-xs font-black px-3 py-1.5 rounded-full flex items-center gap-1.5">
                            <i class="ph ph-star-fill"></i> 5 Banom Aktif
                        </span>
                    </div>

                </div>
            </div>
        </div>

        <!-- LAYANAN KAMI -->
        <div class="mt-12 sm:mt-16">
            <h2 class="font-display text-4xl sm:text-5xl text-gray-900 mb-5">LAYANAN KAMI</h2>
            <div class="grid grid-cols-1 sm:grid-cols-3 gap-6 sm:gap-8">
                <a href="#berita" class="group block">
                    <div class="w-12 h-12 border-2 border-green-900 text-green-900 rounded-xl flex items-center justify-center text-2xl group-hover:bg-green-900 group-hover:text-lime-400 transition"><i class="ph ph-newspaper"></i></div>
                    <h3 class="font-black text-base mt-3">Berita & Agenda</h3>
                    <p class="text-xs sm:text-sm text-gray-700 font-semibold mt-1">Liputan majelis, pengajian rutin, dan kegiatan sosial warga.</p>
                </a>
                <a href="#struktur-banom" class="group block">
                    <div class="w-12 h-12 border-2 border-green-900 text-green-900 rounded-xl flex items-center justify-center text-2xl group-hover:bg-green-900 group-hover:text-lime-400 transition"><i class="ph ph-tree-structure"></i></div>
                    <h3 class="font-black text-base mt-3">Struktur Organisasi</h3>
                    <p class="text-xs sm:text-sm text-gray-700 font-semibold mt-1">Susunan pengurus lima Badan Otonom masa khidmah 2026.</p>
                </a>
                <a href="#daftar" class="group block">
                    <div class="w-12 h-12 border-2 border-green-900 text-green-900 rounded-xl flex items-center justify-center text-2xl group-hover:bg-green-900 group-hover:text-lime-400 transition"><i class="ph ph-user-plus"></i></div>
                    <h3 class="font-black text-base mt-3">Pendaftaran Anggota</h3>
                    <p class="text-xs sm:text-sm text-gray-700 font-semibold mt-1">Daftar online, dapatkan NIA setelah diverifikasi pengurus.</p>
                </a>
            </div>
        </div>

    </main>

    <!-- ================= STRUKTUR ORGANISASI (PIRAMID) ================= -->
    <section id="struktur-banom" class="max-w-7xl mx-auto px-4 sm:px-6 py-8 sm:py-12 scroll-mt-28">
        <div class="bg-white rounded-[2rem] sm:rounded-[2.5rem] p-6 sm:p-10 lg:p-12 shadow-2xl border border-gray-100">
            <div class="mb-6 sm:mb-8 text-center max-w-xl mx-auto">
                <h2 class="font-display text-4xl sm:text-6xl text-gray-900">STRUKTUR ORGANISASI BANOM</h2>
                <p class="text-xs sm:text-sm text-gray-500 font-semibold mt-1.5">Susunan kepengurusan Badan Otonom NU Lesmana masa 2026.</p>
            </div>

            <div class="flex items-center justify-start lg:justify-center gap-2 sm:gap-3 overflow-x-auto pb-4 mb-6 sm:mb-8 no-scrollbar">
                <button onclick="switchTab('ipnu')" id="tab-ipnu" class="tab-btn bg-green-900 text-white text-[11px] sm:text-xs font-black px-4 sm:px-6 py-2.5 sm:py-3 rounded-full transition shrink-0 font-linktree">IPNU (Putra)</button>
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
        <div class="bg-white rounded-[2rem] sm:rounded-[2.5rem] p-6 sm:p-10 lg:p-12 shadow-2xl border border-gray-100">

            <div class="flex flex-col sm:flex-row sm:items-end sm:justify-between gap-4 mb-8">
                <div>
                    <span class="bg-green-900 text-lime-400 text-[10px] font-black px-3 py-1.5 rounded-full uppercase tracking-wider">Informasi Terbaru</span>
                    <h2 class="font-display text-4xl sm:text-6xl text-gray-900 mt-3">BERITA & AGENDA</h2>
                    <p class="text-xs sm:text-sm text-gray-600 font-semibold mt-1 max-w-lg">
                        Seputar liputan majelis, pengajian rutin, dan kegiatan sosial warga Ranting NU Lesmana.
                    </p>
                </div>
                <a href="{{ url('/news') }}" class="inline-flex items-center gap-2 text-xs sm:text-sm font-black text-gray-900 hover:text-green-900 transition whitespace-nowrap">
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

                    <div class="lg:col-span-3 group p-3 rounded-2xl border border-gray-200 bg-gradient-to-br from-lime-100 to-white shadow-sm hover:shadow-lg transition duration-300">
                        <a href="{{ url('/news/' . $mainNews->id) }}" class="block">
                            <div class="relative h-56 sm:h-80 lg:h-[390px] overflow-hidden rounded-xl bg-green-950">
                                @if($mainNews->image)
                                    <img src="{{ \Illuminate\Support\Facades\Storage::url($mainNews->image) }}" alt="{{ $mainNews->title }}" class="w-full h-full object-cover group-hover:scale-105 transition duration-700">
                                @else
                                    <img src="https://images.unsplash.com/photo-1542601906990-b4d3fb778b09?auto=format&fit=crop&w=1200&q=80" alt="Ilustrasi berita" class="w-full h-full object-cover">
                                @endif
                                <div class="absolute inset-0 bg-gradient-to-t from-black/90 via-black/30 to-transparent"></div>
                                <div class="absolute top-4 left-4">
                                    <span class="bg-lime-400 text-gray-900 text-[10px] sm:text-xs font-black px-3 py-2 rounded-lg uppercase tracking-wider shadow-lg">Berita Utama</span>
                                </div>
                                <div class="absolute bottom-0 left-0 right-0 p-5 sm:p-7">
                                    <div class="flex items-center gap-2 text-white/90 text-[10px] sm:text-xs font-bold mb-2">
                                        <i class="ph ph-calendar-blank text-base"></i>
                                        {{ $mainNews->event_date
                                            ? \Carbon\Carbon::parse($mainNews->event_date)->translatedFormat('d F Y')
                                            : ($mainNews->created_at ? $mainNews->created_at->translatedFormat('d F Y') : 'Tanggal tidak tersedia') }}
                                    </div>
                                    <h3 class="text-xl sm:text-3xl font-black text-white leading-tight break-words drop-shadow-lg group-hover:text-lime-300 transition">
                                        {{ $mainNews->title }}
                                    </h3>
                                </div>
                            </div>
                        </a>

                        <div class="pt-4 px-1">
                            <p class="text-xs sm:text-sm text-gray-800 font-medium leading-relaxed whitespace-pre-line break-words">{{ $mainNews->content ?? 'Tidak ada deskripsi berita.' }}</p>
                            <div class="flex items-center justify-between mt-4 pt-4 border-t border-green-900/20">
                                <span class="text-[10px] sm:text-xs text-gray-700 font-semibold">
                                    <i class="ph ph-clock mr-1"></i>{{ $mainNews->created_at ? $mainNews->created_at->diffForHumans() : 'Baru saja' }}
                                </span>
                                <a href="{{ url('/news/' . $mainNews->id) }}" class="text-xs font-black text-gray-900 hover:text-green-900 transition">
                                    Baca Selengkapnya <i class="ph ph-arrow-right ml-1"></i>
                                </a>
                            </div>
                        </div>
                    </div>

                    <div class="lg:col-span-2 flex flex-col gap-5">
                        @forelse($sideNews as $news)
                            <article class="group flex flex-col sm:flex-row gap-4 p-3 rounded-2xl border border-gray-200 bg-gradient-to-br from-lime-100 to-white shadow-sm hover:shadow-lg transition duration-300">
                                <a href="{{ url('/news/' . $news->id) }}" class="w-full sm:w-36 lg:w-40 h-44 sm:h-28 lg:h-32 shrink-0 overflow-hidden rounded-xl bg-green-950">
                                    @if($news->image)
                                        <img src="{{ \Illuminate\Support\Facades\Storage::url($news->image) }}" alt="{{ $news->title }}" class="w-full h-full object-cover group-hover:scale-105 transition duration-500">
                                    @else
                                        <img src="https://images.unsplash.com/photo-1542601906990-b4d3fb778b09?auto=format&fit=crop&w=800&q=80" alt="Ilustrasi berita" class="w-full h-full object-cover">
                                    @endif
                                </a>

                                <div class="flex flex-col justify-between flex-1 min-w-0">
                                    <div>
                                        <span class="text-[9px] sm:text-[10px] font-black text-green-800 uppercase tracking-wider">Berita Terbaru</span>
                                        <a href="{{ url('/news/' . $news->id) }}">
                                            <h3 class="text-sm sm:text-base font-extrabold text-gray-900 leading-snug mt-1 break-words group-hover:text-green-900 transition">{{ $news->title }}</h3>
                                        </a>
                                        <p class="text-[11px] sm:text-xs text-gray-700 font-medium mt-2 leading-relaxed whitespace-pre-line break-words">{{ $news->content ?? 'Tidak ada deskripsi berita.' }}</p>
                                    </div>
                                    <div class="flex items-center justify-between mt-3">
                                        <span class="text-[10px] text-gray-700 font-semibold">
                                            <i class="ph ph-calendar-blank mr-1"></i>{{ $news->created_at ? $news->created_at->translatedFormat('d M Y') : 'Baru saja' }}
                                        </span>
                                        <a href="{{ url('/news/' . $news->id) }}" class="text-[10px] font-black text-gray-900 hover:text-green-900 transition whitespace-nowrap">Baca →</a>
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
                    <i class="ph ph-newspaper text-6xl text-green-900"></i>
                    <h3 class="text-lg font-black text-gray-900 mt-3">Belum Ada Berita</h3>
                    <p class="text-xs text-gray-600 font-medium mt-2">Berita terbaru akan ditampilkan di sini.</p>
                </div>
            @endif

        </div>
    </section>

    <!-- ================= STATISTIK ================= -->
    <section id="statistik" class="max-w-7xl mx-auto px-4 sm:px-6 py-6 sm:py-8 scroll-mt-28">
        <div class="bg-gray-900 text-white rounded-[2rem] sm:rounded-[2.5rem] p-6 sm:p-10 lg:p-12 shadow-2xl">
            <div class="text-center max-w-xl mx-auto mb-8 sm:mb-10">
                <h2 class="font-display text-4xl sm:text-5xl">STATISTIK ANGGOTA BANOM</h2>
                <p class="text-xs text-gray-400 mt-1">Jumlah kader & anggota resmi yang terverifikasi di Ranting Lesmana.</p>
            </div>
            <div class="grid grid-cols-2 md:grid-cols-4 gap-4 sm:gap-6 text-center">
                <div class="bg-white/10 backdrop-blur-md rounded-2xl p-4 sm:p-6 border border-white/10">
                    <h4 class="text-3xl sm:text-5xl font-display text-lime-400">{{ $ipnuCount ?? 0 }}</h4>
                    <p class="text-[10px] sm:text-xs font-bold text-gray-300 uppercase mt-1">Kader IPNU</p>
                </div>
                <div class="bg-white/10 backdrop-blur-md rounded-2xl p-4 sm:p-6 border border-white/10">
                    <h4 class="text-3xl sm:text-5xl font-display text-lime-400">{{ $ippnuCount ?? 0 }}</h4>
                    <p class="text-[10px] sm:text-xs font-bold text-gray-300 uppercase mt-1">Kader IPPNU</p>
                </div>
                <div class="bg-white/10 backdrop-blur-md rounded-2xl p-4 sm:p-6 border border-white/10">
                    <h4 class="text-3xl sm:text-5xl font-display text-lime-400">{{ $ansorCount ?? 0 }}</h4>
                    <p class="text-[10px] sm:text-xs font-bold text-gray-300 uppercase mt-1">GP Ansor / Banser</p>
                </div>
                <div class="bg-white/10 backdrop-blur-md rounded-2xl p-4 sm:p-6 border border-white/10">
                    <h4 class="text-3xl sm:text-5xl font-display text-lime-400">{{ $fatayatCount ?? 0 }}</h4>
                    <p class="text-[10px] sm:text-xs font-bold text-gray-300 uppercase mt-1">Fatayat NU</p>
                </div>
            </div>
        </div>
    </section>

    <!-- ================= CEK / CETAK KARTU BERDASARKAN NIA ================= -->
    <section id="cek-kartu" class="max-w-7xl mx-auto px-4 sm:px-6 py-8 sm:py-12 scroll-mt-28">
        <div class="bg-white rounded-[2rem] sm:rounded-[2.5rem] p-6 sm:p-10 lg:p-12 shadow-2xl border border-gray-100 text-center max-w-3xl mx-auto">
            <span class="bg-green-100 text-green-800 text-[10px] font-black px-3 py-1 rounded-full uppercase tracking-wider mb-2 inline-block">Validasi Anggota</span>
            <h2 class="font-display text-4xl sm:text-5xl text-gray-900 mb-2">CEK KARTU ANGGOTA (NIA)</h2>
            <p class="text-xs sm:text-sm text-gray-600 font-medium mb-6">
                Masukkan Nomor Induk Anggota (NIA) Anda untuk memverifikasi keaktifan data dan mencetak kartu anggota secara mandiri.
            </p>

            <form action="#" method="GET" class="flex flex-col sm:flex-row gap-3 max-w-md mx-auto">
                <input type="text" name="nia" placeholder="Contoh: NLS-202610-0001" required
                    class="flex-1 bg-gray-50 border border-gray-200 rounded-xl px-4 py-3 text-xs sm:text-sm font-mono text-gray-900 focus:outline-none focus:ring-2 focus:ring-green-900">
                <button type="submit" class="px-6 py-3 bg-green-900 text-white font-black text-xs sm:text-sm rounded-xl hover:bg-green-800 transition shadow-md font-linktree whitespace-nowrap">
                    Cek & Cetak
                </button>
            </form>
        </div>
    </section>

    <!-- ================= KOTAK SARAN & PENDAFTARAN ================= -->
    <section id="saran" class="max-w-7xl mx-auto px-4 sm:px-6 py-8 sm:py-12 pb-20 sm:pb-24 scroll-mt-28">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 sm:gap-8">

            <div class="bg-white rounded-[2rem] sm:rounded-[2.5rem] p-6 sm:p-10 shadow-2xl border border-gray-100">
                <div class="mb-6">
                    <span class="bg-green-100 text-green-800 text-[10px] font-black px-3 py-1 rounded-full uppercase tracking-wider mb-2 inline-block">Kritik & Saran</span>
                    <h3 class="font-display text-4xl sm:text-5xl text-gray-900">KOTAK ASPIRASI WARGA</h3>
                    <p class="text-xs text-gray-500 font-medium mt-1">Saran & masukan Anda akan langsung dikirimkan ke email pengurus Ranting NU.</p>
                </div>

                <form action="{{ route('feedback.send') }}" method="POST" class="space-y-3.5 sm:space-y-4">
                    @csrf
                    <div>
                        <label class="block text-xs font-bold text-gray-700 uppercase mb-1">Nama Lengkap</label>
                        <input type="text" name="name" required placeholder="Masukkan nama Anda" class="w-full bg-gray-50 border border-gray-200 rounded-xl px-4 py-2.5 sm:py-3 text-xs sm:text-sm font-semibold outline-none focus:ring-2 focus:ring-green-500">
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-gray-700 uppercase mb-1">Email Anda</label>
                        <input type="email" name="email" required placeholder="alamat@email.com" class="w-full bg-gray-50 border border-gray-200 rounded-xl px-4 py-2.5 sm:py-3 text-xs sm:text-sm font-semibold outline-none focus:ring-2 focus:ring-green-500">
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-gray-700 uppercase mb-1">Pesan / Saran / Aspirasi</label>
                        <textarea name="message" rows="4" required placeholder="Tuliskan saran atau pesan Anda..." class="w-full bg-gray-50 border border-gray-200 rounded-xl px-4 py-2.5 sm:py-3 text-xs sm:text-sm font-semibold outline-none focus:ring-2 focus:ring-green-500"></textarea>
                    </div>
                    <button type="submit" class="w-full bg-gray-900 hover:bg-green-800 text-white font-black py-3.5 sm:py-4 rounded-xl transition font-linktree flex items-center justify-center gap-2 text-xs sm:text-sm">
                        <i class="ph ph-paper-plane-tilt text-base sm:text-lg"></i> Kirim Saran ke Email
                    </button>
                </form>
            </div>

            <div id="daftar" class="bg-green-900 text-white rounded-[2rem] sm:rounded-[2.5rem] p-6 sm:p-10 shadow-2xl flex flex-col justify-between scroll-mt-28">
                <div>
                    <span class="bg-lime-400 text-black text-[10px] font-black px-3 py-1 rounded-full uppercase tracking-wider mb-2 inline-block">Gabung Banom</span>
                    <h3 class="font-display text-4xl sm:text-5xl text-white mb-1.5">FORMULIR PENDAFTARAN</h3>
                    <p class="text-xs text-green-200 font-medium mb-6">Daftarkan diri Anda menjadi bagian dari Badan Otonom NU Lesmana.</p>

              <form action="{{ route('member.register') }}" method="POST" autocomplete="off" class="space-y-3.5 sm:space-y-4">
                    @csrf
                    <div>
                        <label class="block text-xs font-bold uppercase mb-1 text-green-100">Nama Lengkap</label>
                        <input type="text" name="name" required placeholder="Sesuai KTP / KK" autocomplete="off" class="w-full bg-white/10 border border-white/20 rounded-xl px-4 py-2.5 sm:py-3 text-xs sm:text-sm font-semibold text-white placeholder-green-200/50 outline-none focus:ring-2 focus:ring-lime-400">
                    </div>
                    <div>
                        <label class="block text-xs font-bold uppercase mb-1 text-green-100">Email Akun</label>
                        <input type="email" name="email" required placeholder="email@domain.com" autocomplete="new-email" class="w-full bg-white/10 border border-white/20 rounded-xl px-4 py-2.5 sm:py-3 text-xs sm:text-sm font-semibold text-white placeholder-green-200/50 outline-none focus:ring-2 focus:ring-lime-400">
                    </div>
                    <div>
                        <label class="block text-xs font-bold uppercase mb-1 text-green-100">Pilihan Banom</label>
                        <select name="banom" required class="w-full bg-green-950 border border-white/20 rounded-xl px-4 py-2.5 sm:py-3 text-xs sm:text-sm font-semibold text-white outline-none focus:ring-2 focus:ring-lime-400">
                            <option value="IPNU">IPNU (Pelajar Putra)</option>
                            <option value="IPPNU">IPPNU (Pelajar Putri)</option>
                            <option value="Ansor">GP Ansor / Banser</option>
                            <option value="Fatayat">Fatayat NU</option>
                            <option value="Muslimat">Muslimat NU</option>
                            <option value="NU">Nahdlatul Ulama</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-xs font-bold uppercase mb-1 text-green-100">No. WhatsApp</label>
                        <input type="text" name="phone" placeholder="08xxxxxxxxxx" autocomplete="off" class="w-full bg-white/10 border border-white/20 rounded-xl px-4 py-2.5 sm:py-3 text-xs sm:text-sm font-semibold text-white placeholder-green-200/50 outline-none focus:ring-2 focus:ring-lime-400">
                    </div>
                    <div>
                        <label class="block text-xs font-bold uppercase mb-1 text-green-100">Password</label>
                        <input type="password" name="password" required placeholder="Minimal 8 karakter" autocomplete="new-password" class="w-full bg-white/10 border border-white/20 rounded-xl px-4 py-2.5 sm:py-3 text-xs sm:text-sm font-semibold text-white placeholder-green-200/50 outline-none focus:ring-2 focus:ring-lime-400">
                    </div>
                    <div>
                        <label class="block text-xs font-bold uppercase mb-1 text-green-100">Konfirmasi Password</label>
                        <input type="password" name="password_confirmation" required placeholder="Ulangi password" autocomplete="new-password" class="w-full bg-white/10 border border-white/20 rounded-xl px-4 py-2.5 sm:py-3 text-xs sm:text-sm font-semibold text-white placeholder-green-200/50 outline-none focus:ring-2 focus:ring-lime-400">
                    </div>
                    <button type="submit" class="w-full bg-lime-400 hover:bg-lime-300 text-gray-900 font-black py-3.5 sm:py-4 rounded-xl transition font-linktree text-xs sm:text-sm mt-2">
                        Kirim Formulir Pendaftaran
                    </button>
                </form>
                </div>

                <div class="mt-6 sm:mt-8 pt-4 sm:pt-6 border-t border-white/10 text-center text-[11px] text-green-200/70">
                    Pendaftaran akan diverifikasi/di-ACC terlebih dahulu oleh Pengurus Admin agar NIA diterbitkan.
                </div>
            </div>

        </div>
    </section>

    <!-- FOOTER -->
    <footer class="bg-gray-900 text-white py-6 sm:py-8 text-center text-xs font-semibold">
        <p>© 2026 Pengurus Ranting NU Lesmana. All rights reserved.</p>
    </footer>

    <script>
        // MENU MOBILE
        function toggleMobileMenu() {
            document.getElementById('mobileMenu').classList.toggle('hidden');
        }

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
            1: { box: 'bg-green-900 border-green-900', icon: 'bg-lime-400 text-green-900', pill: 'bg-lime-400 text-gray-900', name: 'text-white', desc: 'text-green-200' },
            2: { box: 'bg-lime-100 border-lime-300',   icon: 'bg-green-900 text-lime-400', pill: 'bg-green-900 text-lime-300', name: 'text-gray-900', desc: 'text-gray-600' },
            3: { box: 'bg-gray-50 border-gray-200',    icon: 'bg-green-900 text-lime-400', pill: 'bg-green-100 text-green-800', name: 'text-gray-900', desc: 'text-gray-500' }
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
                btn.classList.remove('bg-green-900', 'text-white');
                btn.classList.add('bg-gray-100', 'text-gray-700');
            });
            const activeBtn = document.getElementById('tab-' + banomKey);
            activeBtn.classList.remove('bg-gray-100', 'text-gray-700');
            activeBtn.classList.add('bg-green-900', 'text-white');

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

</body>
</html>