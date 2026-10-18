<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Berita & Agenda - Nulesmana')</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Bebas+Neue&family=DM+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <script src="https://unpkg.com/@phosphor-icons/web"></script>
    <style>
        :root { --forest: #183C2F; --ivory: #F5F4F0; }
        html { scroll-behavior: smooth; }
        body { margin: 0; min-height: 100vh; background: var(--ivory); color: var(--forest); font-family: 'DM Sans', sans-serif; overflow-x: hidden; }
        .font-display { font-family: 'Bebas Neue', sans-serif; }
        ::selection { background: var(--forest); color: white; }
    </style>
    @stack('styles')
</head>
<body>
    {{-- Halaman berita mengelola header sendiri agar tidak ada navbar ganda. --}}
    @if(session('success'))
        <div class="mx-auto w-full max-w-[1600px] px-5 pt-5 sm:px-8 lg:px-12" role="status">
            <div class="rounded-xl bg-[#183C2F] px-5 py-4 text-sm font-semibold text-white">
                {{ session('success') }}
            </div>
        </div>
    @endif
    <main class="min-h-screen w-full">
        @yield('content')
    </main>
    @stack('scripts')
</body>
</html>
