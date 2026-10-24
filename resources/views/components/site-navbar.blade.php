@php
    $user = auth()->user();
    $isAdmin = $user && $user->role === 'admin';
    $isApprovedMember = $user && $user->role === 'member' && $user->status === 'approved';
    $home = route('home');
    $initial = $user ? mb_strtoupper(mb_substr($user->name, 0, 1)) : '';
    if ($isAdmin) {
        $cekKartuUrl = route('admin.members.index');
    } elseif ($isApprovedMember) {
        $cekKartuUrl = route('member.kia');
    } elseif ($user && $user->role === 'member') {
        $cekKartuUrl = $home;
    } else {
        $cekKartuUrl = route('member.signup');
    }
    $links = [
        ['Berita & Agenda', route('public.news.index')],
        ['Struktur Organisasi', route('struktur.banom')],
        ['Cek Kartu', $cekKartuUrl],
        ['Kotak Saran', $home . '#saran'],
    ];
    $memberMenu = [
        ['Dashboard Saya', 'member.dashboard', 'ph-squares-four'],
        ['Lihat KIA Saya', 'member.kia', 'ph-identification-card'],
        ['Data Saya', 'member.data', 'ph-user'],
        ['Infaq Anggota', 'member.infaq', 'ph-hand-coins'],
        ['Notifikasi', 'member.notifikasi', 'ph-bell'],
        ['Pengaturan', 'member.pengaturan', 'ph-gear'],
    ];
@endphp
<style>
    .nu-navbar details>summary{list-style:none}
    .nu-navbar details>summary::-webkit-details-marker{display:none}
    .nu-navbar a,.nu-navbar button,.nu-navbar summary{-webkit-tap-highlight-color:transparent}
    .nu-navbar .nav-link{position:relative}
    .nu-navbar .nav-link::after{content:"";position:absolute;left:0;right:100%;bottom:-5px;height:1px;background:#183C2F;transition:right .2s ease}
    .nu-navbar .nav-link:hover::after,.nu-navbar .nav-link:focus-visible::after{right:0}
    .nu-navbar .nu-brandmark{width:43px;height:43px;display:grid;place-items:center;flex-shrink:0;background:#183C2F;border-radius:13px;color:white}
    .nu-navbar .nu-brandmark svg{display:block;width:30px;height:30px}
    .nu-navbar details[open]>summary{background:#F0F3EF}
    .nu-navbar a:focus-visible,.nu-navbar button:focus-visible,.nu-navbar summary:focus-visible{outline:2px solid #183C2F;outline-offset:3px}
    @media(prefers-reduced-motion:reduce){.nu-navbar *{transition:none!important}}
</style>
<header class="nu-navbar fixed inset-x-0 top-4 z-50 px-4 sm:top-6">
    <nav class="mx-auto flex w-full max-w-6xl items-center gap-3 rounded-full border border-stone-200 bg-white/95 px-3 py-2 text-stone-950 shadow-[0_10px_32px_rgba(25,35,29,.08)] backdrop-blur-lg sm:px-5" aria-label="Navigasi utama">
        <div class="flex shrink-0 items-center gap-2">
            @auth
                <details class="group relative">
                    <summary class="flex cursor-pointer items-center gap-2 rounded-full border border-stone-200 bg-stone-50 py-1 pl-1 pr-3 transition hover:bg-stone-100" aria-label="Buka menu akun">
                        <span class="flex h-9 w-9 items-center justify-center rounded-full bg-[#183C2F] text-sm font-bold text-white">{{ $initial }}</span>
                        <span class="hidden max-w-24 truncate text-xs font-bold sm:inline">{{ $user->name }}</span>
                        <i class="ph ph-caret-down text-xs text-stone-500" aria-hidden="true"></i>
                    </summary>
                    <div class="absolute left-0 top-full mt-3 w-64 overflow-hidden rounded-2xl border border-stone-200 bg-white p-2 shadow-xl">
                        <div class="border-b border-stone-100 px-3 py-3">
                            <p class="truncate text-sm font-bold text-stone-900">{{ $user->name }}</p>
                            <p class="truncate text-xs text-stone-500">{{ $user->email }}</p>
                        </div>
                        @if($isAdmin)
                            <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-2 rounded-lg px-3 py-2.5 text-sm transition hover:bg-stone-100"><i class="ph ph-squares-four" aria-hidden="true"></i>Panel Admin</a>
                            <a href="{{ route('admin.profile.edit') }}" class="flex items-center gap-2 rounded-lg px-3 py-2.5 text-sm transition hover:bg-stone-100"><i class="ph ph-gear" aria-hidden="true"></i>Pengaturan</a>
                        @else
                            @foreach($memberMenu as [$label, $routeName, $icon])
                                <a href="{{ route($routeName) }}" class="flex items-center gap-2 rounded-lg px-3 py-2.5 text-sm transition hover:bg-stone-100"><i class="ph {{ $icon }}" aria-hidden="true"></i>{{ $label }}</a>
                            @endforeach
                        @endif
                        <form method="POST" action="{{ route('logout') }}" class="mt-1 border-t border-stone-100 pt-1">
                            @csrf
                            <button type="submit" class="flex w-full items-center gap-2 rounded-lg px-3 py-2.5 text-left text-sm text-red-700 transition hover:bg-red-50"><i class="ph ph-sign-out" aria-hidden="true"></i>Keluar</button>
                        </form>
                    </div>
                </details>
            @else
                <a href="{{ route('member.login') }}" class="rounded-full px-3 py-2 text-xs font-bold text-stone-900 transition hover:bg-stone-100">Login</a>
            @endauth
        </div>
        <div class="hidden min-w-0 flex-1 items-center justify-center gap-4 lg:flex xl:gap-7">
            @foreach($links as [$label, $href])
                <a href="{{ $href }}" class="nav-link whitespace-nowrap text-xs font-semibold text-stone-700 transition hover:text-[#183C2F]">{{ $label }}</a>
            @endforeach
        </div>
        <div class="ml-auto flex shrink-0 items-center gap-2 lg:ml-0">
            @guest
                <a href="{{ route('member.signup') }}" class="hidden rounded-full bg-[#183C2F] px-5 py-2.5 text-xs font-bold text-white transition hover:bg-[#275643] sm:inline-flex">Daftar Anggota</a>
            @endguest
            <a href="{{ $home }}" class="flex items-center gap-2" aria-label="Beranda NU Lesmana">
                <span class="hidden text-right sm:block">
                    <span class="block text-xs font-black leading-tight text-[#183C2F]">PRNU Lesmana</span>
                    <span class="block text-[9px] font-medium tracking-wide text-stone-500">PORTAL RESMI WARGA</span>
                </span>
                <span class="nu-brandmark">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 48 48" fill="none" role="img" aria-label="Monogram Nulesmana NL">
                        <path d="M8 34V14L22 34V14" stroke="currentColor" stroke-width="3.5" stroke-linecap="square" stroke-linejoin="miter"/>
                        <path d="M29 14V34H40" stroke="currentColor" stroke-width="3.5" stroke-linecap="square" stroke-linejoin="miter"/>
                        <path d="M8 40H40" stroke="currentColor" stroke-opacity=".45" stroke-width="1.25"/>
                    </svg>
                </span>
            </a>
            <details class="relative lg:hidden">
                <summary class="flex h-10 w-10 cursor-pointer items-center justify-center rounded-full border border-stone-200 text-[#183C2F]" aria-label="Buka navigasi"><i class="ph ph-list text-xl" aria-hidden="true"></i></summary>
                <div class="absolute right-0 top-full mt-3 w-64 rounded-2xl border border-stone-200 bg-white p-3 shadow-xl">
                    @foreach($links as [$label, $href])
                        <a href="{{ $href }}" class="block rounded-lg px-3 py-2.5 text-sm font-semibold transition hover:bg-stone-100">{{ $label }}</a>
                    @endforeach
                    @guest
                        <a href="{{ route('member.signup') }}" class="mt-2 block rounded-lg bg-[#183C2F] px-3 py-2.5 text-center text-sm font-bold text-white transition hover:bg-[#275643]">Daftar Anggota</a>
                    @endguest
                </div>
            </details>
        </div>
    </nav>
</header>
