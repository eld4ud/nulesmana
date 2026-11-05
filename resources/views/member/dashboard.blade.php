@extends('layouts.member')

@section('title', 'Dashboard Anggota')

@section('content')
@php
    $initial = mb_strtoupper(mb_substr($user->name ?? 'A', 0, 1));
    $status = $user->status ?? 'pending';
    $nia = $user->member?->nia ?: ($user->nia ?? null);
    $maskedNia = $nia
        ? str_repeat('•', max(mb_strlen($nia) - 4, 0)) . mb_substr($nia, -4)
        : 'Belum tersedia';
    $member = $user->member;
    $banom = $member?->banom ?: 'Anggota';
    $photoPath = $member?->photo ?? null;
    $photoUrl = $photoPath ? url('/storage/' . ltrim($photoPath, '/')) : null;

    $menus = [
        ['title' => 'Kartu Identitas Anggota', 'description' => 'Lihat kartu digital dan informasi KIA Anda.', 'route' => 'member.kia', 'icon' => 'ph-identification-card'],
        ['title' => 'Data Keanggotaan', 'description' => 'Periksa informasi pribadi dan data anggota.', 'route' => 'member.data', 'icon' => 'ph-user-circle'],
        ['title' => 'Notifikasi', 'description' => 'Informasi terbaru terkait akun dan kegiatan.', 'route' => 'member.notifikasi', 'icon' => 'ph-bell'],
        ['title' => 'Pengaturan Akun', 'description' => 'Kelola informasi dan keamanan akun Anda.', 'route' => 'member.pengaturan', 'icon' => 'ph-gear'],
    ];
@endphp

<style>
    .nu-dashboard {
        --forest: #183C2F;
        --ivory: #F5F4F0;
        --muted: #68786E;
        font-family: 'DM Sans', sans-serif;
        color: #17241D;
    }

    .nu-panel {
        background: #fff;
        border: 1px solid #E2E8E1;
        border-radius: 24px;
        overflow: hidden;
    }

    .nu-muted { color: var(--muted); }
    .nu-forest { color: var(--forest); }

    .nu-icon {
        display: flex;
        align-items: center;
        justify-content: center;
        width: 48px;
        height: 48px;
        flex-shrink: 0;
        border-radius: 14px;
        background: #E7EEE7;
        color: var(--forest);
        font-size: 23px;
    }

    .nu-menu-link:hover { background: #F7F9F6; }

    .nu-modal[hidden] { display: none !important; }

    .nu-modal {
        position: fixed;
        inset: 0;
        z-index: 9999;
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 20px;
        background: rgba(10, 24, 17, .78);
    }

    .nu-modal-box {
        width: min(100%, 700px);
        max-height: 95vh;
        overflow-y: auto;
        border-radius: 26px;
        background: var(--ivory);
        padding: 22px;
    }

    .nu-flip-scene { perspective: 1200px; }

    .nu-flip-inner {
        position: relative;
        width: 100%;
        aspect-ratio: 85.6 / 54;
        transform-style: preserve-3d;
        transition: transform .65s ease;
    }

    .nu-flip-inner.is-flipped { transform: rotateY(180deg); }

    .nu-flip-face {
        position: absolute;
        inset: 0;
        backface-visibility: hidden;
        -webkit-backface-visibility: hidden;
    }

    .nu-flip-face > .kia-unified-card { height: 100%; }
    .nu-flip-back { transform: rotateY(180deg); }

    @media (prefers-reduced-motion: reduce) {
        .nu-flip-inner { transition: none; }
    }
</style>
@include('components.kia-style')
<div class="nu-dashboard mx-auto max-w-7xl pb-12">

    {{-- HEADER --}}
    <div class="mb-8 flex flex-wrap items-end justify-between gap-4">
        <div>
            <p class="nu-forest mb-2 text-xs font-black uppercase tracking-[.18em]">
                Portal Anggota NU Lesmana
            </p>
            <h1 class="text-3xl font-black tracking-tight sm:text-5xl">
                Dashboard Anggota
            </h1>
            <p class="nu-muted mt-3 text-sm">
                Kelola identitas dan layanan keanggotaan dalam satu tempat.
            </p>
        </div>

        <a href="{{ route('home') }}"
           class="inline-flex items-center gap-2 rounded-xl border border-[#183C2F] px-5 py-3 text-sm font-bold text-[#183C2F]">
            <i class="ph ph-arrow-up-right text-lg"></i>
            Website Utama
        </a>
    </div>

    <div class="grid grid-cols-1 items-start gap-6 lg:grid-cols-12">

        {{-- PROFIL ANGGOTA --}}
        <aside class="lg:col-span-4">
            <div class="nu-panel">
                <div class="bg-[#183C2F] px-6 pb-8 pt-9 text-center text-white">
                    <div class="mx-auto flex h-24 w-24 items-center justify-center overflow-hidden rounded-full border-4 border-white/30 bg-[#E7EEE7] text-4xl font-black text-[#183C2F]">
                        @if ($photoUrl)
                            <img src="{{ $photoUrl }}" alt="Foto profil anggota" class="h-full w-full object-cover">
                        @else
                            {{ $initial }}
                        @endif
                    </div>

                    <h2 class="mt-5 break-words text-2xl font-black">
                        {{ $user->name }}
                    </h2>
                    <p class="mt-1 text-sm text-[#D9E6DB]">
                        Anggota Ranting NU Lesmana
                    </p>

                    <div class="mt-5">
                        @if ($status === 'approved')
                            <span class="inline-flex items-center gap-2 rounded-full bg-white/15 px-4 py-2 text-xs font-bold text-white">
                                <i class="ph-fill ph-check-circle"></i>
                                Terverifikasi
                            </span>
                        @elseif ($status === 'pending')
                            <span class="inline-flex items-center gap-2 rounded-full bg-amber-100 px-4 py-2 text-xs font-bold text-amber-900">
                                <i class="ph ph-clock"></i>
                                Menunggu Verifikasi
                            </span>
                        @else
                            <span class="inline-flex rounded-full bg-white/15 px-4 py-2 text-xs font-bold">
                                {{ ucfirst($status) }}
                            </span>
                        @endif
                    </div>
                </div>

                <div class="space-y-5 p-6">
                    <div>
                        <p class="nu-muted mb-1 text-xs font-bold">Nama Lengkap</p>
                        <p class="break-words text-sm font-bold">{{ $user->name }}</p>
                    </div>
                    <div>
                        <p class="nu-muted mb-1 text-xs font-bold">Email</p>
                        <p class="break-all text-sm font-bold">{{ $user->email }}</p>
                    </div>
                    <div>
                        <p class="nu-muted mb-1 text-xs font-bold">Nomor Induk Anggota</p>
                        <p class="break-all font-mono text-sm font-bold">{{ $maskedNia }}</p>
                    </div>
                    <div>
                        <p class="nu-muted mb-1 text-xs font-bold">Status Keanggotaan</p>
                        <p class="text-sm font-bold">
                            {{ $status === 'approved' ? 'Aktif' : ucfirst($status) }}
                        </p>
                    </div>
                </div>

                <div class="border-t border-[#E2E8E1] p-5">
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit"
                                class="flex w-full items-center justify-center gap-2 rounded-xl px-4 py-3 text-sm font-bold text-red-700 hover:bg-red-50">
                            <i class="ph ph-sign-out text-lg"></i>
                            Keluar dari Akun
                        </button>
                    </form>
                </div>
            </div>
        </aside>

        {{-- KONTEN UTAMA --}}
        <div class="space-y-6 lg:col-span-8">

            {{-- SAMBUTAN --}}
            <section class="nu-panel p-6 sm:p-8">
                <div class="flex items-start gap-4">
                    <div class="nu-icon">
                        <i class="ph ph-hand-waving"></i>
                    </div>
                    <div>
                        <h3 class="text-xl font-black text-[#183C2F]">
                            Assalamu'alaikum, {{ $user->name }}!
                        </h3>
                        <p class="nu-muted mt-2 text-sm leading-7">
                            Selamat datang di portal anggota NU Lesmana.
                            Akses kartu identitas digital, data keanggotaan,
                            dan layanan lainnya melalui dashboard ini.
                        </p>
                    </div>
                </div>
            </section>

            {{-- PRATINJAU KIA --}}
            <section class="nu-panel">
                <div class="border-b border-[#E2E8E1] px-6 py-5">
                    <h3 class="text-lg font-black text-[#183C2F]">
                        Kartu Identitas Anggota
                    </h3>
                    <p class="nu-muted mt-1 text-sm">
                        Klik kartu untuk memperbesar dan melihat sisi belakang.
                    </p>
                </div>

                <div class="p-6 sm:p-8">
                    <button type="button"
                            id="openKiaModal"
                            aria-label="Buka pratinjau KIA"
                            class="block w-full max-w-[560px] cursor-pointer rounded-[20px] text-left focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-4 focus-visible:outline-[#183C2F]">
                        @include('components.kia-card', ['side' => 'front', 'user' => $user, 'member' => $member, 'nia' => $nia])
                    </button>

                    <div class="mt-6 flex flex-wrap gap-3">
                        <a href="{{ route('member.kia') }}"
                           class="inline-flex items-center gap-2 rounded-xl bg-[#183C2F] px-5 py-3 text-sm font-bold text-white">
                            <i class="ph ph-identification-card text-lg"></i>
                            KIA Digital & Foto
                        </a>
                        <a href="{{ route('member.cetak-kartu') }}"
                           class="inline-flex items-center gap-2 rounded-xl border border-[#183C2F] px-5 py-3 text-sm font-bold text-[#183C2F]">
                            <i class="ph ph-printer text-lg"></i>
                            Cetak Kartu
                        </a>
                    </div>
                </div>
            </section>

            {{-- LAYANAN --}}
            <section class="nu-panel">
                <div class="border-b border-[#E2E8E1] px-6 py-5">
                    <h3 class="text-lg font-black text-[#183C2F]">Layanan Keanggotaan</h3>
                    <p class="nu-muted mt-1 text-sm">Pilih layanan yang ingin Anda akses.</p>
                </div>

                <div class="divide-y divide-[#E2E8E1]">
                    @foreach ($menus as $menu)
                        <a href="{{ route($menu['route']) }}"
                           class="nu-menu-link flex items-center gap-4 px-6 py-5">
                            <div class="nu-icon">
                                <i class="ph {{ $menu['icon'] }}"></i>
                            </div>
                            <div class="min-w-0 flex-1">
                                <h4 class="text-sm font-black text-[#183C2F] sm:text-base">
                                    {{ $menu['title'] }}
                                </h4>
                                <p class="nu-muted mt-1 text-xs sm:text-sm">
                                    {{ $menu['description'] }}
                                </p>
                            </div>
                            <i class="ph ph-caret-right text-lg text-[#718477]"></i>
                        </a>
                    @endforeach
                </div>
            </section>

            {{-- BERITA --}}
            <section class="nu-panel flex items-center gap-4 p-6">
                <div class="nu-icon">
                    <i class="ph ph-newspaper"></i>
                </div>
                <div class="min-w-0 flex-1">
                    <h3 class="font-black text-[#183C2F]">Berita & Kegiatan</h3>
                    <p class="nu-muted mt-1 text-sm">
                        Ikuti informasi terbaru kegiatan NU Lesmana.
                    </p>
                </div>
                <a href="{{ route('public.news.index') }}"
                   class="shrink-0 text-sm font-bold text-[#183C2F] underline-offset-4 hover:underline">
                    Lihat
                </a>
            </section>
        </div>
    </div>
</div>

{{-- MODAL KIA --}}
<div id="kiaModal" class="nu-modal" hidden role="dialog" aria-modal="true" aria-labelledby="kiaModalTitle">
    <div class="nu-modal-box" id="kiaModalBox">
        <div class="mb-5 flex items-center justify-between gap-4">
            <div>
                <h2 id="kiaModalTitle" class="text-xl font-black text-[#183C2F]">KIA Digital</h2>
                <p class="text-xs text-[#68786E]">Klik kartu untuk melihat sisi belakang.</p>
            </div>
            <button type="button" id="closeKiaModal"
                    class="flex h-10 w-10 items-center justify-center rounded-xl border border-[#D6E0D6] text-[#183C2F]"
                    aria-label="Tutup pop-up">
                <i class="ph ph-x text-xl"></i>
            </button>
        </div>

        <button type="button" id="flipKiaButton" class="nu-flip-scene block w-full text-left"
                aria-label="Balik kartu anggota" aria-pressed="false">
            <div class="nu-flip-inner" id="flipKiaInner">
                <div class="nu-flip-face">
                    @include('components.kia-card', ['side' => 'front', 'user' => $user, 'member' => $member, 'nia' => $nia])
                </div>
                <div class="nu-flip-face nu-flip-back">
                    @include('components.kia-card', ['side' => 'back', 'user' => $user, 'member' => $member, 'nia' => $nia])
                </div>
            </div>
        </button>

        <div class="mt-5 flex flex-wrap gap-3">
            <a href="{{ route('member.kia') }}"
               class="rounded-xl bg-[#183C2F] px-5 py-3 text-sm font-bold text-white">
                KIA Digital & Foto
            </a>
            <a href="{{ route('member.cetak-kartu') }}"
               class="rounded-xl border border-[#183C2F] px-5 py-3 text-sm font-bold text-[#183C2F]">
                Cetak Kartu
            </a>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const modal = document.getElementById('kiaModal');
        const modalBox = document.getElementById('kiaModalBox');
        const openButton = document.getElementById('openKiaModal');
        const closeButton = document.getElementById('closeKiaModal');
        const flipButton = document.getElementById('flipKiaButton');
        const flipInner = document.getElementById('flipKiaInner');
        let previousFocus = null;

        function closeModal() {
            modal.hidden = true;
            document.body.style.overflow = '';
            flipInner.classList.remove('is-flipped');
            flipButton.setAttribute('aria-pressed', 'false');
            if (previousFocus) previousFocus.focus();
        }

        openButton.addEventListener('click', function () {
            previousFocus = document.activeElement;
            modal.hidden = false;
            document.body.style.overflow = 'hidden';
            closeButton.focus();
        });

        closeButton.addEventListener('click', closeModal);

        modal.addEventListener('click', function (event) {
            if (!modalBox.contains(event.target)) closeModal();
        });

        flipButton.addEventListener('click', function () {
            const flipped = flipInner.classList.toggle('is-flipped');
            flipButton.setAttribute('aria-pressed', String(flipped));
        });

        document.addEventListener('keydown', function (event) {
            if (modal.hidden) return;
            if (event.key === 'Escape') closeModal();
            if (event.key === 'Tab') {
                const focusable = Array.from(modal.querySelectorAll('button, a[href]'));
                const first = focusable[0];
                const last = focusable[focusable.length - 1];
                if (event.shiftKey && document.activeElement === first) {
                    event.preventDefault();
                    last.focus();
                } else if (!event.shiftKey && document.activeElement === last) {
                    event.preventDefault();
                    first.focus();
                }
            }
        });
    });
</script>
@endsection
