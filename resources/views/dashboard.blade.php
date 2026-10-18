<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Publik - NU Pasiraman Lor</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <script src="https://unpkg.com/@phosphor-icons/web"></script>
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: { sans: ['"Plus Jakarta Sans"', 'sans-serif'] },
                    colors: {
                        nugreen: {
                            50: '#f0fdf4', 100: '#dcfce7', 500: '#22c55e',
                            700: '#15803d', 800: '#166534', 900: '#14532d',
                        }
                    }
                }
            }
        }
    </script>
    <style>
        body { background-color: #f4f7f6; }
        .no-scrollbar::-webkit-scrollbar { display: none; }
        .no-scrollbar { -ms-overflow-style: none; scrollbar-width: none; }
    </style>
</head>
<body class="text-slate-800 h-screen overflow-hidden flex font-sans p-4 gap-4">

    <!-- ================= SIDEBAR ================= -->
    <aside class="w-[260px] bg-white rounded-3xl flex flex-col justify-between py-6 shadow-sm hidden md:flex">
        <div>
            <div class="px-8 flex items-center gap-3 mb-10">
                <div class="w-8 h-8 rounded-full bg-nugreen-800 text-white flex items-center justify-center font-bold">
                    <i class="ph ph-globe-hemisphere-west text-xl"></i>
                </div>
                <h1 class="text-xl font-extrabold tracking-tight">NU Pasiraman</h1>
            </div>

            <div class="px-4">
                <p class="px-4 text-xs font-bold text-gray-400 mb-3 tracking-wider">MENU UTAMA</p>
                <nav class="flex flex-col gap-1">
                    <a href="{{ route('dashboard') }}" class="flex items-center gap-3 px-4 py-3 bg-nugreen-50 text-nugreen-800 rounded-2xl relative font-semibold">
                        <div class="absolute left-0 top-1/2 -translate-y-1/2 w-1.5 h-8 bg-nugreen-800 rounded-r-full"></div>
                        <i class="ph ph-squares-four text-xl"></i>
                        Dashboard
                    </a>
                    <a href="{{ route('bio') }}" class="flex items-center gap-3 px-4 py-3 text-gray-500 hover:text-nugreen-800 hover:bg-gray-50 rounded-2xl font-medium transition">
                        <i class="ph ph-house text-xl"></i>
                        Halaman Bio
                    </a>
                </nav>
            </div>
        </div>

        <div class="px-6 mt-8">
            <div class="bg-gradient-to-br from-nugreen-900 to-black rounded-3xl p-5 text-white relative overflow-hidden">
                <div class="w-8 h-8 bg-white/20 backdrop-blur-sm rounded-full flex items-center justify-center mb-3">
                    <i class="ph ph-download-simple text-sm"></i>
                </div>
                <h4 class="font-bold text-sm mb-1">Download Rekap Kas</h4>
                <p class="text-[10px] text-gray-300 mb-4 opacity-80">Laporan infaq transparan warga</p>
                <button class="w-full bg-nugreen-500 text-nugreen-900 text-xs font-bold py-2 rounded-xl transition hover:bg-nugreen-400">
                    Download PDF
                </button>
            </div>
        </div>
    </aside>

    <!-- ================= MAIN CONTENT ================= -->
    <main class="flex-1 flex flex-col bg-white rounded-3xl overflow-hidden shadow-sm">
        
        <header class="h-20 px-8 flex items-center justify-between border-b border-gray-100">
            <div class="relative w-96">
                <i class="ph ph-magnifying-glass absolute left-4 top-1/2 -translate-y-1/2 text-gray-400 text-lg"></i>
                <input type="text" placeholder="Cari berita atau agenda..." class="w-full bg-gray-50 border-none rounded-full py-2.5 pl-11 pr-12 text-sm focus:ring-2 focus:ring-nugreen-100 outline-none transition">
            </div>

            <div class="flex items-center gap-4">
                @auth
                    <a href="{{ route('admin.home') }}" class="text-sm font-bold text-nugreen-800 hover:underline mr-2">← Ke Halaman Admin</a>
                    <div class="flex items-center gap-3">
                        <img src="https://ui-avatars.com/api/?name={{ urlencode(Auth::user()->name) }}&background=166534&color=fff" class="w-10 h-10 rounded-full shadow-sm">
                        <div class="hidden lg:block">
                            <p class="text-sm font-bold text-gray-800">{{ Auth::user()->name }}</p>
                            <p class="text-[11px] text-gray-400">Admin Ranting</p>
                        </div>
                    </div>
                @else
                    <a href="{{ route('login') }}" class="bg-gray-900 hover:bg-nugreen-800 text-white px-6 py-2.5 rounded-full text-sm font-bold transition flex items-center gap-2 shadow-lg">
                        <i class="ph ph-sign-in text-lg"></i> Login Admin
                    </a>
                @endauth
            </div>
        </header>

        <div class="flex-1 overflow-y-auto p-8 no-scrollbar">
            
            <div class="flex justify-between items-end mb-8">
                <div>
                    <h2 class="text-2xl font-extrabold text-gray-800 mb-1">Dashboard Publik</h2>
                    <p class="text-sm text-gray-500">Transparansi infaq, rekap anggota resmi, dan agenda Ranting NU Pasiraman Lor.</p>
                </div>
               <a href="{{ route('member.register') }}" class="bg-nugreen-800 hover:bg-nugreen-900 text-white px-5 py-2.5 rounded-full text-sm font-semibold flex items-center gap-2 transition shadow-lg">
                <i class="ph ph-user-plus text-lg"></i> Daftar Anggota Banom
               </a>
            </div>

            <!-- STATS CARDS GRID (Grid 3 Kolom) -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-5 mb-6">
                
                <!-- Card 1 - Kas Infaq (Klik Panah untuk Detail Donasi) -->
                <div class="bg-nugreen-800 rounded-[1.5rem] p-6 text-white relative overflow-hidden flex flex-col justify-between h-40">
                    <div class="flex justify-between items-start z-10">
                        <p class="text-sm text-nugreen-100 font-medium">Total Kas Infaq</p>
                        <a href="{{ route('infaq.index') }}" class="w-8 h-8 rounded-full bg-white/20 hover:bg-white/40 flex items-center justify-center transition" title="Lihat Rekap Kas Lengkap">
                          <i class="ph ph-arrow-up-right text-sm"></i>
                        </a>
                    </div>
                    <div class="z-10">
                        <h3 class="text-3xl font-extrabold mb-1">Rp {{ number_format($totalInfaq ?? 0, 0, ',', '.') }}</h3>
                        <div class="flex items-center gap-1.5 text-xs text-nugreen-200 bg-white/10 w-max px-2 py-1 rounded-lg">
                            <i class="ph ph-shield-check"></i> Transparan & Amanah
                        </div>
                    </div>
                </div>

                <!-- Card 2 - Total Anggota Resmi (Klik Panah untuk Lihat Nama) -->
                <div class="bg-white border border-gray-100 rounded-[1.5rem] p-6 flex flex-col justify-between h-40 shadow-sm">
                    <div class="flex justify-between items-start">
                        <p class="text-sm text-gray-500 font-medium">Total Anggota Resmi</p>
                        <button onclick="openMembersModal()" class="w-8 h-8 rounded-full border border-gray-200 hover:bg-gray-100 flex items-center justify-center text-gray-600 transition" title="Lihat Daftar Nama">
                            <i class="ph ph-arrow-up-right text-sm"></i>
                        </button>
                    </div>
                    <div>
                        <h3 class="text-3xl font-extrabold text-gray-800 mb-1">{{ $totalMembers ?? 0 }}</h3>
                        <div class="flex items-center gap-1.5 text-xs text-green-600 bg-green-50 w-max px-2 py-1 rounded-lg font-medium">
                            <i class="ph ph-check-circle"></i> Terdaftar & Divalidasi
                        </div>
                    </div>
                </div>

                <!-- Card 3 - Pendaftar Terbaru -->
                <div class="bg-white border border-gray-100 rounded-[1.5rem] p-6 flex flex-col justify-between h-40 shadow-sm">
                    <div class="flex justify-between items-start">
                        <p class="text-sm text-gray-500 font-medium">Pendaftar Terbaru</p>
                        <button onclick="openRecentModal()" class="w-8 h-8 rounded-full border border-gray-200 hover:bg-gray-100 flex items-center justify-center text-gray-600 transition" title="Lihat Pendaftar Baru">
                            <i class="ph ph-arrow-right text-sm"></i>
                        </button>
                    </div>
                    <div>
                        <h3 class="text-3xl font-extrabold text-gray-800 mb-1">{{ count($recentMembers ?? []) }}</h3>
                        <div class="flex items-center gap-1.5 text-xs text-green-600 bg-green-50 w-max px-2 py-1 rounded-lg font-medium">
                            <i class="ph ph-user-check"></i> Sudah Di-ACC
                        </div>
                    </div>
                </div>

            </div>

            <!-- BOTTOM GRID -->
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-5">
                
                <!-- Daftar Kegiatan Terbaru -->
                <div class="lg:col-span-7 border border-gray-100 rounded-[1.5rem] p-6 shadow-sm">
                    <h3 class="text-sm font-bold text-gray-800 mb-5">Daftar Kegiatan Terbaru</h3>
                    <div class="flex flex-col gap-4">
                        @forelse($latestNews ?? [] as $news)
                            <div class="flex gap-4 items-center p-3 hover:bg-gray-50 rounded-2xl transition">
                                <div class="w-10 h-10 rounded-2xl bg-nugreen-50 text-nugreen-700 flex flex-shrink-0 items-center justify-center font-bold">
                                    <i class="ph ph-calendar-check text-xl"></i>
                                </div>
                                <div>
                                    <h4 class="text-sm font-bold text-gray-800 mb-0.5">{{ $news->title }}</h4>
                                    <p class="text-xs text-gray-400">
                                        {{ $news->event_date ? \Carbon\Carbon::parse($news->event_date)->translatedFormat('d M Y') : 'Jadwal belum ditentukan' }}
                                    </p>
                                </div>
                            </div>
                        @empty
                            <p class="text-xs text-gray-400 italic text-center py-8">Belum ada agenda kegiatan dari Admin.</p>
                        @endforelse
                    </div>
                </div>

                <!-- Anggota Baru Bergabung -->
                <div class="lg:col-span-5 border border-gray-100 rounded-[1.5rem] p-6 shadow-sm">
                    <h3 class="text-sm font-bold text-gray-800 mb-5">Anggota Baru Bergabung</h3>
                    <div class="flex flex-col gap-3 text-sm">
                        @forelse($recentMembers ?? [] as $member)
                            <div class="flex items-center justify-between p-2.5 hover:bg-gray-50 rounded-2xl transition">
                                <div class="flex items-center gap-3">
                                    <img src="https://ui-avatars.com/api/?name={{ urlencode($member->name) }}&background=f0fdf4&color=166534" class="w-9 h-9 rounded-full">
                                    <div>
                                        <p class="font-bold text-gray-800 leading-tight">{{ $member->name }}</p>
                                        <p class="text-[11px] text-gray-400">{{ $member->created_at ? $member->created_at->diffForHumans() : 'Baru saja' }}</p>
                                    </div>
                                </div>
                                <span class="text-[10px] font-bold px-3 py-1 rounded-full bg-green-50 text-green-700">
                                    {{ $member->banom }}
                                </span>
                            </div>
                        @empty
                            <p class="text-xs text-gray-400 italic text-center py-8">Belum ada anggota baru yang di-ACC.</p>
                        @endforelse
                    </div>
                </div>

            </div>

        </div>
    </main>

    <!-- MODAL 1: Detail Transparansi Infaq (Otomatis "Hamba Allah") -->
    <div id="infaqModal" class="fixed inset-0 bg-black/60 z-[100] hidden flex items-center justify-center backdrop-blur-sm">
        <div class="bg-white rounded-3xl p-6 max-w-md w-full shadow-2xl">
            <div class="flex justify-between items-center mb-4">
                <h3 class="text-lg font-bold text-gray-900">Riwayat Infaq Warga</h3>
                <button onclick="closeModal('infaqModal')" class="text-gray-400 hover:text-red-500"><i class="ph ph-x text-xl"></i></button>
            </div>
            <p class="text-xs text-gray-500 mb-4">*Nama dermawan ditampilkan sebagai Hamba Allah untuk menjaga keikhlasan.</p>
            <div class="space-y-3 max-h-60 overflow-y-auto pr-1">
                @forelse($infaqList ?? [] as $infaq)
                    <div class="flex justify-between items-center p-3 bg-gray-50 rounded-xl">
                        <div>
                            <p class="text-xs font-bold text-gray-800">Hamba Allah</p>
                            <p class="text-[10px] text-gray-400">{{ $infaq->created_at->format('d M Y') }}</p>
                        </div>
                        <span class="text-sm font-bold text-green-600">+ Rp {{ number_format($infaq->amount, 0, ',', '.') }}</span>
                    </div>
                @empty
                    <p class="text-xs text-gray-400 text-center py-4">Belum ada catatan transaksi infaq.</p>
                @endforelse
            </div>
        </div>
    </div>

    <!-- MODAL 2: Daftar Nama Seluruh Anggota Resmi -->
    <div id="membersModal" class="fixed inset-0 bg-black/60 z-[100] hidden flex items-center justify-center backdrop-blur-sm">
        <div class="bg-white rounded-3xl p-6 max-w-md w-full shadow-2xl">
            <div class="flex justify-between items-center mb-4">
                <h3 class="text-lg font-bold text-gray-900">Daftar Anggota Resmi</h3>
                <button onclick="closeModal('membersModal')" class="text-gray-400 hover:text-red-500"><i class="ph ph-x text-xl"></i></button>
            </div>
            <div class="space-y-3 max-h-60 overflow-y-auto pr-1">
                @forelse($allMembers ?? [] as $m)
                    <div class="flex justify-between items-center p-3 bg-gray-50 rounded-xl">
                        <p class="text-xs font-bold text-gray-800">{{ $m->name }}</p>
                        <span class="text-[10px] font-bold px-2.5 py-0.5 bg-green-100 text-green-800 rounded-full">{{ $m->banom }}</span>
                    </div>
                @empty
                    <p class="text-xs text-gray-400 text-center py-4">Belum ada anggota resmi terdaftar.</p>
                @endforelse
            </div>
        </div>
    </div>

    <!-- MODAL 3: Form Pendaftaran Anggota dari Dashboard -->
    <div id="registerModal" class="fixed inset-0 bg-black/60 z-[100] hidden flex items-center justify-center backdrop-blur-sm">
        <div class="bg-white rounded-3xl p-8 max-w-md w-full shadow-2xl">
            <div class="flex justify-between items-center mb-6">
                <h3 class="text-xl font-bold text-gray-900">Gabung Banom NU</h3>
                <button onclick="closeModal('registerModal')" class="text-gray-400 hover:text-red-500"><i class="ph ph-x text-2xl"></i></button>
            </div>
            <form action="/register-member" method="POST" class="space-y-4">
                @csrf
                <input type="text" name="name" placeholder="Nama Lengkap" required class="w-full px-4 py-3 bg-gray-50 border rounded-xl text-sm outline-none">
                <select name="banom" required class="w-full px-4 py-3 bg-gray-50 border rounded-xl text-sm outline-none text-gray-600">
                    <option value="">Pilih Badan Otonom</option>
                    <option value="IPNU">IPNU</option><option value="IPPNU">IPPNU</option>
                    <option value="Ansor">GP Ansor</option><option value="Banser">Banser</option>
                    <option value="Fatayat">Fatayat NU</option><option value="Muslimat">Muslimat NU</option>
                </select>
                <input type="text" name="phone" placeholder="Nomor WhatsApp (Opsional)" class="w-full px-4 py-3 bg-gray-50 border rounded-xl text-sm outline-none">
                <button type="submit" class="w-full bg-nugreen-800 text-white font-bold py-3.5 rounded-xl hover:bg-nugreen-900 transition">Kirim Pendaftaran</button>
            </form>
        </div>
    </div>

    <script>
        function openInfaqModal() { document.getElementById('infaqModal').classList.remove('hidden'); }
        function openMembersModal() { document.getElementById('membersModal').classList.remove('hidden'); }
        function openRecentModal() { document.getElementById('membersModal').classList.remove('hidden'); }
        function openRegisterModal() { document.getElementById('registerModal').classList.remove('hidden'); }
        function closeModal(id) { document.getElementById(id).classList.add('hidden'); }
    </script>
</body>
</html>