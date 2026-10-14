
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>@yield('title', 'Portal Ranting NU Pasiraman Lor')</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <script src="https://unpkg.com/@phosphor-icons/web"></script>

    <style>
        body {
            font-family: 'DM Sans', sans-serif;
        }
    </style>
</head>

<body class="min-h-screen bg-[#d5f028] text-gray-900">

    <header class="px-4 pt-5">
        <nav class="mx-auto flex max-w-6xl items-center justify-between rounded-full border border-white/10 bg-stone-950 px-5 py-4 text-white shadow-xl">
            <a href="{{ route('home') }}" class="flex items-center gap-3">
                <span class="flex h-10 w-10 items-center justify-center rounded-full bg-white text-xl text-green-900">
                    <i class="ph ph-globe-hemisphere-west"></i>
                </span>

                <span>
                    <span class="block text-sm font-extrabold">
                        PRNU <span class="text-lime-400">Pasiraman Lor</span>
                    </span>
                    <span class="block text-[10px] text-stone-400">
                        Portal Resmi Warga
                    </span>
                </span>
            </a>

            <div class="flex items-center gap-4 text-xs font-bold sm:gap-6">
                <a href="{{ route('home') }}" class="hover:text-lime-400">
                    Beranda
                </a>

                <a href="{{ route('public.news.index') }}" class="hover:text-lime-400">
                    Berita
                </a>

                <a href="{{ route('login') }}" class="hidden hover:text-lime-400 sm:inline">
                    Login Admin
                </a>
            </div>
        </nav>
    </header>

    <main class="mx-auto min-h-[70vh] max-w-6xl px-4 py-8 sm:py-12">
        @if(session('success'))
            <div class="mb-6 rounded-xl bg-green-900 p-4 text-sm font-bold text-white">
                {{ session('success') }}
            </div>
        @endif

        @yield('content')
    </main>

    <footer class="mt-8 bg-stone-950 px-4 py-8 text-center text-sm text-stone-300">
        <p class="font-bold text-white">
            Ranting NU Pasiraman Lor
        </p>
        <p class="mt-2 text-xs">
            Portal informasi berita dan kegiatan warga.
        </p>
        <p class="mt-4 text-[11px] text-stone-500">
            &copy; {{ date('Y') }} Ranting NU Pasiraman Lor
        </p>
    </footer>

</body>
</html>
