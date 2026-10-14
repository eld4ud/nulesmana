<!DOCTYPE html>
<html lang="id" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Akun Anggota') - Ranting NU Lesmana</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Bebas+Neue&family=DM+Sans:ital,opsz,wght@0,9..40,100..1000;1,9..40,100..1000&display=swap" rel="stylesheet">
    <script src="https://unpkg.com/@phosphor-icons/web"></script>
    <style>
        body { font-family: 'DM Sans', sans-serif; }
        .font-display { font-family: 'Bebas Neue', sans-serif; font-weight: 400; letter-spacing: .02em; }
        [x-cloak] { display: none !important; }
    </style>
</head>
<body class="bg-[#d5f028] text-gray-900 min-h-screen relative overflow-x-hidden selection:bg-green-900 selection:text-white">

    <x-site-navbar />

    <main class="max-w-7xl mx-auto px-4 sm:px-6 pt-24 sm:pt-28 pb-12 sm:pb-16">
        @yield('content')
    </main>

    <footer class="bg-gray-900 text-white py-6 sm:py-8 text-center text-xs font-semibold">
        <p>© 2026 Pengurus Ranting NU Lesmana. All rights reserved.</p>
    </footer>

    @stack('scripts')

</body>
</html>
