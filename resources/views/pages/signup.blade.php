@extends('layouts.member')

@section('title', 'Daftar Anggota')

@php
    // Kalau ada error validasi, buka langkah yang berisi kolom bermasalah.
    $startStep = $errors->hasAny(['password', 'banom']) ? 3 : ($errors->has('address') ? 2 : 1);
    $steps = [
        1 => ['Data Pribadi', 'Nama dan kontak'],
        2 => ['Domisili', 'Alamat tinggal'],
        3 => ['Banom & Akun', 'Pilihan banom dan password'],
    ];
    $inputClass = 'w-full bg-gray-50 border border-gray-200 rounded-xl px-4 py-3 text-xs sm:text-sm font-semibold outline-none focus:ring-2 focus:ring-green-900';
@endphp

@section('content')
<div class="max-w-3xl mx-auto">

    <div class="text-center mb-6 sm:mb-8">
        <span class="bg-green-900 text-lime-400 text-[10px] font-black px-3 py-1.5 rounded-full uppercase tracking-wider inline-block">Keanggotaan</span>
        <h1 class="font-display text-5xl sm:text-7xl leading-[0.95] text-gray-900 mt-3">PENDAFTARAN ANGGOTA</h1>
        <p class="text-sm sm:text-base font-semibold text-gray-800 mt-2 max-w-xl mx-auto">
            Lengkapi data Anda. Setelah diverifikasi pengurus, NIA terbit otomatis dan bisa dipakai untuk masuk.
        </p>
    </div>

    @if (session('success'))
        <div class="bg-green-900 text-white px-5 py-3.5 rounded-2xl font-bold shadow-lg flex items-center gap-2 mb-4 text-xs sm:text-sm">
            <i class="ph ph-check-circle text-lg"></i> {{ session('success') }}
        </div>
    @endif

    @if ($errors->any())
        <div class="bg-red-50 text-red-800 px-5 py-3.5 rounded-2xl text-xs sm:text-sm font-bold mb-4" role="alert">
            <p class="flex items-center gap-2"><i class="ph ph-warning-circle text-lg"></i> Pendaftaran belum berhasil. Periksa kolom berikut:</p>
            <ul class="list-disc pl-10 mt-1 font-semibold">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="bg-white rounded-[2rem] sm:rounded-[2.5rem] p-6 sm:p-10 shadow-2xl border border-gray-100"
         x-data="signupWizard({{ $startStep }})">

        <!-- Indikator langkah -->
        <div class="flex items-start justify-between mb-8">
            @foreach ($steps as $n => [$title, $sub])
                <div class="flex-1 flex flex-col items-center text-center relative">
                    @if ($n > 1)
                        <span class="absolute top-5 right-1/2 w-full h-0.5 -z-0" :class="step >= {{ $n }} ? 'bg-green-900' : 'bg-gray-200'"></span>
                    @endif
                    <span class="relative z-10 w-10 h-10 rounded-full flex items-center justify-center text-sm font-black transition"
                          :class="step > {{ $n }} ? 'bg-lime-400 text-green-900' : (step === {{ $n }} ? 'bg-green-900 text-lime-400' : 'bg-gray-100 text-gray-400')">
                        <template x-if="step > {{ $n }}"><i class="ph ph-check text-lg"></i></template>
                        <template x-if="step <= {{ $n }}"><span>{{ $n }}</span></template>
                    </span>
                    <p class="text-[11px] sm:text-xs font-black mt-2" :class="step >= {{ $n }} ? 'text-gray-900' : 'text-gray-400'">{{ $title }}</p>
                    <p class="hidden sm:block text-[10px] font-semibold text-gray-500">{{ $sub }}</p>
                </div>
            @endforeach
        </div>

        <form method="POST" action="{{ route('member.register') }}" autocomplete="off" x-ref="form" novalidate
              @keydown.enter="if (step < 3 && $event.target.tagName !== 'TEXTAREA') { $event.preventDefault(); next(); }">
            @csrf

            <!-- Langkah 1 -->
            <div x-show="step === 1" data-step="1" class="space-y-4">
                <div>
                    <label for="name" class="block text-xs font-bold text-gray-700 uppercase mb-1">Nama Lengkap</label>
                    <input id="name" type="text" name="name" value="{{ old('name') }}" required placeholder="Sesuai KTP / KK" class="{{ $inputClass }}">
                </div>
                <div>
                    <label for="email" class="block text-xs font-bold text-gray-700 uppercase mb-1">Email</label>
                    <input id="email" type="email" name="email" value="{{ old('email') }}" required placeholder="email@domain.com" autocomplete="off" class="{{ $inputClass }}">
                </div>
                <div>
                    <label for="phone" class="block text-xs font-bold text-gray-700 uppercase mb-1">No. WhatsApp</label>
                    <input id="phone" type="tel" inputmode="tel" name="phone" value="{{ old('phone') }}" required placeholder="08xxxxxxxxxx" class="{{ $inputClass }}">
                    <p class="text-[11px] text-gray-500 font-medium mt-1">Nomor ini juga bisa dipakai untuk masuk ke akun.</p>
                </div>
            </div>

            <!-- Langkah 2 -->
            <div x-show="step === 2" x-cloak data-step="2" class="space-y-4">
                <div>
                    <label for="address" class="block text-xs font-bold text-gray-700 uppercase mb-1">Alamat Lengkap</label>
                    <textarea id="address" name="address" rows="4" required placeholder="Dusun, RT/RW, desa" class="{{ $inputClass }}">{{ old('address') }}</textarea>
                </div>
            </div>

            <!-- Langkah 3 -->
            <div x-show="step === 3" x-cloak data-step="3" class="space-y-4">
                <div>
                    <label for="banom" class="block text-xs font-bold text-gray-700 uppercase mb-1">Pilihan Banom</label>
                    <select id="banom" name="banom" required class="{{ $inputClass }}">
                        @foreach (['IPNU' => 'IPNU (Pelajar Putra)', 'IPPNU' => 'IPPNU (Pelajar Putri)', 'Ansor' => 'GP Ansor / Banser', 'Fatayat' => 'Fatayat NU', 'Muslimat' => 'Muslimat NU', 'NU' => 'Nahdlatul Ulama'] as $value => $label)
                            <option value="{{ $value }}" @selected(old('banom') === $value)>{{ $label }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <div class="flex items-center justify-between mb-1">
                        <label for="password" class="block text-xs font-bold text-gray-700 uppercase">Password</label>
                        <button type="button" @click="show = !show" class="text-[11px] font-black text-green-900 hover:text-green-700" x-text="show ? 'Sembunyikan' : 'Tampilkan'"></button>
                    </div>
                    <input id="password" :type="show ? 'text' : 'password'" name="password" required minlength="8" placeholder="Minimal 8 karakter" autocomplete="new-password" class="{{ $inputClass }}">
                </div>
                <div>
                    <label for="password_confirmation" class="block text-xs font-bold text-gray-700 uppercase mb-1">Ulangi Password</label>
                    <input id="password_confirmation" :type="show ? 'text' : 'password'" name="password_confirmation" required placeholder="Ulangi password" autocomplete="new-password" class="{{ $inputClass }}">
                </div>
            </div>

            <!-- Tombol -->
            <div class="flex items-center justify-between gap-3 mt-8">
                <button type="button" x-show="step > 1" @click="prev()" class="bg-gray-100 hover:bg-gray-200 text-gray-800 text-xs sm:text-sm font-black px-5 sm:px-7 py-3.5 rounded-full transition flex items-center gap-2">
                    <i class="ph ph-arrow-left"></i> Kembali
                </button>
                <span x-show="step === 1"></span>

                <button type="button" x-show="step < 3" @click="next()" class="bg-gray-900 hover:bg-green-800 text-white text-xs sm:text-sm font-black px-6 sm:px-8 py-3.5 rounded-full transition flex items-center gap-2">
                    Lanjut <i class="ph ph-arrow-right"></i>
                </button>

                <button type="submit" x-show="step === 3" x-cloak class="bg-lime-400 hover:bg-lime-300 text-gray-900 text-xs sm:text-sm font-black px-6 sm:px-8 py-3.5 rounded-full transition flex items-center gap-2 shadow-md">
                    <i class="ph ph-paper-plane-tilt"></i> Kirim Pendaftaran
                </button>
            </div>
        </form>

        <p class="text-center text-xs font-semibold text-gray-600 mt-6">
            Sudah punya akun? <a href="{{ route('member.login') }}" class="font-black text-green-900 hover:text-green-700">Masuk di sini</a>
        </p>
    </div>
</div>
@endsection

@push('scripts')
<script>
    document.addEventListener('alpine:init', () => {
        Alpine.data('signupWizard', (start = 1) => ({
            step: start,
            show: false,

            // Cek semua kolom wajib di langkah yang sedang tampil sebelum lanjut.
            valid() {
                const fields = this.$refs.form.querySelectorAll(`[data-step='${this.step}'] [required]`);
                return Array.from(fields).every((el) => el.reportValidity());
            },
            next() { if (this.valid() && this.step < 3) this.step++; },
            prev() { if (this.step > 1) this.step--; },
        }));
    });
</script>
@endpush
