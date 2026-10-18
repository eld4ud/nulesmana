
@extends('layouts.member')

@section('title', 'Profil Ranting NU Lesmana')

@section('content')
<div class="mx-auto max-w-6xl space-y-8 pb-10">

    {{-- HERO PROFIL --}}
    <section class="relative overflow-hidden rounded-[2rem] bg-[#183C2F] px-6 py-12 text-[#F5F4F0] sm:px-12 sm:py-16">

        <div class="relative z-10 max-w-3xl">
            <div class="mb-6 inline-flex items-center gap-2 rounded-full border border-white/20 px-4 py-2 text-[11px] font-bold uppercase tracking-[0.18em]">
                <span class="h-2 w-2 rounded-full bg-[#B9D3BF]"></span>
                Tentang Kami
            </div>

            <h1 class="font-display text-5xl leading-[0.95] sm:text-7xl">
                PROFIL RANTING
                <span class="block text-[#B9D3BF]">
                    NU LESMANA
                </span>
            </h1>

            <p class="mt-7 max-w-2xl text-sm leading-8 text-[#E1E9E2] sm:text-base">
                Pengurus Ranting Nahdlatul Ulama Lesmana mengelola
                kegiatan majelis, agenda keagamaan, dan keanggotaan
                lima Badan Otonom. Portal ini menjadi pusat informasi
                dan layanan digital bagi warga.
            </p>

            <div class="mt-9 flex flex-wrap gap-3">
                <a
                    href="{{ route('home') }}"
                    class="inline-flex items-center gap-2 rounded-xl bg-[#F5F4F0] px-6 py-3 text-sm font-bold text-[#183C2F]"
                >
                    <i class="ph ph-arrow-left text-lg"></i>
                    Website Utama
                </a>

            </div>
        </div>

        <div class="pointer-events-none absolute -right-32 -top-32 h-96 w-96 rounded-full border border-white/10"></div>
        <div class="pointer-events-none absolute -bottom-48 right-12 h-96 w-96 rounded-full border border-white/10"></div>
    </section>

    {{-- STATISTIK --}}
    <section class="grid gap-4 sm:grid-cols-2">
        <div class="rounded-[1.75rem] border border-[#E1E6DF] bg-white p-7">
            <p class="text-xs font-bold uppercase tracking-widest text-[#728276]">
                Anggota Terverifikasi
            </p>

            <p class="mt-4 font-display text-6xl text-[#183C2F]">
                {{ number_format($total, 0, ',', '.') }}
            </p>

            <p class="mt-2 text-sm text-gray-600">
                Total anggota yang telah diverifikasi pengurus.
            </p>
        </div>

        <div class="rounded-[1.75rem] bg-[#E6EDE6] p-7">
            <p class="text-xs font-bold uppercase tracking-widest text-[#486653]">
                Organisasi
            </p>

            <p class="mt-4 font-display text-6xl text-[#183C2F]">
                05
            </p>

            <p class="mt-2 text-sm text-[#486653]">
                Badan Otonom dalam lingkungan Ranting NU Lesmana.
            </p>
        </div>
    </section>

    {{-- LIMA BADAN OTONOM --}}
    <section class="rounded-[2rem] border border-[#E1E6DF] bg-white p-6 sm:p-10">

        <div class="mb-8 flex flex-col justify-between gap-4 sm:flex-row sm:items-end">
            <div>
                <p class="mb-3 text-xs font-bold uppercase tracking-widest text-[#607C69]">
                    Organisasi Kami
                </p>

                <h2 class="font-display text-4xl text-[#183C2F] sm:text-5xl">
                    LIMA BADAN OTONOM
                </h2>
            </div>

            <p class="text-sm text-gray-500">
                {{ number_format($total, 0, ',', '.') }} anggota terverifikasi
            </p>
        </div>

        <div class="grid gap-4 sm:grid-cols-2 lg:grid-cols-3">

            @foreach ($banoms as [$name, $desc, $icon, $count])
                <div class="rounded-2xl border border-[#E2E8E1] bg-[#F8F9F6] p-6">

                    <div class="flex items-start justify-between gap-3">
                        <div class="flex h-12 w-12 items-center justify-center rounded-xl bg-[#183C2F] text-2xl text-white">
                            <i class="ph {{ $icon }}"></i>
                        </div>

                        <span class="font-display text-4xl text-[#183C2F]">
                            {{ $count }}
                        </span>
                    </div>

                    <h3 class="mt-6 text-lg font-black text-[#183C2F]">
                        {{ $name }}
                    </h3>

                    <p class="mt-2 text-sm leading-6 text-gray-600">
                        {{ $desc }}
                    </p>
                </div>
            @endforeach

            <a
                href="{{ route('home') }}#struktur-banom"
                class="flex flex-col justify-between rounded-2xl bg-[#183C2F] p-6 text-white"
            >
                <i class="ph ph-sitemap text-3xl text-[#C4D7C8]"></i>

                <div class="mt-8">
                    <h3 class="text-lg font-black">
                        Struktur Organisasi
                    </h3>

                    <p class="mt-2 text-sm leading-6 text-[#D7E4D9]">
                        Lihat susunan pengurus dan informasi
                        masing-masing badan otonom.
                    </p>

                    <span class="mt-5 inline-flex items-center gap-2 text-sm font-bold">
                        Lihat Struktur
                        <i class="ph ph-arrow-up-right"></i>
                    </span>
                </div>
            </a>
        </div>
    </section>

    {{-- LAYANAN DIGITAL --}}
    <section>
        <div class="mb-6">
            <p class="mb-3 text-xs font-bold uppercase tracking-widest text-[#607C69]">
                Portal Digital
            </p>

            <h2 class="font-display text-4xl text-[#183C2F] sm:text-5xl">
                LAYANAN KAMI
            </h2>

            <p class="mt-3 text-sm text-gray-600">
                Informasi dan layanan anggota dalam satu portal.
            </p>
        </div>

        <div class="grid gap-4 sm:grid-cols-3">

            @foreach ([
                [
                    'Berita & Agenda',
                    'Liputan majelis, pengajian rutin, dan kegiatan sosial warga.',
                    'ph-newspaper',
                    route('home') . '#berita'
                ],
                [
                    'Kartu Anggota (KIA)',
                    'Pengecekan identitas dan status keanggotaan melalui NIA.',
                    'ph-identification-card',
                    route('kia.cek')
                ],
                [
                    'Kotak Saran',
                    'Sampaikan kritik dan masukan kepada pengurus ranting.',
                    'ph-chat-circle-text',
                    route('home') . '#saran'
                ]
            ] as [$title, $description, $icon, $href])

                <a
                    href="{{ $href }}"
                    class="group rounded-[1.75rem] border border-[#E1E6DF] bg-white p-7"
                >
                    <div class="flex h-12 w-12 items-center justify-center rounded-xl bg-[#E6EDE6] text-2xl text-[#183C2F]">
                        <i class="ph {{ $icon }}"></i>
                    </div>

                    <h3 class="mt-7 text-lg font-black text-[#183C2F]">
                        {{ $title }}
                    </h3>

                    <p class="mt-3 text-sm leading-7 text-gray-600">
                        {{ $description }}
                    </p>

                    <span class="mt-6 inline-flex items-center gap-2 text-sm font-bold text-[#183C2F]">
                        Selengkapnya
                        <i class="ph ph-arrow-up-right"></i>
                    </span>
                </a>
            @endforeach
        </div>
    </section>

    {{-- AJAKAN BERGABUNG --}}
    <section class="flex flex-col items-start justify-between gap-6 rounded-[2rem] bg-[#183C2F] p-8 text-white sm:flex-row sm:items-center sm:p-12">

        <div class="max-w-xl">
            <p class="mb-3 text-xs font-bold uppercase tracking-widest text-[#B9D3BF]">
                Keanggotaan
            </p>

            <h2 class="font-display text-4xl sm:text-5xl">
                GABUNG BERSAMA KAMI
            </h2>

            <p class="mt-4 text-sm leading-7 text-[#D7E4D9]">
                Daftar secara online dan ikuti proses verifikasi
                pengurus untuk memperoleh Nomor Induk Anggota.
            </p>
        </div>

        <a
            href="{{ route('member.signup') }}"
            class="inline-flex shrink-0 items-center gap-2 rounded-xl bg-[#F5F4F0] px-7 py-4 text-sm font-black text-[#183C2F]"
        >
            <i class="ph ph-user-plus text-lg"></i>
            Daftar Sekarang
        </a>
    </section>

</div>
@endsection
