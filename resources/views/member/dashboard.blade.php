@extends('layouts.member')

@section('title', 'Dashboard Saya')

@section('content')
    <div class="mb-8">
        <p class="text-sm sm:text-base font-bold text-gray-800">ASSALAMU'ALAIKUM</p>
        <h1 class="font-display text-5xl sm:text-7xl leading-[0.95] text-gray-900 break-words">{{ \Illuminate\Support\Str::upper($user->name) }}</h1>
        <p class="text-sm sm:text-base font-semibold text-gray-800 mt-2">Ini ringkasan keanggotaan Anda di Ranting NU Lesmana.</p>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 sm:gap-6">
        <div class="bg-gray-900 text-white rounded-[2rem] p-6 sm:p-8 shadow-2xl">
            <p class="text-[10px] sm:text-xs font-bold text-gray-300 uppercase">Nomor Induk Anggota</p>
            <p class="font-mono text-2xl sm:text-3xl font-bold text-lime-400 mt-2 break-all">{{ $user->nia ?? 'Belum ada' }}</p>
        </div>

        <div class="bg-white rounded-[2rem] p-6 sm:p-8 shadow-2xl border border-gray-100">
            <p class="text-[10px] sm:text-xs font-bold text-gray-500 uppercase">Status Keanggotaan</p>
            <p class="font-display text-4xl sm:text-5xl text-green-900 mt-1">
                {{ match ($user->status) {
                    'approved' => 'ANGGOTA AKTIF',
                    'pending'  => 'MENUNGGU VERIFIKASI',
                    default    => 'TIDAK AKTIF',
                } }}
            </p>
        </div>

        <a href="{{ route('member.kia') }}" class="group bg-green-900 text-white rounded-[2rem] p-6 sm:p-8 shadow-2xl hover:bg-green-800 transition flex flex-col justify-between gap-4">
            <div class="w-12 h-12 rounded-full bg-lime-400 text-green-900 flex items-center justify-center text-2xl"><i class="ph ph-identification-card"></i></div>
            <div>
                <p class="text-[10px] sm:text-xs font-bold text-green-200 uppercase">Kartu Anggota</p>
                <p class="font-display text-4xl sm:text-5xl">LIHAT KIA SAYA</p>
            </div>
        </a>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 sm:gap-6 mt-4 sm:mt-6">
        <a href="{{ route('home') }}#berita" class="bg-white rounded-[2rem] p-6 sm:p-8 shadow-2xl border border-gray-100 hover:shadow-lg transition flex items-center gap-4">
            <div class="w-12 h-12 shrink-0 border-2 border-green-900 text-green-900 rounded-xl flex items-center justify-center text-2xl"><i class="ph ph-newspaper"></i></div>
            <div>
                <h3 class="font-black text-base">Berita & Agenda</h3>
                <p class="text-xs sm:text-sm text-gray-700 font-semibold">Baca kabar terbaru kegiatan ranting.</p>
            </div>
        </a>
        <a href="{{ route('member.data') }}" class="bg-white rounded-[2rem] p-6 sm:p-8 shadow-2xl border border-gray-100 hover:shadow-lg transition flex items-center gap-4">
            <div class="w-12 h-12 shrink-0 border-2 border-green-900 text-green-900 rounded-xl flex items-center justify-center text-2xl"><i class="ph ph-user"></i></div>
            <div>
                <h3 class="font-black text-base">Data Saya</h3>
                <p class="text-xs sm:text-sm text-gray-700 font-semibold">Periksa dan perbarui data diri Anda.</p>
            </div>
        </a>
    </div>
@endsection
