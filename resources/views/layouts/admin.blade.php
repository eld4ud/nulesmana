<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'Panel Admin') | NU Lesmana</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Amiri:wght@400;700&family=Bebas+Neue&family=DM+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <script src="https://unpkg.com/@phosphor-icons/web"></script>
    <style>
        body {font-family:'DM Sans',sans-serif;background:#eaeae8;color:#181818}
        .font-arabic {font-family:'Amiri',serif;font-weight:400}
        .font-display {font-family:'Bebas Neue',sans-serif;letter-spacing:.02em}
        .admin-link {display:flex;align-items:center;gap:.75rem;padding:.8rem 1rem;border-radius:12px;font-size:.875rem;font-weight:700;transition:background .2s,color .2s;white-space:nowrap}
        .admin-link:hover {background:#efefed}
        .admin-link[aria-current="page"] {background:#181818;color:#fff}
        .admin-panel {background:#fff;border:1px solid #e5e5e2;border-radius:18px}
    </style>
    @stack('styles')
</head>
<body class="min-h-screen p-3 sm:p-5">
    <div class="max-w-[1500px] mx-auto min-h-[calc(100vh-40px)] bg-[#f7f7f5] border border-[#dededb] rounded-[24px] overflow-hidden flex flex-col lg:flex-row">
        <aside class="lg:w-[235px] shrink-0 bg-white border-b lg:border-b-0 lg:border-r border-[#e7e7e4] p-5 lg:p-6 flex flex-col">
            <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-3 mb-6 lg:mb-10">
                <span class="w-10 h-10 bg-[#181818] text-white rounded-xl grid place-items-center text-xl"><i class="ph ph-globe-hemisphere-west"></i></span>
                <span class="leading-tight"><strong class="block text-sm tracking-tight">NU LESMANA</strong><small class="text-[10px] text-gray-500 tracking-widest">ADMIN PANEL</small></span>
            </a>
            <p class="hidden lg:block text-[10px] font-bold text-gray-400 tracking-widest uppercase mb-3 px-3">Navigasi</p>
            <nav aria-label="Navigasi admin" class="flex lg:flex-col gap-1 overflow-x-auto pb-2 lg:pb-0">
                <a class="admin-link" href="{{ route('admin.dashboard') }}" @if(request()->routeIs('admin.dashboard')) aria-current="page" @endif><i class="ph ph-squares-four text-lg"></i>Dashboard</a>
                <a class="admin-link" href="{{ route('admin.members.index') }}" @if(request()->routeIs('admin.members.*')) aria-current="page" @endif><i class="ph ph-users-three text-lg"></i>Kelola Anggota</a>
                <a class="admin-link" href="{{ route('admin.news.index') }}" @if(request()->routeIs('admin.news.*')) aria-current="page" @endif><i class="ph ph-newspaper text-lg"></i>Kelola Berita</a>
                <a class="admin-link" href="{{ route('admin.infaq.index') }}" @if(request()->routeIs('admin.infaq.*')) aria-current="page" @endif><i class="ph ph-wallet text-lg"></i>Infak / Kas</a>
                @if(Route::has('admin.feedback.index'))
                    <a class="admin-link" href="{{ route('admin.feedback.index') }}" @if(request()->routeIs('admin.feedback.*')) aria-current="page" @endif><i class="ph ph-chat-centered-text text-lg"></i>Kotak Saran</a>
                @endif
            </nav>
            <div class="lg:mt-auto pt-5 lg:pt-10 border-t border-[#ededeb] mt-5 lg:border-t-0">
                <p class="text-xs font-bold truncate">{{ auth()->user()?->name ?? 'Administrator' }}</p>
                <p class="text-[11px] text-gray-500 mb-3">Pengurus NU Lesmana</p>
                <form action="{{ route('logout') }}" method="POST">@csrf
                    <button type="submit" class="text-xs font-bold flex items-center gap-2 text-gray-600 hover:text-black"><i class="ph ph-sign-out text-lg"></i>Keluar</button>
                </form>
            </div>
        </aside>
        <main class="min-w-0 flex-1 px-4 py-6 sm:p-8 lg:p-10">
            <header class="flex flex-wrap items-start justify-between gap-4 mb-8">
                <div>
                    <p class="text-[10px] uppercase tracking-[.18em] text-gray-500 font-bold mb-2">Panel Pengurus / NU Lesmana</p>
                    @if(request()->routeIs('admin.dashboard'))
                        <p lang="ar" dir="rtl" class="font-arabic text-[1.8rem] sm:text-[2.2rem] leading-relaxed text-[#222] mb-1" style="text-align:left">السَّلَامُ عَلَيْكُمْ وَرَحْمَةُ اللَّهِ وَبَرَكَاتُهُ</p>
                        <p class="text-xs text-gray-500 mb-2">Assalamu'alaikum, {{ auth()->user()?->name ?? 'Admin' }}. Selamat datang kembali.</p>
                    @endif
                    <h1 class="text-2xl sm:text-3xl font-extrabold tracking-tight">@yield('heading', 'Dashboard')</h1>
                    <p class="text-sm text-gray-500 mt-1">@yield('subtitle', 'Pengelolaan layanan dan informasi warga')</p>
                </div>
                <a href="{{ route('home') }}" target="_blank" rel="noopener noreferrer" class="inline-flex items-center gap-2 rounded-full bg-[#181818] text-white px-4 py-2.5 text-xs font-bold hover:bg-[#333]"><i class="ph ph-arrow-square-out text-base"></i>Lihat Website</a>
            </header>
            @if(session('success'))
                <div role="status" class="admin-panel px-5 py-4 mb-5 text-sm font-semibold">{{ session('success') }}</div>
            @endif
            @if($errors->any())
                <div role="alert" class="admin-panel px-5 py-4 mb-5 text-sm text-red-700">{{ $errors->first() }}</div>
            @endif
            @yield('content')
        </main>
    </div>
    @stack('scripts')
</body>
</html>
