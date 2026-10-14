@extends('layouts.member')

@section('title', 'Verifikasi NIA')

@section('content')
<div class="max-w-xl mx-auto">
    <div class="bg-white rounded-[2rem] sm:rounded-[2.5rem] p-6 sm:p-10 shadow-2xl border border-gray-100 text-center">

        @if ($member)
            <div class="w-16 h-16 mx-auto rounded-full bg-green-900 text-lime-400 flex items-center justify-center text-3xl mb-4"><i class="ph ph-seal-check"></i></div>
            <span class="bg-green-100 text-green-800 text-[10px] font-black px-3 py-1 rounded-full uppercase tracking-wider inline-block">Anggota aktif</span>
            <h1 class="font-display text-4xl sm:text-6xl text-gray-900 mt-2 break-words">{{ \Illuminate\Support\Str::upper($member->name) }}</h1>

            <dl class="mt-6 grid grid-cols-2 gap-3 text-left">
                <div class="bg-gray-50 rounded-2xl p-4">
                    <dt class="text-[10px] font-bold text-gray-500 uppercase">NIA</dt>
                    <dd class="font-mono text-sm sm:text-base font-bold text-green-900 mt-1 break-all">{{ $member->nia }}</dd>
                </div>
                <div class="bg-gray-50 rounded-2xl p-4">
                    <dt class="text-[10px] font-bold text-gray-500 uppercase">Banom</dt>
                    <dd class="text-sm sm:text-base font-bold text-gray-900 mt-1">{{ $member->banom ?? '-' }}</dd>
                </div>
            </dl>

            <p class="text-xs font-semibold text-gray-500 mt-5">Data lain disembunyikan demi privasi anggota.</p>
        @else
            <div class="w-16 h-16 mx-auto rounded-full bg-red-100 text-red-700 flex items-center justify-center text-3xl mb-4"><i class="ph ph-warning-circle"></i></div>
            <h1 class="font-display text-4xl sm:text-5xl text-gray-900">NIA TIDAK DITEMUKAN</h1>
            <p class="text-sm font-semibold text-gray-700 mt-2">
                Tidak ada anggota aktif dengan NIA <span class="font-mono font-bold">{{ $nia }}</span>.
                Periksa kembali penulisannya, atau hubungi pengurus ranting.
            </p>
        @endif

        <div class="flex flex-wrap items-center justify-center gap-3 mt-7">
            <a href="{{ route('kia.info') }}" class="bg-gray-900 hover:bg-green-800 text-white text-xs sm:text-sm font-black px-6 py-3 rounded-full transition">Cek NIA lain</a>
            <a href="{{ route('home') }}" class="bg-white border-2 border-gray-900 text-gray-900 text-xs sm:text-sm font-black px-6 py-3 rounded-full hover:bg-gray-50 transition">Kembali ke beranda</a>
        </div>
    </div>
</div>
@endsection
