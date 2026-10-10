<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Admin - NU Pasiraman Lor</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;600;700;800;900&display=swap" rel="stylesheet">
    <script src="https://unpkg.com/@phosphor-icons/web"></script>
    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; background-color: #f4f7f6; }
        .no-scrollbar::-webkit-scrollbar { display: none; }
        .no-scrollbar { -ms-overflow-style: none; scrollbar-width: none; }
    </style>
</head>
<body class="text-slate-800 h-screen overflow-hidden flex font-sans p-4 gap-4">

    <aside class="w-[260px] bg-white rounded-3xl flex flex-col justify-between py-6 shadow-sm hidden md:flex">
        <div>
            <div class="px-8 flex items-center gap-3 mb-10">
                <div class="w-9 h-9 rounded-full bg-green-900 text-white flex items-center justify-center font-bold">
                    <i class="ph ph-globe-hemisphere-west text-xl"></i>
                </div>
                <div>
                    <h1 class="text-lg font-black tracking-tight text-gray-900 leading-none">NU Pasiraman</h1>
                    <span class="text-[10px] text-green-700 font-bold uppercase tracking-wider">Admin Panel</span>
                </div>
            </div>

            <div class="px-4">
                <p class="px-4 text-xs font-bold text-gray-400 mb-3 tracking-wider">MODUL UTAMA</p>
                <nav class="flex flex-col gap-1.5">
                    <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-3 px-4 py-3 bg-green-50 text-green-900 rounded-2xl relative font-bold text-sm">
                        <div class="absolute left-0 top-1/2 -translate-y-1/2 w-1.5 h-8 bg-green-900 rounded-r-full"></div>
                        <i class="ph ph-squares-four text-xl"></i> Dashboard
                    </a>
                    <a href="{{ route('admin.members.index') }}" class="flex items-center gap-3 px-4 py-3 text-gray-500 hover:text-green-900 hover:bg-gray-50 rounded-2xl font-bold text-sm transition">
                        <i class="ph ph-users-three text-xl"></i> Kelola Anggota
                    </a>
                    <a href="{{ route('admin.news.index') }}" class="flex items-center gap-3 px-4 py-3 text-gray-500 hover:text-green-900 hover:bg-gray-50 rounded-2xl font-bold text-sm transition">
                        <i class="ph ph-newspaper text-xl"></i> Kelola Berita
                    </a>
                    <a href="{{ route('admin.infaq.index') }}" class="flex items-center gap-3 px-4 py-3 text-gray-500 hover:text-green-900 hover:bg-gray-50 rounded-2xl font-bold text-sm transition">
                         <i class="ph ph-wallet text-xl"></i> Kelola Infaq / Kas
                    </a>
                </nav>
            </div>
        </div>

        <div class="px-4">
            <button onclick="openLogoutModal()" class="w-full flex items-center justify-center gap-2 px-4 py-3 bg-red-50 text-red-600 rounded-2xl font-bold text-sm hover:bg-red-100 transition">
                <i class="ph ph-sign-out text-lg"></i> Logout Admin
            </button>
        </div>
    </aside>

    <main class="flex-1 flex flex-col bg-white rounded-3xl overflow-hidden shadow-sm">
        
        <header class="h-20 px-8 flex items-center justify-between border-b border-gray-100">
            <div>
                <h2 class="text-xl font-extrabold text-gray-900">Dashboard Overview</h2>
                <p class="text-xs text-gray-400">Pusat kontrol data Ranting NU Pasiraman Lor</p>
            </div>
            
            <div class="flex items-center gap-4">
                <a href="{{ route('home') }}" target="_blank" class="text-xs font-bold bg-gray-100 hover:bg-gray-200 text-gray-800 px-4 py-2.5 rounded-full transition flex items-center gap-1.5">
                    <i class="ph ph-arrow-square-out text-base"></i> Lihat Web Publik
                </a>
                <div class="flex items-center gap-3">
                    <img src="https://ui-avatars.com/api/?name={{ urlencode(Auth::user()->name ?? 'Admin') }}&background=166534&color=fff" class="w-9 h-9 rounded-full shadow-sm">
                    <div class="hidden lg:block">
                        <p class="text-xs font-bold text-gray-800">{{ Auth::user()->name ?? 'Administrator' }}</p>
                        <p class="text-[10px] text-gray-400">Pengurus Ranting</p>
                    </div>
                </div>
            </div>
        </header>

        <div class="flex-1 overflow-y-auto p-8 no-scrollbar space-y-8">
            
            @if(session('success'))
                <div class="bg-green-900 text-white px-6 py-4 rounded-2xl font-bold text-sm shadow-md flex items-center justify-between">
                    <span><i class="ph ph-check-circle text-lg align-middle mr-2"></i> {{ session('success') }}</span>
                    <button onclick="this.parentElement.remove()" class="text-white/80"><i class="ph ph-x text-lg"></i></button>
                </div>
            @endif

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <div class="bg-green-900 text-white rounded-3xl p-6 shadow-xl flex flex-col justify-between h-44 relative overflow-hidden">
                    <div class="flex justify-between items-start z-10">
                        <span class="text-xs font-bold text-green-200 uppercase tracking-wider">Anggota Resmi Ter-ACC</span>
                        <div class="w-8 h-8 rounded-full bg-white/20 flex items-center justify-center text-white">
                            <i class="ph ph-user-check text-base"></i>
                        </div>
                    </div>
                    <div class="z-10">
                        <h3 class="text-4xl font-black mb-1">{{ $totalApprovedMembers ?? 0 }}</h3>
                        <p class="text-xs text-green-200 font-medium">Kader Aktif Banom NU</p>
                    </div>
                </div>

                <div class="bg-gray-50 border border-gray-100 rounded-3xl p-6 flex flex-col justify-between h-44 shadow-sm">
                    <div class="flex justify-between items-start">
                        <span class="text-xs font-bold text-gray-400 uppercase tracking-wider">Antrean Pendaftar Baru</span>
                        <div class="w-8 h-8 rounded-full bg-orange-100 text-orange-600 flex items-center justify-center">
                            <i class="ph ph-clock text-base"></i>
                        </div>
                    </div>
                    <div>
                        <h3 class="text-4xl font-black text-gray-900 mb-1">{{ count($pendingMembers ?? []) }}</h3>
                        <p class="text-xs text-orange-600 font-bold">Membutuhkan Verifikasi/ACC Admin</p>
                    </div>
                </div>

                <div class="bg-gray-50 border border-gray-100 rounded-3xl p-6 flex flex-col justify-between h-44 shadow-sm">
                    <div class="flex justify-between items-start">
                        <span class="text-xs font-bold text-gray-400 uppercase tracking-wider">Total Berita Dipublish</span>
                        <div class="w-8 h-8 rounded-full bg-green-100 text-green-800 flex items-center justify-center">
                            <i class="ph ph-newspaper text-base"></i>
                        </div>
                    </div>
                    <div>
                        <h3 class="text-4xl font-black text-gray-900 mb-1">{{ $totalNews ?? 0 }}</h3>
                        <p class="text-xs text-green-600 font-bold">Artikel Berita & Agenda Tampil</p>
                    </div>
                </div>
            </div>

            <div class="bg-gray-50 border border-gray-100 rounded-3xl p-6">
                <div class="flex justify-between items-center mb-6">
                    <div>
                        <h3 class="text-base font-extrabold text-gray-900">Antrean Pendaftaran Anggota Terbaru</h3>
                        <p class="text-xs text-gray-400">Verifikasi warga yang mendaftar melalui halaman publik.</p>
                    </div>
                    <a href="{{ route('admin.members.index') }}" class="text-xs font-bold text-green-800 hover:underline flex items-center gap-1">
                        Kelola Semua Anggota →
                    </a>
                </div>

                <div class="space-y-3">
                    @forelse($pendingMembers ?? [] as $member)
                        <div class="bg-white p-4 rounded-2xl flex items-center justify-between border border-gray-100 hover:shadow-sm transition">
                            <div class="flex items-center gap-3">
                                <div class="w-10 h-10 rounded-full bg-green-100 text-green-800 font-bold flex items-center justify-center text-sm">
                                    {{ substr($member->name, 0, 1) }}
                                </div>
                                <div>
                                    <h4 class="font-bold text-sm text-gray-900">{{ $member->name }}</h4>
                                    <div class="flex items-center gap-2 mt-0.5">
                                        <span class="text-[10px] font-bold text-green-800 bg-green-50 px-2.5 py-0.5 rounded-full">{{ $member->banom }}</span>
                                        <span class="text-[11px] text-gray-400">{{ $member->phone ?? 'Tidak ada No WA' }}</span>
                                    </div>
                                </div>
                            </div>
                            <div class="flex gap-2">
                                <form action="{{ route('admin.members.approve', $member->id) }}" method="POST">
                                    @csrf @method('PATCH')
                                    <button class="bg-gray-900 hover:bg-green-700 text-white text-xs font-bold px-4 py-2 rounded-xl transition">ACC</button>
                                </form>
                                <form action="{{ route('admin.members.reject', $member->id) }}" method="POST">
                                    @csrf @method('DELETE')
                                    <button class="bg-gray-100 hover:bg-red-50 hover:text-red-600 text-gray-600 text-xs font-bold px-4 py-2 rounded-xl transition">Tolak</button>
                                </form>
                            </div>
                        </div>
                    @empty
                        <div class="text-center py-8 text-gray-400">
                            <i class="ph ph-check-circle text-4xl mb-1 inline-block text-green-600"></i>
                            <p class="text-xs italic font-semibold text-gray-600">Tidak ada antrean pendaftaran anggota baru saat ini.</p>
                        </div>
                    @endforelse
                </div>
            </div>

        </div>
    </main>

    <div id="logoutModal" class="fixed inset-0 bg-black/60 z-[100] hidden flex items-center justify-center backdrop-blur-sm">
        <div class="bg-white rounded-3xl p-8 max-w-sm w-full text-center shadow-2xl">
            <i class="ph ph-warning-circle text-5xl text-red-500 mb-3 inline-block"></i>
            <h3 class="text-xl font-bold text-gray-900 mb-1">Logout dari Dashboard?</h3>
            <p class="text-xs text-gray-500 mb-6">Anda harus login kembali untuk mengelola data Ranting NU.</p>
            <div class="flex gap-3">
                <button onclick="closeLogoutModal()" class="flex-1 bg-gray-100 hover:bg-gray-200 text-gray-800 font-bold py-3 rounded-xl transition text-xs">Batal</button>
                <form method="POST" action="{{ route('logout') }}" class="flex-1">
                    @csrf
                    <button type="submit" class="w-full bg-red-600 hover:bg-red-700 text-white font-bold py-3 rounded-xl transition text-xs">Ya, Logout</button>
                </form>
            </div>
        </div>
    </div>

    <script>
        function openLogoutModal() { document.getElementById('logoutModal').classList.remove('hidden'); }
        function closeLogoutModal() { document.getElementById('logoutModal').classList.add('hidden'); }
    </script>
</body>
</html>