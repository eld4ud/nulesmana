
<!DOCTYPE html>
<html lang="id" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="theme-color" content="#F5F4F0">
    <title>@yield('title', 'Akun Anggota') - Ranting NU Lesmana</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Amiri:wght@400;700&family=Bebas+Neue&family=DM+Sans:ital,opsz,wght@0,9..40,100..1000;1,9..40,100..1000&display=swap" rel="stylesheet">
    <script src="https://unpkg.com/@phosphor-icons/web"></script>
    <style>
        :root {
            --nu-ivory: #F5F4F0;
            --nu-green: #183C2F;
            --nu-black: #171717;
        }
        html {
            scroll-behavior: smooth;
        }
        body {
            margin: 0;
            font-family: 'DM Sans', sans-serif;
            background: var(--nu-ivory);
            color: var(--nu-black);
        }
        .font-display {
            font-family: 'Bebas Neue', sans-serif;
            font-weight: 400;
            letter-spacing: .02em;
        }
        .font-arabic {
            font-family: 'Amiri', serif;
        }
        [x-cloak] {
            display: none !important;
        }
        .nu-page-enter,
        .nu-footer-enter {
            opacity: 1 !important;
            visibility: visible !important;
            animation: none !important;
            transform: none !important;
            filter: none !important;
        }
        @media (prefers-reduced-motion: reduce) {
            html {
                scroll-behavior: auto !important;
            }
            .nu-page-enter,
            .nu-footer-enter {
                animation: none !important;
                transition: none !important;
            }
        }
    </style>
    @stack('styles')
</head>
<body class="min-h-screen flex flex-col relative overflow-x-hidden selection:bg-[#183C2F] selection:text-white">
    <x-site-navbar />
    <main class="nu-page-enter flex-1 w-full max-w-7xl mx-auto px-4 sm:px-6 pt-24 sm:pt-28 pb-12 sm:pb-16">
        @yield('content')
    </main>
    <footer class="nu-footer-enter bg-[#183C2F] text-white py-7 sm:py-9 text-center px-4">
        <p class="text-xs font-semibold tracking-wide">© {{ date('Y') }} Pengurus Ranting NU Lesmana. All rights reserved.</p>
    </footer>
    @stack('scripts')
</body>
</html>
