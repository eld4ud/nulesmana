@extends('layouts.member')

@section('title', $title)

@section('content')
    <div class="bg-white rounded-[2rem] sm:rounded-[2.5rem] p-6 sm:p-10 lg:p-12 shadow-2xl border border-gray-100 max-w-2xl mx-auto text-center">
        <div class="w-16 h-16 mx-auto rounded-full bg-green-900 text-lime-400 flex items-center justify-center text-3xl mb-4"><i class="ph ph-hourglass-medium"></i></div>
        <h1 class="font-display text-4xl sm:text-6xl text-gray-900">{{ \Illuminate\Support\Str::upper($title) }}</h1>
        <p class="text-sm sm:text-base font-semibold text-gray-700 mt-2">Halaman ini belum aktif. Pengurus sedang menyiapkannya.</p>
        <a href="{{ route('member.dashboard') }}" class="inline-block mt-6 bg-gray-900 hover:bg-green-800 text-white text-xs sm:text-sm font-black px-6 sm:px-8 py-3.5 rounded-full transition">
            Kembali ke Dashboard
        </a>
    </div>
@endsection
