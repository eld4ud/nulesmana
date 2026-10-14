@extends('layouts.auth')

@section('title', 'Password Baru')

@section('auth')
    <span class="bg-green-100 text-green-800 text-[10px] font-black px-3 py-1 rounded-full uppercase tracking-wider inline-block">Bantuan Akun</span>
    <h1 class="font-display text-4xl sm:text-5xl text-gray-900 mt-2">PASSWORD BARU</h1>
    <p class="text-xs sm:text-sm text-gray-600 font-semibold mt-1">Pilih password yang belum pernah Anda pakai di tempat lain.</p>

    <form method="POST" action="{{ route('password.store') }}" class="mt-6 space-y-4" x-data="{ show: false }">
        @csrf
        <input type="hidden" name="token" value="{{ $request->route('token') }}">

        <div>
            <label for="email" class="block text-xs font-bold text-gray-700 uppercase mb-1">Alamat Email</label>
            <input id="email" name="email" type="email" value="{{ old('email', $request->email) }}" required autocomplete="email"
                   class="w-full bg-gray-50 border border-gray-200 rounded-xl px-4 py-3 text-xs sm:text-sm font-semibold outline-none focus:ring-2 focus:ring-green-900">
            @error('email')
                <p class="mt-2 bg-red-50 text-red-700 text-xs font-bold rounded-xl px-4 py-2.5" role="alert">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <div class="flex items-center justify-between mb-1">
                <label for="password" class="block text-xs font-bold text-gray-700 uppercase">Password Baru</label>
                <button type="button" @click="show = !show" class="text-[11px] font-black text-green-900 hover:text-green-700" x-text="show ? 'Sembunyikan' : 'Tampilkan'"></button>
            </div>
            <input id="password" name="password" :type="show ? 'text' : 'password'" required autocomplete="new-password"
                   class="w-full bg-gray-50 border border-gray-200 rounded-xl px-4 py-3 text-xs sm:text-sm font-semibold outline-none focus:ring-2 focus:ring-green-900">
            @error('password')
                <p class="mt-2 bg-red-50 text-red-700 text-xs font-bold rounded-xl px-4 py-2.5" role="alert">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label for="password_confirmation" class="block text-xs font-bold text-gray-700 uppercase mb-1">Ulangi Password Baru</label>
            <input id="password_confirmation" name="password_confirmation" :type="show ? 'text' : 'password'" required autocomplete="new-password"
                   class="w-full bg-gray-50 border border-gray-200 rounded-xl px-4 py-3 text-xs sm:text-sm font-semibold outline-none focus:ring-2 focus:ring-green-900">
        </div>

        <button type="submit" class="w-full bg-gray-900 hover:bg-green-800 text-white font-black py-3.5 sm:py-4 rounded-xl transition text-xs sm:text-sm">
            Simpan Password Baru
        </button>
    </form>
@endsection
