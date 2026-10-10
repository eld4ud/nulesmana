<!DOCTYPE html>
<html lang="id" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Admin - Ranting NU Lesmana</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Comfortaa:wght@300;400;500;700&display=swap" rel="stylesheet">
    <script src="https://unpkg.com/@phosphor-icons/web"></script>
    <style>
        :root { --navy: #14112b; --lav: #b7b5cf; }
        body { font-family: 'Comfortaa', sans-serif; color: var(--navy); }
        input::placeholder { font-weight: 300; font-size: .75rem; color: #8b88a6; }

        @keyframes fadeUp { from { opacity: 0; transform: translateY(16px); } to { opacity: 1; transform: translateY(0); } }
        .fade-up { opacity: 0; animation: fadeUp .7s cubic-bezier(.2,.7,.2,1) forwards; }
        .d1 { animation-delay: .05s; } .d2 { animation-delay: .15s; } .d3 { animation-delay: .25s; }
        .d4 { animation-delay: .35s; } .d5 { animation-delay: .45s; }

        @keyframes twinkle { 0%,100% { opacity: .9; } 50% { opacity: .25; } }
        .twinkle { animation: twinkle 3s ease-in-out infinite; }
        .twinkle:nth-child(2n) { animation-delay: -1s; }
        .twinkle:nth-child(3n) { animation-delay: -2s; }

        @keyframes floaty { 0%,100% { transform: translateY(0); } 50% { transform: translateY(-8px); } }
        .floaty { animation: floaty 7s ease-in-out infinite; }

        @media (prefers-reduced-motion: reduce) {
            .fade-up { opacity: 1; animation: none; }
            .twinkle, .floaty { animation: none; }
        }
    </style>
</head>
<body class="min-h-screen bg-[#b7b5cf] flex items-center justify-center p-4 sm:p-8">

<div class="w-full max-w-5xl bg-white rounded-[2rem] shadow-sm border border-white/60 grid lg:grid-cols-2 overflow-hidden">

    <!-- ============ KIRI: FORM ============ -->
    <section class="relative px-8 sm:px-14 py-10 sm:py-12 flex flex-col min-h-[560px]">

        <!-- logo -->
        <a href="{{ url('/') }}" class="fade-up d1 self-start">
            <span class="block text-sm font-bold tracking-tight">PRNU Lesmana</span>
            <svg width="76" height="14" viewBox="0 0 76 14" fill="none" aria-hidden="true"><path d="M2 12 Q38 -3 74 8" stroke="#14112b" stroke-width="2" stroke-linecap="round"/></svg>
        </a>

        <div class="flex-1 flex flex-col justify-center py-8">
            <div class="w-full max-w-xs mx-auto">

                <h1 class="fade-up d2 flex items-center justify-center gap-2 text-3xl sm:text-4xl font-light tracking-tight text-center">
                    <i class="ph ph-sparkle text-xl"></i> Selamat datang
                </h1>
                <p class="fade-up d2 text-[11px] font-light text-center text-[#6c6988] mt-2">Masuk sebagai pengurus untuk mengelola berita & anggota.</p>

                @if (session('status'))
                    <p class="mt-5 text-[11px] text-center font-bold text-green-800">{{ session('status') }}</p>
                @endif

                <form method="POST" action="{{ route('login') }}" class="mt-8 space-y-4">
                    @csrf

                    <!-- email -->
                    <div class="fade-up d3">
                        <div class="relative">
                            <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus autocomplete="username" placeholder="email"
                                   class="w-full bg-transparent border {{ $errors->has('email') ? 'border-red-500' : 'border-[#14112b]' }} rounded-full pl-5 pr-12 py-3 text-sm font-light outline-none transition focus:ring-4 focus:ring-[#b7b5cf]/60">
                            <i class="ph ph-user absolute right-5 top-1/2 -translate-y-1/2 text-base"></i>
                        </div>
                        @error('email')
                            <p class="text-[11px] font-bold text-red-600 mt-1.5 pl-4">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- password -->
                    <div class="fade-up d3">
                        <div class="relative">
                            <input id="password" type="password" name="password" required autocomplete="current-password" placeholder="password"
                                   class="w-full bg-transparent border {{ $errors->has('password') ? 'border-red-500' : 'border-[#14112b]' }} rounded-full pl-5 pr-12 py-3 text-sm font-light outline-none transition focus:ring-4 focus:ring-[#b7b5cf]/60">
                            <button type="button" onclick="togglePassword()" class="absolute right-5 top-1/2 -translate-y-1/2" aria-label="Tampilkan sandi">
                                <i id="keyIcon" class="ph ph-key text-base"></i>
                            </button>
                        </div>
                        @error('password')
                            <p class="text-[11px] font-bold text-red-600 mt-1.5 pl-4">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- ingat saya -->
                    <label for="remember_me" class="fade-up d4 flex items-center gap-2 pl-2 cursor-pointer select-none">
                        <input id="remember_me" type="checkbox" name="remember" class="w-3.5 h-3.5 rounded border-[#14112b] accent-[#14112b]">
                        <span class="text-[11px] font-light">ingat saya</span>
                    </label>

                    <!-- lupa sandi + tombol -->
                    <div class="fade-up d4 flex items-center justify-between gap-4 pt-1">
                        @if (Route::has('password.request'))
                            <a href="{{ route('password.request') }}" class="text-[11px] font-light hover:underline">oops, lupa sandi?</a>
                        @else
                            <span class="text-[11px] font-light text-[#8b88a6]">khusus pengurus</span>
                        @endif
                        <button type="submit" class="bg-[#14112b] text-white text-xs font-medium rounded-full px-9 py-3 hover:bg-[#2c2850] transition shadow-lg shadow-[#14112b]/20">
                            Masuk
                        </button>
                    </div>
                </form>

                <!-- bawah -->
                <div class="fade-up d5 mt-10 flex items-center justify-center gap-3 text-[11px] font-light">
                    <span>bukan admin? kembali ke</span>
                    <a href="{{ url('/') }}" class="w-6 h-6 rounded-full border border-[#14112b] flex items-center justify-center text-xs hover:bg-[#14112b] hover:text-white transition" aria-label="Beranda">
                        <i class="ph ph-house"></i>
                    </a>
                </div>
            </div>
        </div>
    </section>

    <!-- ============ KANAN: ILUSTRASI (bentuk squircle) ============ -->
    <section class="hidden lg:flex items-center justify-center p-8">
        <svg viewBox="0 0 500 500" class="floaty w-full max-w-[460px]" role="img" aria-label="Ilustrasi masjid di bawah bulan">
            <defs>
                <clipPath id="shape">
                    <path d="M120 30 Q150 10 190 18 L440 80 Q480 95 485 135 L490 330 Q492 360 470 385 L270 480 Q235 495 205 470 L40 330 Q10 300 18 260 L60 70 Q70 40 120 30 Z"/>
                </clipPath>
                <linearGradient id="sky" x1="0" y1="0" x2="0" y2="1">
                    <stop offset="0" stop-color="#2a2645"/>
                    <stop offset="1" stop-color="#4b4570"/>
                </linearGradient>
                <pattern id="grain" width="6" height="6" patternUnits="userSpaceOnUse">
                    <circle cx="1.5" cy="1.5" r="1" fill="#ffffff" opacity=".14"/>
                    <circle cx="4.5" cy="4.5" r=".8" fill="#ffffff" opacity=".08"/>
                </pattern>
            </defs>

            <g clip-path="url(#shape)">
                <rect width="500" height="500" fill="url(#sky)"/>
                <rect width="500" height="500" fill="url(#grain)"/>

                <!-- bintang -->
                <g fill="#ffffff">
                    <circle class="twinkle" cx="90"  cy="90"  r="2"/>
                    <circle class="twinkle" cx="160" cy="60"  r="1.6"/>
                    <circle class="twinkle" cx="230" cy="110" r="2.2"/>
                    <circle class="twinkle" cx="340" cy="70"  r="1.8"/>
                    <circle class="twinkle" cx="410" cy="130" r="2"/>
                    <circle class="twinkle" cx="60"  cy="190" r="1.6"/>
                    <circle class="twinkle" cx="440" cy="210" r="1.8"/>
                    <circle class="twinkle" cx="120" cy="150" r="1.4"/>
                    <circle class="twinkle" cx="380" cy="40"  r="1.4"/>
                </g>

                <!-- bulan -->
                <circle cx="260" cy="300" r="125" fill="#ebe9f7"/>
                <circle cx="215" cy="250" r="16" fill="#d9d6ee"/>
                <circle cx="300" cy="275" r="10" fill="#d9d6ee"/>
                <circle cx="285" cy="345" r="20" fill="#d9d6ee"/>
                <circle cx="225" cy="330" r="8"  fill="#d9d6ee"/>

                <!-- siluet masjid -->
                <g fill="#1d1a33">
                    <rect x="165" y="300" width="14" height="130"/>
                    <path d="M161 300 L172 262 L183 300 Z"/>
                    <rect x="345" y="300" width="14" height="130"/>
                    <path d="M341 300 L352 262 L363 300 Z"/>
                    <rect x="190" y="385" width="140" height="60"/>
                    <path d="M196 385 Q260 285 324 385 Z"/>
                    <rect x="259" y="300" width="2.5" height="22"/>
                </g>
                <circle cx="260" cy="290" r="9" fill="#1d1a33"/>
                <circle cx="264" cy="288" r="8" fill="#ebe9f7"/>

                <!-- bukit -->
                <path d="M0 410 Q120 360 250 400 T500 390 V500 H0 Z" fill="#2d2946"/>
                <path d="M0 410 Q120 360 250 400 T500 390 V500 H0 Z" fill="url(#grain)"/>
                <path d="M0 455 Q150 418 300 450 T500 436 V500 H0 Z" fill="#211e38"/>
                <path d="M0 455 Q150 418 300 450 T500 436 V500 H0 Z" fill="url(#grain)"/>
            </g>
        </svg>
    </section>
</div>

<script>
    function togglePassword() {
        const input = document.getElementById('password');
        const icon = document.getElementById('keyIcon');
        const show = input.type === 'password';
        input.type = show ? 'text' : 'password';
        icon.className = show ? 'ph ph-eye text-base' : 'ph ph-key text-base';
    }
</script>

</body>
</html>