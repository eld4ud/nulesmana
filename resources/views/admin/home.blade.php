<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ranting NU Pasiraman Lor - Portal Resmi Warga</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800;900&family=Syne:wght@700;800&display=swap" rel="stylesheet">
    <script src="https://unpkg.com/@phosphor-icons/web"></script>
    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; background-color: #d5f028; }
        .font-linktree { font-family: 'Syne', sans-serif; }
        .slide-item { transition: opacity 0.8s ease-in-out; }

        /* ANIMASI SMART NAVBAR (HIDE ON SCROLL DOWN, SHOW ON SCROLL UP) */
        #smart-navbar {
            transition: transform 0.4s cubic-bezier(0.4, 0, 0.2, 1);
        }
        .nav-hidden {
            transform: translate(-50%, -150%) !important;
        }
    </style>
</head>
<body class="text-gray-900 min-h-screen relative overflow-x-hidden selection:bg-green-900 selection:text-white font-normal">

    <!-- FLOATING SMART NAVBAR PUBLIK -->
    <nav id="smart-navbar" class="fixed top-6 left-1/2 transform -translate-x-1/2 w-[95%] max-w-7xl bg-white/90 backdrop-blur-md rounded-full shadow-md px-6 py-4 flex justify-between items-center z-50">
        <div class="flex items-center gap-2">
            <div class="w-8 h-8 bg-green-900 rounded-full flex items-center justify-center text-white">
                <i class="ph ph-globe-hemisphere-west text-lg"></i>
            </div>
            <span class="font-normal text-xl tracking-tight font-linktree">NUPasiraman<span class="text-green-600">Lor</span></span>
        </div>
        
        <div class="hidden md:flex items-center gap-8 font-normal text-gray-600 text-xs">
            <a href="#berita" class="hover:text-green-900 transition">Berita & Agenda</a>
            <a href="#statistik" class="hover:text-green-900 transition">Statistik Banom</a>
            <a href="#saran" class="hover:text-green-900 transition">Kotak Saran</a>
        </div>

        <div class="flex items-center gap-3">
            <a href="#daftar" class="bg-gray-900 hover:bg-green-800 text-white px-5 py-2.5 rounded-full text-xs font-normal transition shadow-sm font-linktree">
                Daftar Anggota
            </a>
            <!-- Link Akses Login Khusus Admin -->
            <a href="{{ route('login') }}" class="text-xs font-normal text-gray-600 hover:text-gray-900 px-3 py-2">
                Login Admin
            </a>
        </div>
    </nav>

    <!-- ALERT NOTIFIKASI -->
    <div class="max-w-7xl mx-auto px-6 pt-28">
        @if(session('success'))
            <div class="bg-green-900 text-white px-6 py-4 rounded-2xl font-normal text-xs shadow-lg flex items-center justify-between mb-4">
                <span><i class="ph ph-check-circle text-base align-middle mr-2"></i> {{ session('success') }}</span>
                <button onclick="this.parentElement.remove()" class="text-white/80"><i class="ph ph-x text-base"></i></button>
            </div>
        @endif
        @if(session('error'))
            <div class="bg-red-600 text-white px-6 py-4 rounded-2xl font-normal text-xs shadow-lg flex items-center justify-between mb-4">
                <span><i class="ph ph-warning-circle text-base align-middle mr-2"></i> {{ session('error') }}</span>
                <button onclick="this.parentElement.remove()" class="text-white/80"><i class="ph ph-x text-base"></i></button>
            </div>
        @endif
    </div>

    <!-- HERO SECTION PUBLIK -->
    <main class="max-w-7xl mx-auto px-6 pt-4 pb-16 flex flex-col lg:flex-row items-center justify-between gap-12">
        
        <!-- KOLOM KIRI (TEKS BOLD HANYA JUDUL Portal Resmi Pasiraman Lor) -->
        <div class="w-full lg:w-1/2">
            <span class="bg-white/80 border border-gray-900/10 text-green-900 text-[10px] font-normal px-4 py-1.5 rounded-full uppercase tracking-wider mb-6 inline-block font-linktree">
                Selamat Datang Warga NU
            </span>
            <h1 class="text-5xl lg:text-7xl font-extrabold text-gray-900 leading-[1.05] mb-6 tracking-tight font-linktree">
                Portal Resmi <br>
                <span class="text-green-900">Pasiraman Lor.</span>
            </h1>
            <p class="text-base font-normal text-gray-800 mb-8 max-w-lg leading-relaxed">
                Pusat informasi kegiatan majelis, berita agenda keagamaan, serta layanan pendaftaran anggota Badan Otonom Ranting NU.
            </p>
            <div class="flex items-center gap-4">
                <a href="#berita" class="bg-gray-900 text-white text-xs font-normal px-7 py-3.5 rounded-full hover:bg-green-800 transition shadow-md font-linktree">
                    Lihat Berita Kegiatan
                </a>
                <a href="#saran" class="bg-white border border-gray-900/20 text-gray-900 text-xs font-normal px-7 py-3.5 rounded-full hover:bg-gray-50 transition shadow-sm font-linktree">
                    Kirim Saran
                </a>
            </div>
        </div>

        <!-- KOLOM KANAN SLIDER BANNER KEGIATAN -->
        <div class="w-full lg:w-1/2">
            <div class="bg-green-950 rounded-3xl p-6 text-white shadow-xl relative overflow-hidden h-80 flex flex-col justify-end">
                <div class="slide-item absolute inset-0 w-full h-full opacity-100 transition-opacity duration-1000">
                    <img src="https://images.unsplash.com/photo-1542601906990-b4d3fb778b09?auto=format&fit=crop&w=800&q=80" class="w-full h-full object-cover opacity-50">
                    <div class="absolute inset-0 bg-gradient-to-t from-black via-transparent to-transparent"></div>
                    <div class="absolute bottom-6 left-6 right-6">
                        <span class="bg-green-500 text-black text-[10px] font-normal px-3 py-1 rounded-full uppercase tracking-wider mb-2 inline-block">Agenda Terdekat</span>
                        <h3 class="text-xl font-medium font-linktree">Lailatul Ijtima' & Doa Bersama</h3>
                        <p class="text-xs font-light text-gray-300">Setiap Malam Jumat Kliwon di Masjid Jami'</p>
                    </div>
                </div>
                <div class="slide-item absolute inset-0 w-full h-full opacity-0 transition-opacity duration-1000">
                    <img src="https://images.unsplash.com/photo-1511632765486-a01980e01a18?auto=format&fit=crop&w=800&q=80" class="w-full h-full object-cover opacity-50">
                    <div class="absolute inset-0 bg-gradient-to-t from-black via-transparent to-transparent"></div>
                    <div class="absolute bottom-6 left-6 right-6">
                        <span class="bg-yellow-400 text-black text-[10px] font-normal px-3 py-1 rounded-full uppercase tracking-wider mb-2 inline-block">Kaderisasi</span>
                        <h3 class="text-xl font-medium font-linktree">Pelatihan Banser & Ansor</h3>
                        <p class="text-xs font-light text-gray-300">Siap Menjaga Ulama & NKRI</p>
                    </div>
                </div>
                <div class="absolute top-6 right-6 flex gap-1.5 z-20">
                    <div class="indicator w-4 h-1.5 rounded-full bg-white transition-all"></div>
                    <div class="indicator w-1.5 h-1.5 rounded-full bg-white/40 transition-all"></div>
                </div>
            </div>
        </div>

    </main>

    <!-- SECTION 1: BERITA & AGENDA KEGIATAN -->
    <section id="berita" class="max-w-7xl mx-auto px-6 py-12">
        <div class="bg-white rounded-3xl p-8 lg:p-12 shadow-xl border border-gray-100">
            <div class="mb-10 text-center max-w-xl mx-auto">
                <h2 class="text-2xl lg:text-3xl font-medium text-gray-900 font-linktree">Berita & Agenda Kegiatan</h2>
                <p class="text-xs font-light text-gray-500 mt-2">Seputar liputan majelis, pengajian rutin, dan kegiatan sosial warga Ranting NU Pasiraman Lor.</p>
            </div>

            <!-- GRID CARDS BERITA PUBLIK -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                @forelse($publishedNews ?? [] as $news)
                    <div class="bg-gray-50/70 rounded-3xl overflow-hidden border border-gray-100 flex flex-col justify-between hover:shadow-md transition duration-300">
                        <div>
                            <!-- Foto Sampul -->
                            <div class="h-48 w-full bg-gray-200 relative overflow-hidden">
                                @if($news->image)
                                    <img src="{{ \Illuminate\Support\Facades\Storage::url($news->image) }}" class="w-full h-full object-cover">
                                @else
                                    <img src="https://images.unsplash.com/photo-1542601906990-b4d3fb778b09?auto=format&fit=crop&w=800&q=80" class="w-full h-full object-cover opacity-60">
                                @endif
                                <div class="absolute top-4 left-4 bg-white/90 backdrop-blur-md text-green-900 text-xs font-normal px-3 py-1 rounded-full flex items-center gap-1.5 shadow-sm">
                                    <i class="ph ph-calendar text-sm"></i>
                                    {{ $news->event_date ? \Carbon\Carbon::parse($news->event_date)->translatedFormat('d M Y') : 'Jadwal (-)' }}
                                </div>
                            </div>

                            <!-- Detail Berita -->
                            <div class="p-6">
                                <h3 class="text-lg font-medium text-gray-900 mb-2 leading-snug font-linktree line-clamp-2">
                                    {{ $news->title }}
                                </h3>
                                <p class="text-xs font-light text-gray-600 leading-relaxed line-clamp-3">
                                    {{ $news->content ?? 'Tidak ada deskripsi berita.' }}
                                </p>
                            </div>
                        </div>

                        <div class="px-6 pb-6 pt-2 border-t border-gray-100 mt-auto">
                            <span class="text-[10px] text-gray-400 font-light">
                                Diposting {{ $news->created_at ? $news->created_at->diffForHumans() : 'Baru saja' }}
                            </span>
                        </div>
                    </div>
                @empty
                    <div class="col-span-full py-16 text-center text-gray-400">
                        <i class="ph ph-newspaper text-5xl mb-2 inline-block text-gray-300"></i>
                        <p class="text-sm font-medium text-gray-700 font-linktree">Belum Ada Berita Terbaru</p>
                        <p class="text-xs font-light text-gray-500 mt-1">Pantau terus halaman ini untuk agenda kegiatan mendatang.</p>
                    </div>
                @endforelse
            </div>
        </div>
    </section>

    <!-- SECTION 2: STATISTIK ANGGOTA BANOM -->
    <section id="statistik" class="max-w-7xl mx-auto px-6 py-8">
        <div class="bg-gray-900 text-white rounded-3xl p-8 lg:p-12 shadow-xl">
            <div class="text-center max-w-xl mx-auto mb-10">
                <h2 class="text-2xl font-medium font-linktree">Statistik Anggota Banom</h2>
                <p class="text-xs font-light text-gray-400 mt-1">Jumlah kader & anggota resmi yang terverifikasi di Ranting Pasiraman Lor.</p>
            </div>

            <div class="grid grid-cols-2 md:grid-cols-4 gap-6 text-center">
                <div class="bg-white/10 backdrop-blur-md rounded-2xl p-6 border border-white/10">
                    <h4 class="text-3xl font-medium text-lime-400 font-linktree">{{ $ipnuCount ?? 0 }}</h4>
                    <p class="text-[11px] font-normal text-gray-300 uppercase mt-1">Kader IPNU</p>
                </div>
                <div class="bg-white/10 backdrop-blur-md rounded-2xl p-6 border border-white/10">
                    <h4 class="text-3xl font-medium text-lime-400 font-linktree">{{ $ippnuCount ?? 0 }}</h4>
                    <p class="text-[11px] font-normal text-gray-300 uppercase mt-1">Kader IPPNU</p>
                </div>
                <div class="bg-white/10 backdrop-blur-md rounded-2xl p-6 border border-white/10">
                    <h4 class="text-3xl font-medium text-lime-400 font-linktree">{{ $ansorCount ?? 0 }}</h4>
                    <p class="text-[11px] font-normal text-gray-300 uppercase mt-1">GP Ansor / Banser</p>
                </div>
                <div class="bg-white/10 backdrop-blur-md rounded-2xl p-6 border border-white/10">
                    <h4 class="text-3xl font-medium text-lime-400 font-linktree">{{ $fatayatCount ?? 0 }}</h4>
                    <p class="text-[11px] font-normal text-gray-300 uppercase mt-1">Fatayat NU</p>
                </div>
            </div>
        </div>
    </section>

    <!-- SECTION 3: KOTAK SARAN & FORM PENDAFTARAN -->
    <section id="saran" class="max-w-7xl mx-auto px-6 py-12 pb-24">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
            
            <!-- KOTAK SARAN & MASUKAN (KIRIM EMAIL) -->
            <div class="bg-white rounded-3xl p-8 lg:p-10 shadow-xl border border-gray-100">
                <div class="mb-6">
                    <span class="bg-green-50 text-green-800 text-[10px] font-normal px-3 py-1 rounded-full uppercase tracking-wider mb-2 inline-block">Kritik & Saran</span>
                    <h3 class="text-2xl font-medium text-gray-900 font-linktree">Kotak Aspirasi Warga</h3>
                    <p class="text-xs font-light text-gray-500 mt-1">Saran & masukan Anda akan langsung dikirimkan ke email pengurus Ranting NU.</p>
                </div>

                <form action="{{ route('feedback.send') }}" method="POST" class="space-y-4">
                    @csrf
                    <div>
                        <label class="block text-[11px] font-medium text-gray-600 uppercase mb-1">Nama Lengkap</label>
                        <input type="text" name="name" required placeholder="Masukkan nama Anda" class="w-full bg-gray-50 border border-gray-200 rounded-xl px-4 py-3 text-xs font-normal outline-none focus:ring-1 focus:ring-green-600">
                    </div>
                    <div>
                        <label class="block text-[11px] font-medium text-gray-600 uppercase mb-1">Email Anda</label>
                        <input type="email" name="email" required placeholder="alamat@email.com" class="w-full bg-gray-50 border border-gray-200 rounded-xl px-4 py-3 text-xs font-normal outline-none focus:ring-1 focus:ring-green-600">
                    </div>
                    <div>
                        <label class="block text-[11px] font-medium text-gray-600 uppercase mb-1">Pesan / Saran / Aspirasi</label>
                        <textarea name="message" rows="4" required placeholder="Tuliskan saran atau pesan Anda..." class="w-full bg-gray-50 border border-gray-200 rounded-xl px-4 py-3 text-xs font-normal outline-none focus:ring-1 focus:ring-green-600"></textarea>
                    </div>
                    <button type="submit" class="w-full bg-gray-900 hover:bg-green-800 text-white font-normal py-3.5 rounded-xl transition font-linktree flex items-center justify-center gap-2 text-xs">
                        <i class="ph ph-paper-plane-tilt text-base"></i> Kirim Saran ke Email
                    </button>
                </form>
            </div>

            <!-- FORM PENDAFTARAN ANGGOTA BANOM (LENGKAP DENGAN JENIS KELAMIN) -->
            <div id="daftar" class="bg-green-900 text-white rounded-3xl p-8 lg:p-10 shadow-xl flex flex-col justify-between">
                <div>
                    <span class="bg-lime-400 text-gray-900 text-[10px] font-medium px-3 py-1 rounded-full uppercase tracking-wider mb-2 inline-block">Gabung Banom</span>
                    <h3 class="text-2xl font-medium font-linktree text-white mb-1">Formulir Pendaftaran</h3>
                    <p class="text-xs font-light text-green-200 mb-6">Daftarkan diri Anda menjadi bagian dari Badan Otonom NU Pasiraman Lor.</p>

                    <!-- FORM PENDAFTARAN ANGGOTA BANOM -->
                    <form action="{{ route('member.register') }}" method="POST" class="space-y-4">
                        @csrf
                        <div>
                            <label class="block text-[11px] font-medium uppercase mb-1 text-green-100">Nama Lengkap</label>
                            <input type="text" name="name" required placeholder="Sesuai KTP / KK" class="w-full bg-white/10 border border-white/20 rounded-xl px-4 py-3 text-xs font-normal text-white placeholder-green-200/50 outline-none focus:ring-1 focus:ring-lime-400">
                        </div>

                        <!-- TAMBAHAN INPUT JENIS KELAMIN -->
                        <div>
                            <label class="block text-[11px] font-medium uppercase mb-1 text-green-100">Jenis Kelamin</label>
                            <select name="gender" required class="w-full bg-green-950 border border-white/20 rounded-xl px-4 py-3 text-xs font-normal text-white outline-none focus:ring-1 focus:ring-lime-400">
                                <option value="Laki-laki">Laki-laki</option>
                                <option value="Perempuan">Perempuan</option>
                            </select>
                        </div>

                        <div>
                            <label class="block text-[11px] font-medium uppercase mb-1 text-green-100">Pilihan Banom</label>
                            <select name="banom" required class="w-full bg-green-950 border border-white/20 rounded-xl px-4 py-3 text-xs font-normal text-white outline-none focus:ring-1 focus:ring-lime-400">
                                <option value="IPNU">IPNU (Pelajar Putra)</option>
                                <option value="IPPNU">IPPNU (Pelajar Putri)</option>
                                <option value="Ansor">GP Ansor / Banser</option>
                                <option value="Fatayat">Fatayat NU</option>
                                <option value="Muslimat">Muslimat NU</option>
                            </select>
                        </div>
                        
                        <button type="submit" class="w-full bg-lime-400 hover:bg-lime-300 text-gray-900 font-medium py-3.5 rounded-xl transition font-linktree text-xs mt-2">
                            Kirim Formulir Pendaftaran
                        </button>
                    </form>
                </div>

                <div class="mt-8 pt-6 border-t border-white/10 text-center text-[11px] font-light text-green-200/70">
                    Pendaftaran akan diverifikasi/di-ACC terlebih dahulu oleh Pengurus Admin.
                </div>
            </div>

        </div>
    </section>

    <!-- FOOTER PUBLIK -->
    <footer class="bg-gray-900 text-white py-8 text-center text-xs font-light">
        <p>© 2026 Pengurus Ranting NU Pasiraman Lor. All rights reserved.</p>
    </footer>

    <!-- SCRIPT SLIDER & SMART NAVBAR -->
    <script>
        // SMART NAVBAR SCROLL ANIMATION
        let lastScrollTop = 0;
        const navbar = document.getElementById('smart-navbar');

        window.addEventListener('scroll', function() {
            let scrollTop = window.pageYOffset || document.documentElement.scrollTop;

            if (scrollTop > lastScrollTop && scrollTop > 100) {
                navbar.classList.add('nav-hidden');
            } else {
                navbar.classList.remove('nav-hidden');
            }
            lastScrollTop = scrollTop <= 0 ? 0 : scrollTop;
        });

        // SLIDER AUTOPLAY
        let currentSlide = 0;
        const slides = document.querySelectorAll('.slide-item');
        const indicators = document.querySelectorAll('.indicator');

        function showSlide(index) {
            slides.forEach((slide, i) => {
                if(i === index) {
                    slide.classList.remove('opacity-0');
                    slide.classList.add('opacity-100');
                    indicators[i].classList.remove('bg-white/40');
                    indicators[i].classList.add('bg-white', 'w-4');
                } else {
                    slide.classList.remove('opacity-100');
                    slide.classList.add('opacity-0');
                    indicators[i].classList.remove('bg-white', 'w-4');
                    indicators[i].classList.add('bg-white/40');
                }
            });
        }

        setInterval(() => {
            currentSlide = (currentSlide + 1) % slides.length;
            showSlide(currentSlide);
        }, 3500);
    </script>

</body>
</html>