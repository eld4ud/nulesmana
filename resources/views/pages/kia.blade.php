@extends('layouts.member')

@section('title', 'Kartu Identitas Anggota')

@section('content')
<div class="max-w-6xl mx-auto space-y-6 sm:space-y-8">

    <!-- Judul -->
    <div class="text-center">
        <span class="bg-green-900 text-lime-400 text-[10px] font-black px-3 py-1.5 rounded-full uppercase tracking-wider inline-block">Kartu Digital</span>
        <h1 class="font-display text-5xl sm:text-7xl leading-[0.95] text-gray-900 mt-3">KARTU IDENTITAS ANGGOTA</h1>
        <p class="text-sm sm:text-base font-semibold text-gray-800 mt-2 max-w-xl mx-auto">
            Setiap anggota Ranting NU Lesmana mendapat KIA digital berisi NIA, foto, dan kode QR untuk verifikasi keaslian.
        </p>

        <div class="flex flex-wrap items-center justify-center gap-3 mt-5">
            @auth
                @if (auth()->user()->role === 'member')
                    <a href="{{ route('member.kia') }}" class="bg-gray-900 hover:bg-green-800 text-white text-xs sm:text-sm font-black px-6 sm:px-8 py-3.5 rounded-full transition flex items-center gap-2">
                        <i class="ph ph-identification-card text-lg"></i> Lihat KIA Saya
                    </a>
                @endif
            @else
                <a href="{{ route('member.login') }}" class="bg-gray-900 hover:bg-green-800 text-white text-xs sm:text-sm font-black px-6 sm:px-8 py-3.5 rounded-full transition flex items-center gap-2">
                    <i class="ph ph-sign-in text-lg"></i> Login untuk Lihat KIA
                </a>
                <a href="{{ route('member.signup') }}" class="bg-white border-2 border-gray-900 text-gray-900 text-xs sm:text-sm font-black px-6 sm:px-8 py-3.5 rounded-full hover:bg-gray-50 transition flex items-center gap-2">
                    <i class="ph ph-user-plus text-lg"></i> Daftar Anggota
                </a>
            @endauth
        </div>
    </div>

    <!-- Contoh kartu depan dan belakang -->
    <div class="bg-white rounded-[2rem] sm:rounded-[2.5rem] p-6 sm:p-10 shadow-2xl border border-gray-100">
        <div class="flex items-baseline justify-between mb-6">
            <h2 class="font-display text-3xl sm:text-5xl text-gray-900">CONTOH TAMPILAN</h2>
            <span class="text-[11px] font-semibold text-gray-500 italic">Data di bawah hanya contoh</span>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

            <!-- Depan -->
            <div>
                <p class="text-xs font-black text-gray-700 uppercase mb-2">Sisi depan</p>
                <div class="aspect-[1.586/1] rounded-3xl bg-green-900 text-white p-5 sm:p-6 shadow-xl flex flex-col justify-between overflow-hidden relative">
                    <div class="absolute -right-10 -top-10 w-40 h-40 rounded-full bg-lime-400/20"></div>

                    <div class="flex items-center gap-3 relative">
                        <div class="w-10 h-10 rounded-full bg-lime-400 text-green-900 flex items-center justify-center font-black text-sm">NU</div>
                        <div class="leading-tight">
                            <p class="text-[10px] sm:text-xs font-bold text-green-200">Nahdlatul Ulama</p>
                            <p class="text-sm sm:text-base font-black">Ranting Lesmana</p>
                        </div>
                    </div>

                    <div class="flex items-end gap-4 relative">
                        <div class="w-20 h-24 sm:w-24 sm:h-28 rounded-xl bg-white/15 border border-white/25 flex items-center justify-center text-4xl text-green-200 shrink-0">
                            <i class="ph ph-user"></i>
                        </div>
                        <div class="min-w-0">
                            <p class="text-base sm:text-xl font-extrabold leading-tight truncate">Nama Anggota</p>
                            <p class="text-xs font-semibold text-green-200 mt-0.5">Banom</p>
                            <p class="font-mono text-base sm:text-lg font-bold text-lime-400 mt-2">LSM-26-0001</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Belakang -->
            <div>
                <p class="text-xs font-black text-gray-700 uppercase mb-2">Sisi belakang</p>
                <div class="aspect-[1.586/1] rounded-3xl bg-lime-100 border border-lime-300 text-gray-900 p-5 sm:p-6 shadow-xl flex flex-col justify-between">
                    <div class="flex items-start justify-between gap-4">
                        <div class="text-xs font-semibold leading-relaxed text-gray-700 max-w-[11rem] sm:max-w-xs">
                            Kartu ini sah sebagai tanda keanggotaan Ranting NU Lesmana. Pindai kode QR untuk memeriksa keaslian.
                        </div>
                        <div class="w-20 h-20 sm:w-24 sm:h-24 rounded-xl bg-white border border-gray-300 flex items-center justify-center text-5xl text-gray-800 shrink-0">
                            <i class="ph ph-qr-code"></i>
                        </div>
                    </div>
                    <div class="flex items-end justify-between">
                        <div>
                            <p class="text-[10px] font-bold text-gray-600 uppercase">Berlaku</p>
                            <p class="text-xs sm:text-sm font-black">Selama menjadi anggota aktif</p>
                        </div>
                        <div class="text-right">
                            <div class="w-24 border-b border-gray-700 mb-1"></div>
                            <p class="text-[10px] font-bold text-gray-600">Ketua Ranting</p>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>

    <!-- Alur -->
    <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 sm:gap-6">
        @foreach ([
            ['Daftar online', 'Isi formulir pendaftaran tiga langkah di halaman Daftar Anggota.', 'ph-user-plus'],
            ['Verifikasi pengurus', 'Pengurus memeriksa data Anda lalu menyetujui pendaftaran.', 'ph-seal-check'],
            ['KIA terbit otomatis', 'NIA dibuat sistem dan kartu bisa dilihat serta diunduh dari akun Anda.', 'ph-identification-card'],
        ] as $i => [$title, $text, $icon])
            <div class="bg-white rounded-[2rem] p-6 sm:p-8 shadow-2xl border border-gray-100">
                <div class="flex items-center gap-3">
                    <div class="w-12 h-12 shrink-0 border-2 border-green-900 text-green-900 rounded-xl flex items-center justify-center text-2xl"><i class="ph {{ $icon }}"></i></div>
                    <span class="font-display text-4xl text-green-900">{{ $i + 1 }}</span>
                </div>
                <h3 class="font-black text-base mt-3">{{ $title }}</h3>
                <p class="text-xs sm:text-sm text-gray-700 font-semibold mt-1">{{ $text }}</p>
            </div>
        @endforeach
    </div>

    <!-- Cek NIA -->
    <div class="bg-gray-900 text-white rounded-[2rem] sm:rounded-[2.5rem] p-6 sm:p-10 shadow-2xl text-center">
        <h2 class="font-display text-4xl sm:text-5xl">CEK KEANGGOTAAN</h2>
        <p class="text-xs sm:text-sm text-gray-300 font-semibold mt-1">Masukkan NIA untuk memeriksa apakah seseorang tercatat sebagai anggota aktif.</p>

        <form action="{{ route('kia.cek') }}" method="GET" class="flex flex-col sm:flex-row gap-3 max-w-md mx-auto mt-5">
            <input type="text" name="nia" required placeholder="Contoh: LSM-26-0001"
                   class="flex-1 bg-white/10 border border-white/20 rounded-xl px-4 py-3 text-xs sm:text-sm font-mono text-white placeholder-gray-400 outline-none focus:ring-2 focus:ring-lime-400">
            <button type="submit" class="px-6 py-3 bg-lime-400 hover:bg-lime-300 text-gray-900 font-black text-xs sm:text-sm rounded-xl transition whitespace-nowrap">Cek NIA</button>
        </form>
    </div>

</div>
@endsection
