
@extends('layouts.member')

@section('title', 'Profil Saya')

@section('content')

@php
    $initial = strtoupper(substr($user->name ?? 'A', 0, 1));

    $status = $user->status ?? 'pending';

    $nia = $user->nia ?? null;

    $maskedNia = $nia
        ? str_repeat('•', max(strlen($nia) - 4, 0)) . substr($nia, -4)
        : 'Belum tersedia';

    $menus = [
        [
            'title' => 'Kartu Identitas Anggota',
            'description' => 'Lihat kartu digital dan informasi KIA Anda.',
            'route' => 'member.kia',
            'icon' => 'ph-identification-card',
        ],
        [
            'title' => 'Data Keanggotaan',
            'description' => 'Periksa informasi pribadi dan data anggota.',
            'route' => 'member.data',
            'icon' => 'ph-user-circle',
        ],
        [
            'title' => 'Riwayat Infaq',
            'description' => 'Lihat riwayat kontribusi dan infaq Anda.',
            'route' => 'member.infaq',
            'icon' => 'ph-wallet',
        ],
        [
            'title' => 'Notifikasi',
            'description' => 'Informasi terbaru terkait akun dan kegiatan.',
            'route' => 'member.notifikasi',
            'icon' => 'ph-bell',
        ],
        [
            'title' => 'Pengaturan Akun',
            'description' => 'Kelola informasi dan keamanan akun Anda.',
            'route' => 'member.pengaturan',
            'icon' => 'ph-gear',
        ],
    ];
@endphp

<style>
    .profile-page {
        font-family: 'DM Sans', sans-serif;
        color: #18181b;
    }

    .profile-card {
        background: #fff;
        border: 1px solid #e9e9ee;
        border-radius: 18px;
        box-shadow: 0 5px 22px rgba(20,20,30,.035);
        overflow: hidden;
    }

    .profile-muted {
        color: #777783;
    }

    .profile-accent {
        color: #6754d8;
    }

    .profile-link:hover {
        background: #f8f7ff;
    }

    .profile-menu-icon {
        width: 46px;
        height: 46px;
        border-radius: 13px;
        display: flex;
        align-items: center;
        justify-content: center;
        background: #f3f1ff;
        color: #6754d8;
        font-size: 23px;
        flex-shrink: 0;
    }
</style>

<div class="profile-page max-w-7xl mx-auto pb-12">

    {{-- PAGE HEADING --}}
    <div class="mb-7">
        <p class="text-xs font-bold uppercase tracking-[.18em] profile-accent mb-2">
            Portal Anggota NU Lesmana
        </p>

        <h1 class="text-3xl sm:text-4xl font-bold tracking-tight">
            Profil Saya
        </h1>

        <p class="text-sm profile-muted mt-2">
            Kelola informasi dan layanan keanggotaan Anda dalam satu tempat.
        </p>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-12 gap-6 items-start">

        {{-- LEFT PROFILE --}}
        <aside class="lg:col-span-4">

            <div class="profile-card">

                <div class="px-6 pt-9 pb-8 text-center">

                    {{-- AVATAR --}}
                    <div class="w-28 h-28 rounded-full mx-auto flex items-center justify-center text-5xl font-bold text-white"
                         style="background:#27272a;">
                        {{ $initial }}
                    </div>

                    <h2 class="text-2xl font-bold mt-5 break-words">
                        {{ $user->name }}
                    </h2>

                    <p class="text-sm profile-muted mt-1">
                        Anggota Ranting NU Lesmana
                    </p>

                    <div class="mt-4">
                        @if($status === 'approved')
                            <span class="inline-flex items-center gap-2 rounded-full px-4 py-2 text-xs font-bold bg-green-50 text-green-700">
                                <i class="ph-fill ph-check-circle"></i>
                                Anggota Terverifikasi
                            </span>
                        @elseif($status === 'pending')
                            <span class="inline-flex items-center gap-2 rounded-full px-4 py-2 text-xs font-bold bg-amber-50 text-amber-700">
                                <i class="ph ph-clock"></i>
                                Menunggu Verifikasi
                            </span>
                        @else
                            <span class="inline-flex items-center gap-2 rounded-full px-4 py-2 text-xs font-bold bg-gray-100 text-gray-600">
                                Status: {{ ucfirst($status) }}
                            </span>
                        @endif
                    </div>
                </div>

                <div class="border-t border-gray-100 px-6 py-6 space-y-5">

                    <div>
                        <p class="text-xs font-semibold profile-muted mb-1">
                            Nama Lengkap
                        </p>
                        <p class="text-sm font-semibold break-words">
                            {{ $user->name }}
                        </p>
                    </div>

                    <div>
                        <p class="text-xs font-semibold profile-muted mb-1">
                            Email
                        </p>
                        <p class="text-sm font-semibold break-all">
                            {{ $user->email }}
                        </p>
                    </div>

                    <div>
                        <p class="text-xs font-semibold profile-muted mb-1">
                            Nomor Induk Anggota
                        </p>
                        <p class="text-sm font-mono font-bold">
                            {{ $maskedNia }}
                        </p>
                    </div>

                    <div>
                        <p class="text-xs font-semibold profile-muted mb-1">
                            Status Keanggotaan
                        </p>
                        <p class="text-sm font-semibold">
                            {{ $status === 'approved' ? 'Aktif' : ucfirst($status) }}
                        </p>
                    </div>

                </div>

                {{-- LOGOUT --}}
                <div class="border-t border-gray-100 p-5">

                    <form method="POST" action="{{ route('logout') }}">
                        @csrf

                        <button type="submit"
                            class="w-full py-3 rounded-xl text-sm font-bold text-red-600 hover:bg-red-50 transition flex items-center justify-center gap-2">
                            <i class="ph ph-sign-out text-lg"></i>
                            Keluar dari Akun
                        </button>
                    </form>

                </div>
            </div>

        </aside>

        {{-- RIGHT CONTENT --}}
        <div class="lg:col-span-8 space-y-5">

            {{-- WELCOME --}}
            <div class="profile-card p-6 sm:p-7">

                <div class="flex items-start gap-4">

                    <div class="profile-menu-icon">
                        <i class="ph ph-hand-waving"></i>
                    </div>

                    <div>
                        <h3 class="text-xl font-bold">
                            Assalamu'alaikum, {{ $user->name }}!
                        </h3>

                        <p class="text-sm profile-muted mt-2 leading-relaxed">
                            Selamat datang di portal anggota Pengurus Ranting NU Lesmana.
                            Di sini Anda dapat mengakses informasi keanggotaan,
                            kartu identitas digital, dan layanan lainnya.
                        </p>
                    </div>

                </div>
            </div>

            {{-- MEMBER CARD --}}
            <div class="profile-card">

                <div class="px-6 py-5 border-b border-gray-100">
                    <h3 class="text-lg font-bold">
                        Kartu Identitas Anggota
                    </h3>

                    <p class="text-sm profile-muted mt-1">
                        Akses kartu anggota digital Anda.
                    </p>
                </div>

                <div class="p-6">

                    <div class="rounded-2xl bg-[#242428] text-white p-6 sm:p-7">

                        <div class="flex items-center justify-between gap-4">
                            <div>
                                <p class="text-[11px] font-semibold tracking-widest text-gray-300">
                                    PENGURUS RANTING
                                </p>
                                <h4 class="text-xl font-black mt-1">
                                    NU LESMANA
                                </h4>
                            </div>

                            <i class="ph ph-identification-card text-4xl text-white/80"></i>
                        </div>

                        <div class="mt-10">
                            <p class="text-[11px] text-gray-400 uppercase tracking-wider">
                                Nama Anggota
                            </p>

                            <p class="text-lg font-bold mt-1 break-words">
                                {{ $user->name }}
                            </p>

                            <p class="text-[11px] text-gray-400 uppercase tracking-wider mt-5">
                                Nomor Induk Anggota
                            </p>

                            <p class="text-base font-mono font-semibold mt-1">
                                {{ $maskedNia }}
                            </p>
                        </div>

                    </div>

                    <a href="{{ route('member.kia') }}"
                       class="mt-5 inline-flex items-center justify-center gap-2 rounded-xl px-5 py-3 text-sm font-bold bg-[#6754d8] text-white hover:bg-[#5846c2] transition">
                        Lihat KIA Saya
                        <i class="ph ph-arrow-up-right"></i>
                    </a>

                    <p class="text-xs profile-muted mt-3">
                        Tampilan ini merupakan ringkasan profil, bukan kartu resmi untuk dicetak.
                    </p>

                </div>
            </div>

            {{-- MEMBER SERVICES --}}
            <div class="profile-card">

                <div class="px-6 py-5 border-b border-gray-100">
                    <h3 class="text-lg font-bold">
                        Layanan Keanggotaan
                    </h3>

                    <p class="text-sm profile-muted mt-1">
                        Pilih layanan yang ingin Anda akses.
                    </p>
                </div>

                <div class="divide-y divide-gray-100">

                    @foreach($menus as $menu)
                        <a href="{{ route($menu['route']) }}"
                           class="profile-link flex items-center gap-4 px-6 py-5 transition">

                            <div class="profile-menu-icon">
                                <i class="ph {{ $menu['icon'] }}"></i>
                            </div>

                            <div class="flex-1 min-w-0">
                                <h4 class="font-bold text-sm sm:text-base">
                                    {{ $menu['title'] }}
                                </h4>

                                <p class="text-xs sm:text-sm profile-muted mt-1">
                                    {{ $menu['description'] }}
                                </p>
                            </div>

                            <i class="ph ph-caret-right text-lg text-gray-400"></i>
                        </a>
                    @endforeach

                </div>
            </div>

            {{-- NEWS --}}
            <div class="profile-card p-6">

                <div class="flex items-center gap-4">

                    <div class="profile-menu-icon">
                        <i class="ph ph-newspaper"></i>
                    </div>

                    <div class="flex-1">
                        <h3 class="font-bold">
                            Berita & Kegiatan
                        </h3>

                        <p class="text-sm profile-muted mt-1">
                            Ikuti informasi terbaru kegiatan NU Lesmana.
                        </p>
                    </div>

                    <a href="{{ route('public.news.index') }}"
                       class="text-sm font-bold profile-accent hover:underline">
                        Lihat
                    </a>

                </div>

            </div>

        </div>
    </div>
</div>

@endsection
