<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panel Admin | NU Lesmana</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <script src="https://unpkg.com/@phosphor-icons/web"></script>
    <style>
        body { font-family: 'DM Sans', sans-serif; background: #eaeae8; }
        .soft-panel { background: #fff; border: 1px solid #e6e6e3; border-radius: 18px; }
        .scrollbar-hide { scrollbar-width: none; }
        .scrollbar-hide::-webkit-scrollbar { display: none; }
    </style>
</head>
<body class="text-[#171717] min-h-screen p-3 sm:p-5">
    <div class="max-w-[1500px] mx-auto min-h-[calc(100vh-40px)] bg-[#f7f7f5] border border-[#dededb] rounded-[26px] overflow-hidden flex flex-col lg:flex-row shadow-sm">
        <!-- Sidebar: visual referensi hitam-putih -->
        <aside class="lg:w-[220px] shrink-0 bg-white border-b lg:border-b-0 lg:border-r border-[#e8e8e5] p-5 lg:p-6 flex flex-col">
            <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-3 mb-7 lg:mb-12">
                <span class="w-10 h-10 bg-[#161616] text-white rounded-xl grid place-items-center text-xl"><i class="ph ph-globe-hemisphere-west"></i></span>
                <span class="leading-tight"><strong class="block text-sm tracking-tight">NU LESMANA</strong><small class="text-[10px] text-gray-500 tracking-widest">ADMIN PANEL</small></span>
            </a>
            <p class="hidden lg:block text-[10px] text-[#999] font-bold tracking-[.16em] uppercase mb-3 px-3">Navigasi</p>
            <nav class="flex lg:flex-col gap-1 overflow-x-auto scrollbar-hide text-xs font-bold">
                <a href="{{ route('admin.dashboard') }}" class="flex shrink-0 items-center gap-3 px-3 py-3 bg-[#171717] text-white rounded-xl"><i class="ph ph-squares-four text-lg"></i> Dashboard</a>
                <a href="{{ route('admin.members.index') }}" class="flex shrink-0 items-center gap-3 px-3 py-3 hover:bg-[#f2f2f0] rounded-xl"><i class="ph ph-users-three text-lg"></i> Anggota</a>
                <a href="{{ route('admin.news.index') }}" class="flex shrink-0 items-center gap-3 px-3 py-3 hover:bg-[#f2f2f0] rounded-xl"><i class="ph ph-newspaper text-lg"></i> Berita</a>
                <a href="{{ route('admin.infaq.index') }}" class="flex shrink-0 items-center gap-3 px-3 py-3 hover:bg-[#f2f2f0] rounded-xl"><i class="ph ph-wallet text-lg"></i> Infak / Kas</a>
            </nav>
            <div class="mt-auto hidden lg:block pt-10">
                <div class="border-t border-[#ededeb] pt-5">
                    <p class="text-[10px] uppercase tracking-wider text-gray-400 mb-3">Akun pengurus</p>
                    <p class="text-xs font-bold truncate">{{ auth()->user()->name ?? 'Administrator' }}</p>
                    <form action="{{ route('logout') }}" method="POST" class="mt-4">@csrf
                        <button type="submit" class="text-xs font-bold flex items-center gap-2 text-[#555] hover:text-black"><i class="ph ph-sign-out text-lg"></i> Keluar</button>
                    </form>
                </div>
            </div>
        </aside>

        <main class="min-w-0 flex-1 px-4 py-6 sm:p-8 lg:p-10">
            <header class="flex flex-wrap justify-between items-start gap-4 mb-8">
                <div>
                    <p class="text-[11px] font-bold tracking-[.14em] uppercase text-gray-500 mb-2">Pengurus Ranting Nahdlatul Ulama Lesmana</p>
                    <h1 class="text-2xl sm:text-3xl font-extrabold tracking-tight">Halo, {{ auth()->user()->name ?? 'Admin' }}.</h1>
                    <p class="text-xs text-gray-500 mt-1">Ringkasan aktivitas dan layanan warga</p>
                </div>
                <a href="{{ route('home') }}" target="_blank" rel="noopener noreferrer" class="inline-flex gap-2 items-center rounded-full bg-[#171717] text-white px-4 py-2.5 text-xs font-bold hover:bg-[#383838]"><i class="ph ph-arrow-square-out text-base"></i> Web Publik</a>
            </header>

            @if(session('success'))
                <div class="soft-panel px-5 py-4 mb-6 text-sm font-semibold flex items-center gap-2"><i class="ph ph-check-circle text-xl"></i>{{ session('success') }}</div>
            @endif
            @if($errors->any())
                <div class="soft-panel px-5 py-4 mb-6 text-sm text-red-700">{{ $errors->first() }}</div>
            @endif

            <div class="grid grid-cols-1 sm:grid-cols-3 gap-3 mb-4">
                <div class="bg-[#181818] text-white rounded-[18px] p-5 min-h-40 flex flex-col justify-between">
                    <div class="flex justify-between gap-3"><p class="text-[11px] text-gray-300 font-semibold">Anggota terverifikasi</p><i class="ph ph-users-three text-xl"></i></div>
                    <div><p class="text-4xl font-extrabold tracking-tight">{{ $totalApprovedMembers ?? 0 }}</p><p class="text-[11px] text-gray-400 mt-1">Anggota aktif</p></div>
                </div>
                <div class="soft-panel p-5 min-h-40 flex flex-col justify-between">
                    <div class="flex justify-between gap-3"><p class="text-[11px] text-gray-500 font-semibold">Menunggu persetujuan</p><i class="ph ph-clock text-xl"></i></div>
                    <div><p class="text-4xl font-extrabold tracking-tight">{{ count($pendingMembers ?? []) }}</p><p class="text-[11px] text-gray-500 mt-1">Perlu ditinjau pengurus</p></div>
                </div>
                <div class="soft-panel p-5 min-h-40 flex flex-col justify-between">
                    <div class="flex justify-between gap-3"><p class="text-[11px] text-gray-500 font-semibold">Berita terpublikasi</p><i class="ph ph-newspaper text-xl"></i></div>
                    <div><p class="text-4xl font-extrabold tracking-tight">{{ $totalNews ?? 0 }}</p><p class="text-[11px] text-gray-500 mt-1">Berita & agenda</p></div>
                </div>
            </div>

            <div class="grid grid-cols-1 xl:grid-cols-[1.6fr_1fr] gap-4 mb-4">
                <section class="soft-panel p-5 sm:p-6">
                    <div class="flex items-center justify-between gap-4 mb-5"><div><h2 class="text-sm font-extrabold">Pendaftaran terbaru</h2><p class="text-[11px] text-gray-500 mt-1">Verifikasi data calon anggota</p></div><a href="{{ route('admin.members.index') }}" class="text-xs font-bold underline underline-offset-4 whitespace-nowrap">Lihat semua</a></div>
                    <div class="space-y-3">
                        @forelse($pendingMembers ?? [] as $member)
                            <div class="border-b border-[#eeeeeb] pb-3 last:border-b-0 last:pb-0 flex flex-wrap sm:flex-nowrap items-center gap-3">
                                <div class="w-9 h-9 rounded-full bg-[#ededeb] grid place-items-center text-xs font-bold shrink-0">{{ mb_strtoupper(mb_substr($member->name, 0, 1)) }}</div>
                                <div class="flex-1 min-w-[130px]"><p class="text-xs font-bold truncate">{{ $member->name }}</p><p class="text-[11px] text-gray-500">{{ $member->banom }} · {{ $member->phone ?? 'Nomor belum ada' }}</p></div>
                                <div class="flex items-center gap-2">
                                    <form method="POST" action="{{ route('admin.members.approve', $member->id) }}">@csrf @method('PATCH')<button type="submit" class="bg-[#171717] text-white px-3 py-2 rounded-lg text-[11px] font-bold">ACC</button></form>
                                    <form method="POST" action="{{ route('admin.members.reject', $member->id) }}" onsubmit="return confirm('Tolak pendaftaran anggota ini?')">@csrf @method('DELETE')<button type="submit" class="border border-[#dededb] px-3 py-2 rounded-lg text-[11px] font-bold">Tolak</button></form>
                                </div>
                            </div>
                        @empty
                            <div class="py-8 text-center text-gray-500"><i class="ph ph-check-circle text-3xl"></i><p class="text-xs mt-2">Belum ada pendaftaran yang menunggu.</p></div>
                        @endforelse
                    </div>
                </section>
                <section class="soft-panel p-5 sm:p-6 flex flex-col">
                    <h2 class="text-sm font-extrabold">Akses cepat</h2><p class="text-[11px] text-gray-500 mt-1 mb-5">Kelola layanan utama ranting</p>
                    <div class="space-y-2">
                        <a href="{{ route('admin.members.index') }}" class="flex items-center justify-between border border-[#ebebe8] rounded-xl p-3 text-xs font-bold hover:bg-[#f7f7f5]">Kelola anggota <i class="ph ph-arrow-up-right"></i></a>
                        <a href="{{ route('admin.news.index') }}" class="flex items-center justify-between border border-[#ebebe8] rounded-xl p-3 text-xs font-bold hover:bg-[#f7f7f5]">Kelola berita <i class="ph ph-arrow-up-right"></i></a>
                        <a href="{{ route('admin.infaq.index') }}" class="flex items-center justify-between border border-[#ebebe8] rounded-xl p-3 text-xs font-bold hover:bg-[#f7f7f5]">Kelola infak / kas <i class="ph ph-arrow-up-right"></i></a>
                    </div>
                    <p class="text-[11px] text-gray-400 mt-auto pt-6">Statistik diperbarui berdasarkan data yang tersedia di sistem.</p>
                </section>
            </div>
            <form action="{{ route('logout') }}" method="POST" class="lg:hidden mt-6">@csrf<button type="submit" class="text-xs font-bold underline">Keluar dari akun admin</button></form>
        </main>
    </div>
</body>
</html>
