
@extends('layouts.member')

@section('title', 'Kartu Anggota Digital')

@section('content')

<style>
    .kia-page {
        max-width: 850px;
        margin: 0 auto;
        padding: 15px 0 55px;
        color: #183C2F;
        font-family: 'DM Sans', sans-serif;
    }

    .kia-scene {
        width: 100%;
        max-width: 650px;
        aspect-ratio: 1.586;
        margin: 30px auto 0;
        perspective: 1400px;
    }

    .kia-rotor {
        width: 100%;
        height: 100%;
        position: relative;
        transform-style: preserve-3d;
        transition: transform .8s cubic-bezier(.2,.75,.2,1);
    }

    .kia-rotor.flipped {
        transform: rotateY(180deg);
    }

    .kia-face {
        position: absolute;
        inset: 0;
        padding: 5%;
        background: #EDF5ED;
        border: 1px solid #CEDFCE;
        border-radius: 20px;
        color: #183C2F;
        backface-visibility: hidden;
        -webkit-backface-visibility: hidden;
        box-shadow: 0 22px 55px rgba(24,60,47,.15);
        overflow: hidden;
        display: flex;
        flex-direction: column;
    }

    .kia-face::before {
        content: '';
        position: absolute;
        inset: 7px;
        border: 1px solid rgba(174,140,70,.46);
        border-radius: 13px;
        pointer-events: none;
    }

    .kia-back {
        transform: rotateY(180deg);
    }

    .kia-top {
        display: flex;
        justify-content: space-between;
        align-items: center;
        border-bottom: 1px solid #C8D6C8;
        padding-bottom: 3%;
    }

    .kia-title {
        font: bold clamp(16px, 3vw, 27px) Georgia, serif;
    }

    .kia-subtitle {
        font-size: clamp(8px, 1.1vw, 11px);
        color: #607967;
    }

    .kia-body {
        display: flex;
        align-items: center;
        gap: 5%;
        margin: auto 0;
        min-height: 0;
    }

    .kia-photo {
        width: 24%;
        aspect-ratio: 3 / 4;
        object-fit: cover;
        background: #DCE9DD;
        border: 1px solid #B6CCB8;
        border-radius: 8px;
    }

    .kia-placeholder {
        width: 24%;
        aspect-ratio: 3 / 4;
        display: flex;
        align-items: center;
        justify-content: center;
        background: #DCE9DD;
        border-radius: 8px;
        color: #829D88;
        font-size: clamp(26px, 5vw, 55px);
        font-weight: 800;
    }

    .kia-details {
        flex: 1;
        min-width: 0;
    }

    .kia-key {
        color: #7A907E;
        font-size: clamp(7px, 1vw, 10px);
        font-weight: 800;
        margin-top: 8px;
    }

    .kia-value {
        font-size: clamp(10px, 1.7vw, 17px);
        font-weight: 800;
        overflow-wrap: anywhere;
        line-height: 1.25;
    }

    .kia-footer {
        margin-top: auto;
        display: flex;
        justify-content: space-between;
        gap: 10px;
        border-top: 1px solid #C8D6C8;
        padding-top: 3%;
        font-size: clamp(8px, 1vw, 10px);
        color: #66826E;
        font-weight: 800;
    }

    .kia-gold {
        height: 5px;
        background: linear-gradient(
            90deg,
            #AB894D,
            #E1C58E,
            #AB894D
        );
        position: absolute;
        bottom: 0;
        left: 0;
        right: 0;
    }

    .kia-instructions {
        font-size: clamp(9px, 1.6vw, 13px);
        line-height: 1.8;
        margin: auto 0;
    }

    .kia-actions {
        display: flex;
        justify-content: center;
        flex-wrap: wrap;
        gap: 11px;
        margin-top: 27px;
    }

    .kia-button {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        background: #183C2F;
        color: white;
        padding: 13px 19px;
        border: none;
        border-radius: 12px;
        font-size: 12px;
        font-weight: 800;
        cursor: pointer;
        text-decoration: none;
    }

    .kia-button.secondary {
        color: #183C2F;
        background: white;
        border: 1px solid #CFDBCF;
    }

    @media (max-width: 480px) {
        .kia-key {
            margin-top: 4px;
        }

        .kia-instructions {
            line-height: 1.45;
        }
    }

    @media (prefers-reduced-motion: reduce) {
        .kia-rotor {
            transition: none;
        }
    }
</style>

<div class="kia-page">

    <div class="text-center">

        <p class="text-xs uppercase tracking-widest font-bold text-[#718675]">
            Identitas Digital Warga
        </p>

        <h1 class="font-display text-5xl sm:text-6xl mt-3">
            KARTU ANGGOTA.
        </h1>

        <p class="text-sm text-gray-600 mt-3">
            Kartu resmi anggota NU Lesmana yang telah diverifikasi.
        </p>

    </div>

    <!-- KARTU FLIP -->
    <div class="kia-scene">

        <div id="kia-rotor" class="kia-rotor">

            <!-- DEPAN -->
            <section class="kia-face">

                <header class="kia-top">
                    <div>
                        <h2 class="kia-title">Kartu Anggota</h2>
                        <p class="kia-subtitle">
                            Pengurus Ranting NU Lesmana
                        </p>
                    </div>

                    <span class="text-2xl text-[#AD8951]">
                        ✦
                    </span>
                </header>

                <div class="kia-body">

                    @if($photoUrl)

                        <img
                            src="{{ $photoUrl }}"
                            alt="Foto {{ $member->name }}"
                            class="kia-photo"
                        >

                    @else

                        <div class="kia-placeholder">
                            {{ mb_strtoupper(mb_substr($member->name, 0, 1)) }}
                        </div>

                    @endif

                    <div class="kia-details">

                        <p class="kia-key">NAMA LENGKAP</p>
                        <p class="kia-value">{{ $member->name }}</p>

                        <p class="kia-key">NIA</p>
                        <p class="kia-value">{{ $nia }}</p>

                        <p class="kia-key">BANOM</p>
                        <p class="kia-value">{{ $member->banom }}</p>

                        <p class="kia-key">JENIS KELAMIN</p>
                        <p class="kia-value">
                            {{ $member->gender ?: 'Belum diisi' }}
                        </p>

                    </div>
                </div>

                <footer class="kia-footer">
                    <span>ANGGOTA TERVERIFIKASI</span>
                    <span>NU LESMANA</span>
                </footer>

                <span class="kia-gold"></span>
            </section>

            <!-- BELAKANG -->
            <section class="kia-face kia-back">

                <header class="kia-top">
                    <div>
                        <h2 class="kia-title">Kartu Anggota</h2>
                        <p class="kia-subtitle">
                            Perawatan dan Pengembalian
                        </p>
                    </div>

                    <span class="text-2xl text-[#AD8951]">
                        ✦
                    </span>
                </header>

                <div class="kia-instructions">

                    <strong>Petunjuk Perawatan</strong>

                    <p>• Simpan kartu dengan baik.</p>
                    <p>• Hindarkan dari panas, air, dan lipatan.</p>
                    <p>• Jika hilang, hubungi pengurus organisasi.</p>

                    <p class="mt-3">
                        Nama:
                        <strong>{{ $member->name }}</strong>
                    </p>

                    <p>
                        NIA:
                        <strong>{{ $nia }}</strong>
                    </p>

                    <p class="mt-3">
                        Jika ditemukan, mohon kembalikan
                        kepada pengurus Ranting NU Lesmana.
                    </p>

                </div>

                <footer class="kia-footer">
                    <span>KARTU ANGGOTA DIGITAL</span>
                    <span>NU LESMANA</span>
                </footer>

                <span class="kia-gold"></span>
            </section>

        </div>
    </div>

    <!-- TOMBOL -->
    <div class="kia-actions">

        <button
            id="kia-flip"
            type="button"
            class="kia-button"
        >
            <i class="ph ph-arrows-clockwise"></i>

            <span id="kia-flip-text">
                Lihat Belakang
            </span>
        </button>

        <a
            href="/cetak-kartu"
            class="kia-button secondary"
        >
            <i class="ph ph-printer"></i>
            Cetak KIA
        </a>

        <a
            href="{{ route('member.dashboard') }}"
            class="kia-button secondary"
        >
            <i class="ph ph-arrow-left"></i>
            Dashboard Anggota
        </a>

    </div>

    <p class="text-xs text-gray-500 text-center mt-6">
        Data kartu mengikuti identitas anggota
        yang disetujui pengurus.
    </p>

</div>

<script>
(function () {
    const rotor = document.getElementById('kia-rotor');
    const button = document.getElementById('kia-flip');
    const label = document.getElementById('kia-flip-text');

    if (!rotor || !button || !label) {
        return;
    }

    button.addEventListener('click', function () {

        const flipped = rotor.classList.toggle('flipped');

        label.textContent = flipped
            ? 'Lihat Depan'
            : 'Lihat Belakang';
    });
})();
</script>

@endsection
