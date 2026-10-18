@extends('layouts.member')

@section('title', $title ?? 'Layanan Anggota')

@section('content')
@php
    $user = $user ?? auth()->user();
    $member = $member ?? $user->member;
    $nia = $user->nia ?: $member?->nia;
    $status = $member?->status ?: $user->status;
    $page = $page ?? request()->segment(2);
@endphp

<style>
    .nm-service {
        font-family: 'DM Sans', sans-serif;
        color: #1c2922;
    }

    .nm-service .panel {
        background: #fff;
        border: 1px solid #e1e7df;
        border-radius: 18px;
    }

    .nm-service .muted {
        color: #6a796d;
    }

    .nm-service .field-label {
        display: block;
        font-size: 12px;
        font-weight: 700;
        margin-bottom: 8px;
        color: #425a49;
    }

    .nm-service .field-input {
        display: block;
        width: 100%;
        min-height: 46px;
        padding: 11px 14px;
        background: #fbfcfa;
        color: #1c2922;
        border: 1px solid #dce4db;
        border-radius: 10px;
        outline: none;
        font-size: 14px;
    }

    .nm-service .field-input:focus {
        border-color: #183c2f;
        box-shadow: 0 0 0 3px rgba(24, 60, 47, .1);
    }

    .nm-service .field-input[readonly] {
        background: #f0f3ef;
        color: #526558;
    }

    .nm-service .action {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 9px;
        padding: 12px 18px;
        background: #183c2f;
        color: #fff;
        font-size: 13px;
        font-weight: 750;
        border-radius: 10px;
        text-decoration: none;
    }

    .nm-service .action-outline {
        background: #fff;
        border: 1px solid #d4dfd6;
        color: #183c2f;
    }

    .nm-service .detail {
        padding: 14px 0;
        border-bottom: 1px solid #e9eee8;
    }

    .nm-service .detail:last-child {
        border-bottom: none;
    }

    .nm-service .detail dt {
        font-size: 12px;
        color: #6a796d;
        margin-bottom: 6px;
    }

    .nm-service .detail dd {
        font-size: 14px;
        font-weight: 750;
        overflow-wrap: anywhere;
    }
</style>

<div class="nm-service mx-auto max-w-6xl pb-12">
    <header class="mb-7 flex flex-wrap items-end justify-between gap-4">
        <div>
            <p class="mb-2 text-xs font-bold uppercase tracking-[.16em] text-[#56735e]">
                Portal Anggota / {{ $title }}
            </p>

            <h1 class="text-3xl font-bold tracking-tight sm:text-4xl">
                {{ $title }}
            </h1>

            <p class="muted mt-2 text-sm">
                Layanan keanggotaan Pengurus Ranting NU Lesmana.
            </p>
        </div>

        <a href="{{ route('member.dashboard') }}" class="action action-outline">
            <i class="ph ph-arrow-left text-lg"></i>
            Dashboard
        </a>
    </header>

    @if (session('success'))
        <div class="mb-5 rounded-xl border border-[#bfd8c5] bg-[#edf6ee] p-4 text-sm font-semibold text-[#183c2f]" role="status">
            <i class="ph ph-check-circle mr-1"></i>
            {{ session('success') }}
        </div>
    @endif

    @if ($page === 'data')
        <div class="grid items-start gap-5 lg:grid-cols-12">
            <section class="panel p-6 sm:p-8 lg:col-span-7">
                <div class="border-b border-[#e8ede7] pb-5">
                    <h2 class="text-xl font-bold">Edit Data Pribadi</h2>
                    <p class="muted mt-2 text-sm leading-6">
                        Nama, nomor telepon, dan alamat akan diperbarui di profil anggota.
                    </p>
                </div>

                @if ($errors->any())
                    <div class="mt-5 rounded-xl border border-red-200 bg-red-50 px-4 py-3 text-sm text-red-700" role="alert">
                        <p class="font-bold">Periksa kembali data berikut:</p>
                        <ul class="mt-2 list-disc space-y-1 pl-5">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                @if ($member)
                    <form method="POST" action="{{ route('member.data.update') }}" class="mt-6 space-y-5">
                        @csrf
                        @method('PATCH')

                        <div>
                            <label for="member-name" class="field-label">Nama lengkap</label>
                            <input
                                id="member-name"
                                name="name"
                                type="text"
                                value="{{ old('name', $member->name ?: $user->name) }}"
                                class="field-input"
                                maxlength="100"
                                autocomplete="name"
                                required
                            >
                        </div>

                        <div>
                            <label for="member-phone" class="field-label">Nomor telepon</label>
                            <input
                                id="member-phone"
                                name="phone"
                                type="tel"
                                value="{{ old('phone', $member->phone) }}"
                                class="field-input"
                                maxlength="30"
                                placeholder="Contoh: 08xxxxxxxxxx"
                                autocomplete="tel"
                            >
                        </div>

                        <div>
                            <label for="member-address" class="field-label">Alamat</label>
                            <textarea
                                id="member-address"
                                name="address"
                                rows="4"
                                maxlength="500"
                                class="field-input resize-y"
                                placeholder="Alamat tempat tinggal"
                                autocomplete="street-address"
                            >{{ old('address', $member->address) }}</textarea>
                        </div>

                        <div class="flex flex-wrap items-center gap-3 pt-2">
                            <button type="submit" class="action">
                                <i class="ph ph-floppy-disk text-lg"></i>
                                Simpan Perubahan
                            </button>

                            <span class="muted text-xs">
                                Perubahan nama juga akan tampil di KIA.
                            </span>
                        </div>
                    </form>
                @else
                    <p class="mt-6 rounded-xl bg-[#f1f4f0] p-4 text-sm">
                        Akun ini belum terhubung ke data anggota. Hubungi pengurus untuk verifikasi.
                    </p>
                @endif
            </section>

            <aside class="panel p-6 sm:p-8 lg:col-span-5">
                <div class="flex items-center gap-3 border-b border-[#e8ede7] pb-5">
                    <i class="ph ph-shield-check text-2xl text-[#183c2f]"></i>
                    <div>
                        <h2 class="font-bold">Data Keanggotaan</h2>
                        <p class="muted text-xs">Dikelola oleh pengurus</p>
                    </div>
                </div>

                <dl class="mt-2">
                    <div class="detail">
                        <dt>NIA</dt>
                        <dd class="font-mono">{{ $nia ?: 'Belum tersedia' }}</dd>
                    </div>

                    <div class="detail">
                        <dt>Banom</dt>
                        <dd>{{ $member?->banom ?: 'Belum ditentukan' }}</dd>
                    </div>

                    <div class="detail">
                        <dt>Status</dt>
                        <dd>{{ $status === 'approved' ? 'Terverifikasi' : ucfirst($status ?? 'pending') }}</dd>
                    </div>

                    <div class="detail">
                        <dt>Email akun</dt>
                        <dd>{{ $user->email }}</dd>
                    </div>
                </dl>

                <p class="muted mt-5 text-xs leading-6">
                    NIA, banom, dan status tidak dapat diedit anggota. Perubahan email dan password
                    tersedia melalui Pengaturan Akun.
                </p>

                <a href="{{ route('member.pengaturan') }}" class="action action-outline mt-5">
                    <i class="ph ph-gear text-lg"></i>
                    Pengaturan Akun
                </a>
            </aside>
        </div>

    @elseif ($page === 'infaq')
        <section class="panel p-6 sm:p-8">
            <div class="flex items-center gap-4 border-b border-[#e8ede7] pb-6">
                <i class="ph ph-receipt text-3xl text-[#183c2f]"></i>
                <div>
                    <h2 class="text-lg font-bold">Riwayat Infaq</h2>
                    <p class="muted mt-1 text-sm">Kontribusi yang tercatat atas nama anggota.</p>
                </div>
            </div>

            <div class="py-12 text-center">
                <i class="ph ph-receipt text-4xl text-[#7f9986]"></i>
                <h3 class="mt-4 font-bold">Riwayat belum terhubung</h3>
                <p class="muted mx-auto mt-2 max-w-lg text-sm leading-7">
                    Data transaksi perlu dihubungkan ke akun anggota sebelum riwayat pribadi bisa ditampilkan.
                    Belum ada nominal yang bisa diverifikasi di halaman ini.
                </p>
            </div>
        </section>

    @elseif ($page === 'notifikasi')
        <section class="panel p-6 sm:p-8">
            <div class="flex items-center gap-4 border-b border-[#e8ede7] pb-6">
                <i class="ph ph-bell text-3xl text-[#183c2f]"></i>
                <div>
                    <h2 class="text-lg font-bold">Notifikasi Anggota</h2>
                    <p class="muted mt-1 text-sm">Pemberitahuan khusus untuk akun Anda.</p>
                </div>
            </div>

            <div class="py-12 text-center">
                <i class="ph ph-bell-slash text-4xl text-[#7f9986]"></i>
                <h3 class="mt-4 font-bold">Belum ada notifikasi yang terhubung</h3>
                <p class="muted mx-auto mt-2 max-w-lg text-sm leading-7">
                    Sistem notifikasi pribadi belum tersedia. Anda tetap bisa mengikuti kabar terbaru
                    melalui halaman Berita & Agenda.
                </p>
                <a href="{{ route('public.news.index') }}" class="action mt-5">
                    Berita & Agenda
                    <i class="ph ph-arrow-up-right"></i>
                </a>
            </div>
        </section>

    @elseif ($page === 'pengaturan')
        <div class="grid gap-5 sm:grid-cols-2">
            <section class="panel p-6 sm:p-8">
                <i class="ph ph-user-gear text-3xl text-[#183c2f]"></i>
                <h2 class="mt-5 text-lg font-bold">Profil dan Keamanan</h2>
                <p class="muted mt-2 text-sm leading-7">
                    Perbarui email dan password menggunakan fitur profil Laravel.
                </p>

                @if (Route::has('profile.edit'))
                    <a href="{{ route('profile.edit') }}" class="action mt-6">
                        Buka Pengaturan Profil
                        <i class="ph ph-arrow-up-right"></i>
                    </a>
                @else
                    <p class="muted mt-5 text-sm">Route pengaturan profil belum aktif.</p>
                @endif
            </section>

            <section class="panel p-6 sm:p-8">
                <i class="ph ph-camera text-3xl text-[#183c2f]"></i>
                <h2 class="mt-5 text-lg font-bold">Foto Kartu Anggota</h2>
                <p class="muted mt-2 text-sm leading-7">
                    Kelola foto yang digunakan untuk KIA digital dan kartu cetak.
                </p>
                <a href="{{ route('member.kia') }}" class="action mt-6">
                    Buka KIA Digital
                    <i class="ph ph-arrow-up-right"></i>
                </a>
            </section>

            <section class="panel p-6 sm:col-span-2 sm:p-8">
                <h2 class="text-lg font-bold">Keluar dari Akun</h2>
                <p class="muted mt-2 text-sm">Akhiri sesi login di perangkat ini.</p>
                <form method="POST" action="{{ route('logout') }}" class="mt-5">
                    @csrf
                    <button
                        type="submit"
                        class="rounded-xl border border-red-200 px-5 py-3 text-sm font-bold text-red-700"
                    >
                        <i class="ph ph-sign-out mr-1"></i>
                        Keluar
                    </button>
                </form>
            </section>
        </div>

    @else
        <section class="panel p-6">
            <h2 class="font-bold">Halaman tidak ditemukan</h2>
            <a href="{{ route('member.dashboard') }}" class="action mt-4">Dashboard</a>
        </section>
    @endif
</div>
@endsection
