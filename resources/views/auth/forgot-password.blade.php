@extends('layouts.auth')

@section('title', 'Lupa Password')

@section('auth')
    <span class="bg-green-100 text-green-800 text-[10px] font-black px-3 py-1 rounded-full uppercase tracking-wider inline-block">Bantuan Akun</span>
    <h1 class="font-display text-4xl sm:text-5xl text-gray-900 mt-2">LUPA PASSWORD</h1>
    <p class="text-xs sm:text-sm text-gray-600 font-semibold mt-1">Masukkan email yang terdaftar. Kami kirim tautan untuk membuat password baru.</p>

    @if (session('status'))
        <p class="mt-5 bg-green-100 text-green-900 text-xs font-bold rounded-xl px-4 py-2.5 flex items-center gap-2" role="status">
            <i class="ph ph-check-circle text-base"></i> {{ session('status') }}
        </p>
    @endif

    <form method="POST" action="{{ route('password.email') }}" class="mt-6 space-y-4">
        @csrf
        <div>
            <label for="email" class="block text-xs font-bold text-gray-700 uppercase mb-1">Alamat Email</label>
            <input id="email" name="email" type="email" value="{{ old('email') }}" required autofocus autocomplete="email"
                   class="w-full bg-gray-50 border border-gray-200 rounded-xl px-4 py-3 text-xs sm:text-sm font-semibold outline-none focus:ring-2 focus:ring-green-900">
            @error('email')
                <p class="mt-2 bg-red-50 text-red-700 text-xs font-bold rounded-xl px-4 py-2.5" role="alert">{{ $message }}</p>
            @enderror
        </div>

        <button type="submit" class="w-full bg-gray-900 hover:bg-green-800 text-white font-black py-3.5 sm:py-4 rounded-xl transition text-xs sm:text-sm flex items-center justify-center gap-2">
            <i class="ph ph-paper-plane-tilt text-base sm:text-lg"></i> Kirim Tautan Reset
        </button>
    </form>

    <a href="{{ route('member.login') }}" class="inline-flex items-center gap-1 mt-5 text-xs font-black text-green-900 hover:text-green-700">
        <i class="ph ph-arrow-left"></i> Kembali ke halaman masuk
    </a>
@endsection
