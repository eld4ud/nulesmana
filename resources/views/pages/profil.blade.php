@extends('layouts.member')

@section('title', 'Profil Ranting')

@section('content')
<div class="max-w-6xl mx-auto space-y-6 sm:space-y-8">

    <!-- Judul -->
    <div class="text-center">
        <span class="bg-green-900 text-lime-400 text-[10px] font-black px-3 py-1.5 rounded-full uppercase tracking-wider inline-block">Tentang Kami</span>
        <h1 class="font-display text-5xl sm:text-7xl leading-[0.95] text-gray-900 mt-3">PROFIL RANTING NU LESMANA</h1>
        <p class="text-sm sm:text-base font-semibold text-gray-800 mt-2 max-w-2xl mx-auto leading-relaxed">
            Pengurus Ranting Nahdlatul Ulama Lesmana mengelola kegiatan majelis, agenda keagamaan, dan keanggotaan
            lima Badan Otonom. Portal ini menjadi pusat informasi dan layanan bagi warga.
        </p>
    </div>

    <!-- Banom -->
    <div class="bg-white rounded-[2rem] sm:rounded-[2.5rem] p-6 sm:p-10 lg:p-12 shadow-2xl border border-gray-100">
        <div class="flex flex-col sm:flex-row sm:items-end sm:justify-between gap-2 mb-6">
            <h2 class="font-display text-4xl sm:text-5xl text-gray-900">LIMA BADAN OTONOM</h2>
            <p class="text-xs sm:text-sm font-semibold text-gray-600">{{ $total }} anggota terverifikasi</p>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4 sm:gap-6">
            @foreach ($banoms as [$name, $desc, $icon, $count])
                <div class="rounded-2xl border border-gray-200 bg-gradient-to-br from-lime-100 to-white p-5 flex items-center gap-4">
                    <div class="w-12 h-12 shrink-0 rounded-xl bg-green-900 text-lime-400 flex items-center justify-center text-2xl"><i class="ph {{ $icon }}"></i></div>
                    <div class="min-w-0 flex-1">
                        <h3 class="font-black text-base leading-tight">{{ $name }}</h3>
                        <p class="text-[11px] sm:text-xs text-gray-600 font-semibold">{{ $desc }}</p>
                    </div>
                    <p class="font-display text-4xl text-green-900 leading-none">{{ $count }}</p>
                </div>
            @endforeach

            <a href="{{ route('home') }}#struktur-banom" class="rounded-2xl bg-green-900 text-white p-5 flex items-center justify-between gap-3 hover:bg-green-800 transition">
                <div>
                    <h3 class="font-black text-base">Struktur Organisasi</h3>
                    <p class="text-[11px] sm:text-xs text-green-200 font-semibold">Lihat susunan pengurus tiap banom</p>
                </div>
                <i class="ph ph-arrow-up-right text-2xl text-lime-400"></i>
            </a>
        </div>
    </div>

    <!-- Layanan -->
    <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 sm:gap-6">
        @foreach ([
            ['Berita & Agenda', 'Liputan majelis, pengajian rutin, dan kegiatan sosial warga.', 'ph-newspaper', route('home').'#berita'],
            ['Kartu Anggota (KIA)', 'Kartu identitas digital dengan NIA dan kode QR verifikasi.', 'ph-identification-card', route('kia.info')],
            ['Kotak Saran', 'Sampaikan kritik dan masukan langsung ke pengurus ranting.', 'ph-chat-circle-text', route('home').'#saran'],
        ] as [$title, $text, $icon, $href])
            <a href="{{ $href }}" class="group bg-white rounded-[2rem] p-6 sm:p-8 shadow-2xl border border-gray-100 hover:shadow-lg transition block">
                <div class="w-12 h-12 border-2 border-green-900 text-green-900 rounded-xl flex items-center justify-center text-2xl group-hover:bg-green-900 group-hover:text-lime-400 transition"><i class="ph {{ $icon }}"></i></div>
                <h3 class="font-black text-base mt-3">{{ $title }}</h3>
                <p class="text-xs sm:text-sm text-gray-700 font-semibold mt-1">{{ $text }}</p>
            </a>
        @endforeach
    </div>

    <!-- Ajakan -->
    <div class="bg-gray-900 text-white rounded-[2rem] sm:rounded-[2.5rem] p-6 sm:p-10 shadow-2xl flex flex-col sm:flex-row items-center justify-between gap-5 text-center sm:text-left">
        <div>
            <h2 class="font-display text-4xl sm:text-5xl">GABUNG BERSAMA KAMI</h2>
            <p class="text-xs sm:text-sm text-gray-300 font-semibold mt-1">Daftar online, lalu NIA terbit setelah diverifikasi pengurus.</p>
        </div>
        <a href="{{ route('member.signup') }}" class="bg-lime-400 hover:bg-lime-300 text-gray-900 text-xs sm:text-sm font-black px-7 py-3.5 rounded-full transition whitespace-nowrap flex items-center gap-2">
            <i class="ph ph-user-plus text-lg"></i> Daftar Sekarang
        </a>
    </div>

</div>
@endsection
