@php
    $user    = auth()->user();
    $isAdmin = $user?->role === 'admin';
    $initial = $user ? \Illuminate\Support\Str::upper(\Illuminate\Support\Str::substr($user->name, 0, 1)) : '';
    $home    = route('home');

    $links = [
        ['Berita & Agenda',     $home.'#berita'],
        ['Struktur Organisasi', $home.'#struktur-banom'],
        ['Statistik Banom',     $home.'#statistik'],
        ['Cek Kartu NIA',       $home.'#cek-kartu'],
        ['Kotak Saran',         $home.'#saran'],
    ];

    $memberMenu = [
        ['Dashboard Saya', route('member.dashboard'),  'ph-squares-four'],
        ['Lihat KIA Saya', route('member.kia'),        'ph-identification-card'],
        ['Data Saya',      route('member.data'),       'ph-user'],
        ['Riwayat Infaq',  route('member.infaq'),      'ph-hand-coins'],
        ['Notifikasi',     route('member.notifikasi'), 'ph-bell'],
        ['Pengaturan',     route('member.pengaturan'), 'ph-gear'],
    ];
@endphp

<style>[x-cloak] { display: none !important; }</style>

<div x-data="{ mobile: false }">

    <!-- NAVBAR -->
    <nav class="fixed top-4 sm:top-6 left-1/2 -translate-x-1/2 w-[92%] max-w-6xl bg-stone-950/90 backdrop-blur-md text-white rounded-full px-4 sm:px-6 py-2.5 sm:py-3 flex justify-between items-center z-50 shadow-2xl border border-white/10">

        <!-- KIRI: profil (sudah login) atau Login/Daftar (belum login) -->
        <div class="flex items-center gap-3">
            @auth
                <div class="relative" x-data="{ open: false }" @keydown.escape.window="open = false">
                    <button type="button" @click="open = !open" :aria-expanded="open.toString()" aria-haspopup="menu"
                            class="flex items-center gap-2 bg-stone-900 border border-white/15 hover:border-lime-400 text-stone-200 px-3 py-1.5 rounded-full text-xs font-bold transition">
                        <div class="w-7 h-7 rounded-full bg-lime-400 text-stone-950 flex items-center justify-center font-black">{{ $initial }}</div>
                        <span class="hidden sm:inline-block max-w-[100px] truncate">{{ $user->name }}</span>
                        <i class="ph ph-caret-down text-xs transition-transform" :class="open && 'rotate-180'"></i>
                    </button>

                    <div x-show="open" x-cloak @click.outside="open = false" x-transition role="menu"
                         class="absolute left-0 mt-2 w-60 bg-stone-900 border border-white/10 rounded-2xl shadow-2xl py-2 z-50 text-xs font-semibold">
                        <div class="px-4 py-2 border-b border-white/10 text-stone-400">
                            <p class="text-[10px] uppercase tracking-wider">{{ $isAdmin ? 'Masuk sebagai admin' : 'Nomor Induk Anggota' }}</p>
                            <p class="text-white font-bold truncate {{ $isAdmin ? '' : 'font-mono text-lime-400' }}">
                                {{ $isAdmin ? $user->email : ($user->nia ?? 'Belum ada') }}
                            </p>
                        </div>

                        @if ($isAdmin)
                            <a href="{{ route('admin.dashboard') }}" role="menuitem" class="flex items-center gap-2.5 px-4 py-2 text-stone-200 hover:bg-stone-800 hover:text-lime-400 transition">
                                <i class="ph ph-squares-four text-base"></i> Panel Admin
                            </a>
                            <a href="{{ route('admin.profile.edit') }}" role="menuitem" class="flex items-center gap-2.5 px-4 py-2 text-stone-200 hover:bg-stone-800 hover:text-lime-400 transition">
                                <i class="ph ph-gear text-base"></i> Pengaturan
                            </a>
                        @else
                            @foreach ($memberMenu as [$label, $href, $icon])
                                <a href="{{ $href }}" role="menuitem" class="flex items-center gap-2.5 px-4 py-2 text-stone-200 hover:bg-stone-800 hover:text-lime-400 transition">
                                    <i class="ph {{ $icon }} text-base"></i> {{ $label }}
                                </a>
                            @endforeach

                            <div class="border-t border-white/10 my-1"></div>

                            <a href="{{ $home }}#saran" role="menuitem" class="flex items-center gap-2.5 px-4 py-2 text-stone-200 hover:bg-stone-800 hover:text-lime-400 transition">
                                <i class="ph ph-lifebuoy text-base"></i> Bantuan
                            </a>
                        @endif

                        <div class="border-t border-white/10 my-1"></div>

                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" role="menuitem" class="w-full flex items-center gap-2.5 text-left px-4 py-2 text-red-400 hover:bg-stone-800 transition">
                                <i class="ph ph-sign-out text-base"></i> Keluar
                            </button>
                        </form>
                    </div>
                </div>
            @else
                <div class="flex items-center gap-2">
                    <a href="{{ route('member.login') }}" class="text-xs font-bold text-stone-300 hover:text-lime-400 px-2 py-1 transition">Login</a>
                    <a href="{{ $home }}#daftar" class="bg-lime-400 hover:bg-lime-300 text-stone-950 px-3.5 py-1.5 rounded-full text-[11px] font-black transition shadow-md">Daftar</a>
                </div>
            @endauth
        </div>

        <!-- TENGAH: menu utama -->
        <div class="hidden md:flex items-center gap-6 font-bold text-stone-300 text-xs">
            @foreach ($links as [$label, $href])
                <a href="{{ $href }}" class="hover:text-white transition">{{ $label }}</a>
            @endforeach
        </div>

        <!-- KANAN: logo -->
        <div class="flex items-center">
            <a href="{{ $home }}" class="flex items-center gap-2.5 sm:gap-3 pr-1">
                <div class="flex-col text-right hidden sm:flex">
                    <span class="font-black text-xs sm:text-sm tracking-tight text-white leading-none">PRNU <span class="text-lime-400">Lesmana</span></span>
                    <span class="text-[8px] sm:text-[9px] font-semibold text-stone-400 uppercase tracking-widest mt-0.5">Portal Resmi Warga</span>
                </div>
                <div class="w-8 h-8 sm:w-10 sm:h-10 bg-white rounded-full flex items-center justify-center text-stone-950 font-black shadow-md shrink-0">
                    <i class="ph ph-globe-hemisphere-west text-lg sm:text-xl"></i>
                </div>
            </a>
            <button type="button" @click="mobile = !mobile" class="md:hidden text-white text-2xl p-1.5 focus:outline-none ml-2" aria-label="Buka menu">
                <i class="ph" :class="mobile ? 'ph-x' : 'ph-list'"></i>
            </button>
        </div>
    </nav>

    <!-- MENU MOBILE -->
    <div x-show="mobile" x-cloak x-transition
         class="fixed top-20 left-1/2 -translate-x-1/2 w-[92%] bg-stone-950/95 text-white rounded-3xl p-6 shadow-2xl border border-white/10 z-40 md:hidden flex flex-col gap-4 font-bold text-sm backdrop-blur-lg">
        @foreach ($links as [$label, $href])
            <a href="{{ $href }}" @click="mobile = false" class="hover:text-lime-400 transition py-1 border-b border-white/10">{{ $label }}</a>
        @endforeach

        @auth
            <a href="{{ $isAdmin ? route('admin.dashboard') : route('member.dashboard') }}" class="text-lime-400 py-1 font-bold">
                {{ $isAdmin ? 'Panel Admin' : 'Dashboard Saya' }}
            </a>
        @else
            <a href="{{ route('member.login') }}" class="text-lime-400 py-1 font-bold">Login Anggota</a>
        @endauth
    </div>
</div>
