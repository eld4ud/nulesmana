@extends('layouts.member')

@section('title', 'Masuk Anggota')

@php
    $fields = [
        'email' => [
            'tab' => 'Email', 'label' => 'Alamat Email', 'placeholder' => 'nama@email.com',
            'example' => 'warga@email.com', 'inputmode' => 'email', 'autocomplete' => 'email',
        ],
        'phone' => [
            'tab' => 'No. HP', 'label' => 'Nomor HP / WhatsApp', 'placeholder' => '0812xxxxxxxx',
            'example' => '081234567890', 'inputmode' => 'tel', 'autocomplete' => 'tel',
        ],
        'nia' => [
            'tab' => 'NIA', 'label' => 'Nomor Induk Anggota', 'placeholder' => 'LSM-26-0001',
            'example' => 'LSM-26-0001', 'inputmode' => 'text', 'autocomplete' => 'off',
        ],
        'username' => [
            'tab' => 'Username', 'label' => 'Username', 'placeholder' => 'username Anda',
            'example' => 'ahmad.fauzi', 'inputmode' => 'text', 'autocomplete' => 'username',
        ],
    ];
@endphp

@section('content')
<div class="grid grid-cols-1 lg:grid-cols-5 gap-6 sm:gap-8 items-stretch">

    <!-- KIRI: sambutan -->
    <div class="lg:col-span-2 bg-green-900 text-white rounded-[2rem] sm:rounded-[2.5rem] p-6 sm:p-10 shadow-2xl flex flex-col justify-between gap-10">
        <div>
            <span class="bg-lime-400 text-black text-[10px] font-black px-3 py-1 rounded-full uppercase tracking-wider inline-block">Portal Anggota</span>
            <h1 class="font-display text-5xl sm:text-6xl leading-[0.95] mt-3">MASUK KE AKUN ANGGOTA</h1>
            <p class="text-sm text-green-200 font-semibold mt-3 leading-relaxed max-w-sm">
                Lihat kartu anggota, perbarui data diri, dan pantau riwayat infaq Anda di satu tempat.
            </p>
        </div>

        <!-- Contoh KIA -->
        <div class="bg-white/10 border border-white/20 rounded-2xl p-4 max-w-xs" aria-hidden="true">
            <div class="flex items-center gap-2 mb-3">
                <div class="w-8 h-8 rounded-full bg-lime-400 text-green-900 flex items-center justify-center font-black text-xs">NU</div>
                <span class="text-xs font-black">Kartu Identitas Anggota</span>
            </div>
            <div class="flex gap-3">
                <div class="w-14 h-[4.5rem] rounded-xl bg-white/20 flex items-center justify-center text-3xl text-green-200"><i class="ph ph-user"></i></div>
                <div class="min-w-0">
                    <p class="text-sm font-extrabold">Nama Anggota</p>
                    <p class="text-[11px] text-green-200 font-semibold">Banom</p>
                    <p class="font-mono text-sm font-bold text-lime-400 mt-2">LSM-26-0001</p>
                </div>
            </div>
            <p class="text-[10px] text-green-200/80 mt-3 italic">Contoh tampilan. NIA bisa dipakai untuk masuk.</p>
        </div>
    </div>

    <!-- KANAN: form -->
    <div class="lg:col-span-3 bg-white rounded-[2rem] sm:rounded-[2.5rem] p-6 sm:p-10 shadow-2xl border border-gray-100"
         x-data="{ type: @js(old('login_type', 'email')), show: false, fields: @js($fields) }">

        <h2 class="font-display text-4xl sm:text-5xl text-gray-900">LOGIN ANGGOTA</h2>
        <p class="text-xs sm:text-sm text-gray-600 font-semibold mt-1">Pilih salah satu cara masuk, lalu isi kolomnya.</p>

        <form method="POST" action="{{ route('member.login.store') }}" class="mt-6 space-y-4" novalidate>
            @csrf
            <input type="hidden" name="login_type" :value="type">

            <div>
                <p class="block text-xs font-bold text-gray-700 uppercase mb-2">Masuk dengan</p>
                <div class="flex flex-wrap gap-2">
                    <template x-for="(field, key) in fields" :key="key">
                        <button type="button" @click="type = key" :aria-pressed="(type === key).toString()"
                                :class="type === key ? 'bg-green-900 text-white' : 'bg-gray-100 hover:bg-gray-200 text-gray-700'"
                                class="text-[11px] sm:text-xs font-black px-4 sm:px-5 py-2.5 rounded-full transition"
                                x-text="field.tab"></button>
                    </template>
                </div>
            </div>

            <div>
                <label for="login" class="block text-xs font-bold text-gray-700 uppercase mb-1" x-text="fields[type].label"></label>
                <input id="login" name="login" type="text" value="{{ old('login') }}" required autofocus
                       :placeholder="fields[type].placeholder" :inputmode="fields[type].inputmode" :autocomplete="fields[type].autocomplete"
                       class="w-full bg-gray-50 border border-gray-200 rounded-xl px-4 py-3 text-xs sm:text-sm font-semibold outline-none focus:ring-2 focus:ring-green-900">
                <p class="text-[11px] text-gray-500 font-medium mt-1.5" x-text="'Contoh: ' + fields[type].example"></p>
                @error('login')
                    <p class="mt-2 bg-red-50 text-red-700 text-xs font-bold rounded-xl px-4 py-2.5 flex items-center gap-2" role="alert">
                        <i class="ph ph-warning-circle text-base"></i> {{ $message }}
                    </p>
                @enderror
            </div>

            <div>
                <div class="flex items-center justify-between mb-1">
                    <label for="password" class="block text-xs font-bold text-gray-700 uppercase">Password</label>
                    <button type="button" @click="show = !show" class="text-[11px] font-black text-green-900 hover:text-green-700" x-text="show ? 'Sembunyikan' : 'Tampilkan'"></button>
                </div>
                <input id="password" name="password" :type="show ? 'text' : 'password'" required autocomplete="current-password"
                       class="w-full bg-gray-50 border border-gray-200 rounded-xl px-4 py-3 text-xs sm:text-sm font-semibold outline-none focus:ring-2 focus:ring-green-900">
                @error('password')
                    <p class="mt-2 bg-red-50 text-red-700 text-xs font-bold rounded-xl px-4 py-2.5" role="alert">{{ $message }}</p>
                @enderror
            </div>

            <div class="flex items-center justify-between">
                <label class="flex items-center gap-2 text-xs font-semibold text-gray-700">
                    <input type="checkbox" name="remember" value="1" class="rounded border-gray-300 text-green-900 focus:ring-green-900">
                    Ingat saya
                </label>
                @if (Route::has('password.request'))
                    <a href="{{ route('password.request') }}" class="text-xs font-black text-green-900 hover:text-green-700">Lupa password?</a>
                @endif
            </div>

            <button type="submit" class="w-full bg-gray-900 hover:bg-green-800 text-white font-black py-3.5 sm:py-4 rounded-xl transition text-xs sm:text-sm flex items-center justify-center gap-2">
                <i class="ph ph-sign-in text-base sm:text-lg"></i> Masuk ke Portal
            </button>
        </form>

        <div class="mt-6 pt-5 border-t border-gray-100 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-2 text-xs font-semibold text-gray-600">
            <span>Belum punya akun? <a href="{{ route('home') }}#daftar" class="font-black text-green-900 hover:text-green-700">Daftar anggota</a></span>
            <span>Pengurus? <a href="{{ route('login') }}" class="font-black text-green-900 hover:text-green-700">Masuk sebagai admin</a></span>
        </div>
    </div>
</div>
@endsection
