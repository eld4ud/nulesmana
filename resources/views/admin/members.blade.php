
@extends('layouts.admin')

@section('title', 'Kelola Anggota')
@section('heading', 'Kelola Anggota')
@section('subtitle', 'Verifikasi pendaftaran, lihat foto anggota, dan cetak KIA digital.')

@section('content')

@php
    $pendingMembers = $pendingMembers ?? collect();
    $approvedMembers = $approvedMembers ?? collect();

    $cardData = $approvedMembers->map(fn ($member) => [
        'id' => (int) $member->id,
        'name' => (string) $member->name,
        'nia' => (string) ($member->nia ?: 'Belum tersedia'),
        'banom' => (string) $member->banom,
        'gender' => (string) ($member->gender ?: 'Belum diisi'),
        'photo' => $member->photo
            ? \Illuminate\Support\Facades\Storage::disk('public')->url($member->photo)
            : '',
    ])->values();
@endphp

<style>
    .members-page {
        color: #183C2F;
        font-family: 'DM Sans', sans-serif;
    }

    .members-page [hidden],
    .member-overlay[hidden],
    .member-overlay [hidden] {
        display: none !important;
    }

    .members-panel {
        background: white;
        border: 1px solid #E0E7DD;
        border-radius: 23px;
        padding: 24px;
        margin-bottom: 22px;
    }

    .members-heading {
        font-size: 19px;
        font-weight: 800;
        margin-bottom: 5px;
    }

    .members-description {
        color: #748477;
        font-size: 12px;
        line-height: 1.7;
    }

    .members-avatar {
        width: 48px;
        height: 48px;
        border-radius: 13px;
        background: #183C2F;
        color: white;
        display: flex;
        align-items: center;
        justify-content: center;
        object-fit: cover;
        flex-shrink: 0;
        font-size: 17px;
        font-weight: 800;
    }

    .members-pending {
        background: #F9FAF7;
        border: 1px solid #E4EBE1;
        border-radius: 17px;
        padding: 14px;
        display: flex;
        align-items: center;
        gap: 12px;
        min-width: 0;
    }

    .members-name {
        font-size: 13px;
        font-weight: 800;
        overflow-wrap: anywhere;
    }

    .members-meta {
        font-size: 11px;
        color: #748477;
        margin-top: 4px;
        line-height: 1.6;
    }

    .members-button {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 7px;
        padding: 10px 14px;
        border-radius: 10px;
        font-size: 11px;
        font-weight: 800;
        border: 1px solid #DDE5DA;
        background: white;
        color: #183C2F;
        cursor: pointer;
    }

    .members-button.primary {
        background: #183C2F;
        border-color: #183C2F;
        color: white;
    }

    .members-button.danger {
        color: #AD4040;
        background: #FFF1F0;
        border-color: #F1D5D1;
    }

    .members-button:hover {
        filter: brightness(.96);
    }

    .members-card {
        background: #FFFFFF;
        border: 1px solid #E0E7DE;
        border-radius: 20px;
        padding: 19px;
        text-align: left;
        width: 100%;
        cursor: pointer;
        transition: transform .2s, box-shadow .2s;
    }

    .members-card:hover {
        transform: translateY(-3px);
        box-shadow: 0 12px 25px rgba(24,60,47,.07);
    }

    /* MODAL */
    .member-overlay {
        position: fixed;
        inset: 0;
        z-index: 9999;
        background: rgba(8,22,15,.78);
        backdrop-filter: blur(6px);
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 24px 15px;
        overflow-y: auto;
    }

    .member-modal {
        width: min(100%, 680px);
        margin: auto;
        position: relative;
    }

    .member-close {
        position: absolute;
        top: -45px;
        right: 0;
        width: 37px;
        height: 37px;
        background: rgba(255,255,255,.18);
        color: white;
        border-radius: 50%;
        font-size: 23px;
        border: 0;
        cursor: pointer;
    }

    /* FLIP CARD */
    .member-card-scene {
        perspective: 1400px;
        width: 100%;
        aspect-ratio: 1.586;
    }

    .member-card-inner {
        width: 100%;
        height: 100%;
        position: relative;
        transform-style: preserve-3d;
        transition: transform .8s cubic-bezier(.2,.75,.2,1);
    }

    .member-card-inner.flipped {
        transform: rotateY(180deg);
    }

    .member-card-face {
        position: absolute;
        inset: 0;
        padding: 5%;
        background: #EDF5ED;
        color: #183C2F;
        border-radius: 20px;
        border: 1px solid #CDDFCE;
        box-shadow: 0 22px 60px rgba(0,0,0,.25);
        backface-visibility: hidden;
        -webkit-backface-visibility: hidden;
        display: flex;
        flex-direction: column;
        overflow: hidden;
    }

    .member-card-face::before {
        content: '';
        position: absolute;
        inset: 7px;
        border: 1px solid rgba(175,138,65,.48);
        border-radius: 14px;
        pointer-events: none;
    }

    .member-card-face::after {
        content: '';
        position: absolute;
        inset: 0;
        background: repeating-radial-gradient(
            circle at 82% 88%,
            transparent 0 12px,
            rgba(68,117,80,.09) 13px 14px
        );
        opacity: .6;
        pointer-events: none;
    }

    .member-card-back {
        transform: rotateY(180deg);
    }

    .member-card-top {
        position: relative;
        z-index: 1;
        display: flex;
        justify-content: space-between;
        align-items: center;
        border-bottom: 1px solid #C5D5C8;
        padding-bottom: 3%;
    }

    .member-card-title {
        font: bold clamp(17px, 3vw, 27px) Georgia, serif;
    }

    .member-card-subtitle {
        font-size: clamp(8px, 1.2vw, 11px);
        color: #547260;
        margin-top: 3px;
    }

    .member-card-main {
        position: relative;
        z-index: 1;
        display: flex;
        align-items: center;
        gap: 5%;
        margin: auto 0;
        min-height: 0;
    }

    .member-card-photo {
        width: 24%;
        aspect-ratio: 3 / 4;
        border: 1px solid #B3CAB8;
        border-radius: 8px;
        object-fit: cover;
        flex-shrink: 0;
        background: #DDEBDF;
    }

    .member-card-placeholder {
        width: 24%;
        aspect-ratio: 3 / 4;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 8px;
        background: #D8E8DA;
        border: 1px solid #B3CAB8;
        font-size: clamp(25px, 5vw, 52px);
        font-weight: 800;
        color: #83A08A;
    }

    .member-card-details {
        min-width: 0;
        flex: 1;
    }

    .member-card-key {
        font-size: clamp(7px, 1vw, 10px);
        font-weight: 800;
        color: #748D7A;
        margin-top: 9px;
    }

    .member-card-value {
        font-size: clamp(10px, 1.65vw, 17px);
        font-weight: 800;
        line-height: 1.25;
        overflow-wrap: anywhere;
    }

    .member-card-bottom {
        position: relative;
        z-index: 1;
        margin-top: auto;
        padding-top: 3%;
        border-top: 1px solid #C5D5C8;
        display: flex;
        justify-content: space-between;
        gap: 10px;
        color: #64816B;
        font-size: clamp(8px, 1vw, 10px);
        font-weight: 800;
    }

    .member-card-gold {
        position: absolute;
        inset: auto 0 0;
        height: 5px;
        background: linear-gradient(
            90deg,
            #A8854A,
            #DCC58A,
            #A8854A
        );
    }

    .member-card-instructions {
        position: relative;
        z-index: 1;
        margin: auto 0;
        font-size: clamp(9px, 1.5vw, 13px);
        line-height: 1.7;
    }

    .member-card-instructions p {
        margin-top: 8px;
    }

    .member-modal-actions {
        display: flex;
        flex-wrap: wrap;
        gap: 9px;
        align-items: center;
        margin-top: 19px;
    }

    /* EDIT FOTO */
    .member-photo-dialog {
        background: white;
        color: #183C2F;
        border-radius: 20px;
        padding: 25px;
        width: min(100%, 430px);
        margin: auto;
    }

    .member-photo-dialog label {
        display: block;
        font-size: 12px;
        font-weight: 800;
        margin: 15px 0 7px;
    }

    .member-photo-dialog input,
    .member-photo-dialog select {
        width: 100%;
        border: 1px solid #D8E2D6;
        border-radius: 11px;
        padding: 12px;
        font-size: 13px;
        background: #F8FAF7;
    }

    /* CETAK */
    #member-print-area {
        display: none;
    }

    @media print {
        @page {
            size: A4 portrait;
            margin: 15mm;
        }

        body * {
            visibility: hidden !important;
        }

        #member-print-area,
        #member-print-area * {
            visibility: visible !important;
        }

        #member-print-area {
            display: block !important;
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            background: white;
        }

        .member-print-card {
            width: 85.6mm;
            height: 54mm;
            border: 1px solid #C0D1C0;
            border-bottom: 2mm solid #183C2F;
            background: #EDF5ED;
            border-radius: 3mm;
            padding: 4mm;
            margin-bottom: 8mm;
            overflow: hidden;
            break-inside: avoid;
            color: #183C2F;
        }

        .member-print-card h2 {
            font: bold 15pt Georgia, serif;
            border-bottom: 1px solid #BBCDBB;
            padding-bottom: 2mm;
        }

        .member-print-card p {
            font-size: 8pt;
            line-height: 1.6;
        }

        .member-print-card strong {
            font-size: 9pt;
        }

        .member-print-card img {
            width: 20mm;
            height: 26mm;
            object-fit: cover;
            border-radius: 2mm;
        }

        .member-print-row {
            display: flex;
            align-items: center;
            gap: 5mm;
            margin-top: 5mm;
        }
    }

    @media (max-width: 530px) {
        .member-card-key {
            margin-top: 4px;
        }

        .member-card-instructions p {
            margin-top: 3px;
        }

        .member-modal-actions {
            justify-content: center;
        }
    }

    @media (prefers-reduced-motion: reduce) {
        .member-card-inner {
            transition: none;
        }
    }
</style>

<div class="members-page space-y-6">

    <!-- PENDAFTAR MENUNGGU ACC -->
    <section class="members-panel">

        <div class="mb-5">
            <h2 class="members-heading">
                Antrean Pendaftaran ({{ $pendingMembers->count() }})
            </h2>

            <p class="members-description">
                Periksa identitas, jenis kelamin, dan foto
                sebelum menyetujui pendaftaran.
            </p>
        </div>

        <div class="grid grid-cols-1 xl:grid-cols-2 gap-3">

            @forelse($pendingMembers as $member)

                <article class="members-pending">

                    @if($member->photo)

                        <img
                            src="{{ \Illuminate\Support\Facades\Storage::disk('public')->url($member->photo) }}"
                            alt="Foto {{ $member->name }}"
                            class="members-avatar"
                            loading="lazy"
                        >

                    @else

                        <span class="members-avatar">
                            {{ mb_strtoupper(mb_substr($member->name ?: 'A', 0, 1)) }}
                        </span>

                    @endif

                    <div class="flex-1 min-w-0">

                        <p class="members-name">
                            {{ $member->name }}
                        </p>

                        <p class="members-meta">
                            {{ $member->banom }} •
                            {{ $member->gender ?: 'Belum diisi' }}
                        </p>

                        <p class="members-meta">
                            Menunggu ACC
                        </p>

                    </div>

                    <div class="flex flex-col gap-2">

                        <form
                            method="POST"
                            action="{{ route('admin.members.approve', $member->id) }}"
                        >
                            @csrf
                            @method('PATCH')

                            <button
                                type="submit"
                                class="members-button primary"
                            >
                                ACC
                            </button>
                        </form>

                        <form
                            method="POST"
                            action="{{ route('admin.members.reject', $member->id) }}"
                            onsubmit="return confirm('Tolak pendaftaran anggota ini?')"
                        >
                            @csrf
                            @method('DELETE')

                            <button
                                type="submit"
                                class="members-button danger"
                            >
                                Tolak
                            </button>
                        </form>

                    </div>

                </article>

            @empty

                <p class="text-sm text-gray-500 py-6">
                    Tidak ada pendaftaran yang menunggu ACC.
                </p>

            @endforelse

        </div>
    </section>

    <!-- ANGGOTA RESMI -->
    <section class="members-panel">

        <div class="mb-5">
            <h2 class="members-heading">
                Anggota Resmi ({{ $approvedMembers->count() }})
            </h2>

            <p class="members-description">
                Klik anggota untuk melihat KIA depan-belakang
                dengan animasi flip.
            </p>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-4 gap-4">

            @forelse($approvedMembers as $member)

                <button
                    type="button"
                    class="members-card"
                    data-open-member="{{ $member->id }}"
                >

                    <div class="flex items-center justify-between mb-5">

                        @if($member->photo)

                            <img
                                src="{{ \Illuminate\Support\Facades\Storage::disk('public')->url($member->photo) }}"
                                alt="Foto {{ $member->name }}"
                                class="members-avatar"
                                loading="lazy"
                            >

                        @else

                            <span class="members-avatar">
                                {{ mb_strtoupper(mb_substr($member->name ?: 'A', 0, 1)) }}
                            </span>

                        @endif

                        <i class="ph ph-identification-card text-2xl text-[#9DB0A1]"></i>

                    </div>

                    <p class="members-name">
                        {{ $member->name }}
                    </p>

                    <p class="members-meta">
                        {{ $member->banom }}
                    </p>

                    <p class="members-meta">
                        {{ $member->gender ?: 'Belum diisi' }}
                    </p>

                    <p class="text-xs font-extrabold mt-5">
                        Buka KIA
                        <i class="ph ph-arrow-up-right"></i>
                    </p>

                </button>

            @empty

                <p class="text-sm text-gray-500 col-span-full py-6">
                    Belum ada anggota resmi.
                </p>

            @endforelse

        </div>
    </section>

</div>

<!-- MODAL KIA -->
<div
    id="member-kia-modal"
    class="member-overlay"
    role="dialog"
    aria-modal="true"
    aria-label="Kartu anggota digital"
    hidden
>
    <div class="member-modal">

        <button
            id="member-close"
            type="button"
            class="member-close"
            aria-label="Tutup KIA"
        >
            &times;
        </button>

        <div class="member-card-scene">

            <div
                id="member-card-inner"
                class="member-card-inner"
            >

                <!-- DEPAN -->
                <section class="member-card-face">

                    <header class="member-card-top">
                        <div>
                            <h2 class="member-card-title">
                                Kartu Anggota
                            </h2>

                            <p class="member-card-subtitle">
                                Pengurus Ranting NU Lesmana
                            </p>
                        </div>

                        <span class="text-[#B29455] text-2xl">
                            ✦
                        </span>
                    </header>

                    <div class="member-card-main">

                        <img
                            id="card-photo"
                            class="member-card-photo"
                            alt="Foto anggota"
                            hidden
                        >

                        <div
                            id="card-initial"
                            class="member-card-placeholder"
                        >
                            A
                        </div>

                        <div class="member-card-details">

                            <p class="member-card-key">
                                NAMA LENGKAP
                            </p>

                            <p
                                id="card-name"
                                class="member-card-value"
                            >
                                -
                            </p>

                            <p class="member-card-key">
                                NOMOR INDUK ANGGOTA
                            </p>

                            <p
                                id="card-nia"
                                class="member-card-value"
                            >
                                -
                            </p>

                            <p class="member-card-key">
                                BADAN OTONOM
                            </p>

                            <p
                                id="card-banom"
                                class="member-card-value"
                            >
                                -
                            </p>

                            <p class="member-card-key">
                                JENIS KELAMIN
                            </p>

                            <p
                                id="card-gender"
                                class="member-card-value"
                            >
                                -
                            </p>

                        </div>
                    </div>

                    <footer class="member-card-bottom">
                        <span>IDENTITAS KEANGGOTAAN</span>
                        <span>NU LESMANA</span>
                    </footer>

                    <span class="member-card-gold"></span>
                </section>

                <!-- BELAKANG -->
                <section class="member-card-face member-card-back">

                    <header class="member-card-top">
                        <div>
                            <h2 class="member-card-title">
                                Kartu Anggota
                            </h2>

                            <p class="member-card-subtitle">
                                Perawatan dan Informasi
                            </p>
                        </div>

                        <span class="text-[#B29455] text-2xl">
                            ✦
                        </span>
                    </header>

                    <div class="member-card-instructions">

                        <p class="font-extrabold">
                            Petunjuk Perawatan
                        </p>

                        <p>
                            • Simpan kartu dengan baik.
                        </p>

                        <p>
                            • Hindarkan dari panas,
                            air, dan lipatan.
                        </p>

                        <p>
                            • Jika hilang atau rusak,
                            hubungi pengurus NU Lesmana.
                        </p>

                        <p>
                            Nama:
                            <strong id="card-back-name">-</strong>
                        </p>

                        <p>
                            NIA:
                            <strong id="card-back-nia">-</strong>
                        </p>

                        <p>
                            Jika ditemukan, mohon serahkan
                            kepada pengurus organisasi.
                        </p>

                    </div>

                    <footer class="member-card-bottom">
                        <span>KARTU ANGGOTA DIGITAL</span>
                        <span>NU LESMANA</span>
                    </footer>

                    <span class="member-card-gold"></span>
                </section>

            </div>
        </div>

        <!-- TOMBOL AKSI -->
        <div class="member-modal-actions">

            <button
                id="member-flip"
                type="button"
                class="members-button primary"
            >
                <i class="ph ph-arrows-clockwise"></i>
                <span id="member-flip-text">
                    Lihat Belakang
                </span>
            </button>

            <button
                id="member-print"
                type="button"
                class="members-button"
            >
                <i class="ph ph-printer"></i>
                Cetak KIA
            </button>

            <button
                id="member-edit"
                type="button"
                class="members-button"
            >
                <i class="ph ph-camera"></i>
                Ubah Foto / Gender
            </button>

            <form
                id="member-delete"
                method="POST"
                onsubmit="return confirm('Hapus anggota ini secara permanen?')"
            >
                @csrf
                @method('DELETE')

                <button
                    type="submit"
                    class="members-button danger"
                >
                    <i class="ph ph-trash"></i>
                    Hapus
                </button>
            </form>

        </div>
    </div>
</div>

<!-- MODAL EDIT FOTO + GENDER -->
<div
    id="member-edit-modal"
    class="member-overlay"
    role="dialog"
    aria-modal="true"
    aria-label="Edit foto dan jenis kelamin"
    hidden
>
    <div class="member-photo-dialog">

        <div class="flex items-center justify-between gap-3">

            <h2 class="text-lg font-extrabold">
                Edit Anggota
            </h2>

            <button
                id="member-edit-close"
                type="button"
                class="members-button"
            >
                Tutup
            </button>

        </div>

        <form
            id="member-edit-form"
            method="POST"
            enctype="multipart/form-data"
        >
            @csrf
            @method('PUT')

            <input
                type="hidden"
                name="name"
                id="edit-member-name"
            >

            <input
                type="hidden"
                name="banom"
                id="edit-member-banom"
            >

            <label for="edit-member-photo">
                Ganti Foto (opsional)
            </label>

            <input
                id="edit-member-photo"
                type="file"
                name="photo"
                accept="image/jpeg,image/png,image/webp"
            >

            <p class="text-[11px] text-gray-500 mt-1">
                Maksimal 2 MB. Kosongkan jika foto tidak diubah.
            </p>

            <label for="edit-member-gender">
                Jenis Kelamin
            </label>

            <select
                id="edit-member-gender"
                name="gender"
            >
                <option value="">
                    Belum diisi
                </option>

                <option value="Laki-laki">
                    Laki-laki
                </option>

                <option value="Perempuan">
                    Perempuan
                </option>
            </select>

            <button
                type="submit"
                class="members-button primary mt-5 w-full"
            >
                Simpan Perubahan
            </button>
        </form>
    </div>
</div>

<!-- LEMBAR CETAK -->
<div id="member-print-area">

    <!-- DEPAN -->
    <div class="member-print-card">

        <h2>Kartu Anggota</h2>

        <p>Pengurus Ranting NU Lesmana • Depan</p>

        <div class="member-print-row">

            <img
                id="print-member-photo"
                alt="Foto anggota"
                hidden
            >

            <div>

                <p>NAMA</p>
                <strong id="print-member-name">-</strong>

                <p>NIA</p>
                <strong id="print-member-nia">-</strong>

                <p>BANOM</p>
                <strong id="print-member-banom">-</strong>

                <p>JENIS KELAMIN</p>
                <strong id="print-member-gender">-</strong>

            </div>
        </div>
    </div>

    <!-- BELAKANG -->
    <div class="member-print-card">

        <h2>Kartu Anggota</h2>

        <p>Pengurus Ranting NU Lesmana • Belakang</p>

        <p style="margin-top:6mm">
            Simpan kartu dengan baik.
            Jika hilang atau rusak,
            hubungi pengurus NU Lesmana.
        </p>

        <p>
            Nama:
            <strong id="print-member-back-name">-</strong>
        </p>

        <p>
            NIA:
            <strong id="print-member-back-nia">-</strong>
        </p>
    </div>

</div>

<!-- JAVASCRIPT -->
<script>
(function () {
    'use strict';

    const cards = {{ \Illuminate\Support\Js::from($cardData) }};

    const memberMap = new Map(
        cards.map(member => [String(member.id), member])
    );

    const get = id => document.getElementById(id);

    const modal = get('member-kia-modal');
    const editModal = get('member-edit-modal');
    const rotor = get('member-card-inner');

    let selectedMember = null;
    let lastButton = null;

    function populate(member) {

        selectedMember = member;

        // Isi depan.
        get('card-name').textContent = member.name;
        get('card-nia').textContent = member.nia;
        get('card-banom').textContent = member.banom;
        get('card-gender').textContent = member.gender;

        // Isi belakang.
        get('card-back-name').textContent = member.name;
        get('card-back-nia').textContent = member.nia;

        // Data cetak.
        get('print-member-name').textContent = member.name;
        get('print-member-nia').textContent = member.nia;
        get('print-member-banom').textContent = member.banom;
        get('print-member-gender').textContent = member.gender;

        get('print-member-back-name').textContent = member.name;
        get('print-member-back-nia').textContent = member.nia;

        // Foto.
        const photo = get('card-photo');
        const printPhoto = get('print-member-photo');

        photo.hidden = !member.photo;
        printPhoto.hidden = !member.photo;

        get('card-initial').hidden = !!member.photo;

        get('card-initial').textContent =
            member.name.trim().charAt(0).toUpperCase() || 'A';

        if (member.photo) {
            photo.src = member.photo;
            printPhoto.src = member.photo;
        } else {
            photo.removeAttribute('src');
            printPhoto.removeAttribute('src');
        }

        // Route edit dan hapus.
        const path = '/admin/members/' +
            encodeURIComponent(member.id);

        get('member-delete').action = path;
        get('member-edit-form').action = path;

        // Isi form edit.
        get('edit-member-name').value = member.name;
        get('edit-member-banom').value = member.banom;
        get('edit-member-gender').value =
            member.gender === 'Belum diisi'
                ? ''
                : member.gender;

        get('edit-member-photo').value = '';

        // Reset flip.
        rotor.classList.remove('flipped');

        get('member-flip-text').textContent =
            'Lihat Belakang';
    }

    // Buka KIA.
    document.querySelectorAll('[data-open-member]').forEach(
        button => {

            button.addEventListener('click', function () {

                const member = memberMap.get(
                    button.dataset.openMember
                );

                if (!member) {
                    return;
                }

                lastButton = button;

                populate(member);

                modal.hidden = false;

                document.body.style.overflow = 'hidden';

                get('member-close').focus();
            });
        }
    );

    // Putar 3D.
    get('member-flip').addEventListener('click', function () {

        const flipped = rotor.classList.toggle('flipped');

        get('member-flip-text').textContent =
            flipped ? 'Lihat Depan' : 'Lihat Belakang';
    });

    // Cetak dua sisi.
    get('member-print').addEventListener('click', function () {
        window.print();
    });

    // Edit foto/gender.
    get('member-edit').addEventListener('click', function () {

        if (!selectedMember) {
            return;
        }

        modal.hidden = true;
        editModal.hidden = false;

        get('member-edit-close').focus();
    });

    // Tutup.
    function closeEverything() {

        modal.hidden = true;
        editModal.hidden = true;

        document.body.style.overflow = '';

        lastButton?.focus();
    }

    get('member-close').addEventListener(
        'click',
        closeEverything
    );

    get('member-edit-close').addEventListener(
        'click',
        closeEverything
    );

    modal.addEventListener('click', function (event) {

        if (event.target === modal) {
            closeEverything();
        }
    });

    editModal.addEventListener('click', function (event) {

        if (event.target === editModal) {
            closeEverything();
        }
    });

    document.addEventListener('keydown', function (event) {

        if (
            event.key === 'Escape' &&
            (!modal.hidden || !editModal.hidden)
        ) {
            closeEverything();
        }
    });

})();
</script>

@endsection
