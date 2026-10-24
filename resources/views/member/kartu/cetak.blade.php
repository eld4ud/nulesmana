
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Cetak Kartu Anggota | NU Lesmana</title>

    @php
        $nama = (string) ($member->name ?? $user->name ?? '-');
        $niaKartu = (string) ($nia ?? $member->nia ?? $user->nia ?? '-');
        $banom = (string) ($member->banom ?? '-');
        $gender = (string) ($member->gender ?? 'Belum diisi');

        $foto = $photoUrl ?? (
            !empty($member->photo)
                ? \Illuminate\Support\Facades\Storage::disk('public')->url($member->photo)
                : null
        );

        $inisial = mb_strtoupper(mb_substr($nama, 0, 1));

        $tanggal = $member->created_at
            ? $member->created_at->format('d/m/Y')
            : '-';

        // QR membuka dashboard anggota setelah login.
        // QR tidak memberikan akses tanpa autentikasi.
        $qrTarget = route('member.dashboard');
    @endphp

    <style>
        /* =====================================
           RESET HALAMAN
        ===================================== */

        * {
            box-sizing: border-box;
        }

        html,
        body {
            margin: 0;
            padding: 0;
        }

        body {
            background: #F5F4F0;
            font-family: Arial, Helvetica, sans-serif;
            color: #183C2F;
        }

        .page {
            padding: 35px 16px 55px;
            min-height: 100vh;
        }

        .page-heading {
            text-align: center;
            margin-bottom: 28px;
        }

        .page-heading h1 {
            margin: 0;
            font-size: 27px;
            font-weight: 800;
        }

        .page-heading p {
            margin: 8px 0 0;
            font-size: 13px;
            color: #6A806F;
        }

        /* =====================================
           SUSUNAN KARTU
        ===================================== */

        .card-sheet {
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 9mm;
        }

        .card {
            position: relative;

            width: 85.6mm;
            height: 54mm;

            flex: 0 0 54mm;

            background: #EDF5ED;
            border: .25mm solid #C2D4C2;
            border-radius: 3mm;

            color: #183C2F;
            overflow: hidden;

            box-shadow: 0 9px 22px rgba(24, 60, 47, .11);

            print-color-adjust: exact;
            -webkit-print-color-adjust: exact;

            break-inside: avoid;
            page-break-inside: avoid;
        }

        /* Garis emas di dalam kartu */

        .card::before {
            content: "";

            position: absolute;
            inset: 1.8mm;

            border: .2mm solid #C8B17D;
            border-radius: 2mm;

            pointer-events: none;
            z-index: 1;
        }

        /* Aksen bawah */

        .card::after {
            content: "";

            position: absolute;
            left: 0;
            right: 0;
            bottom: 0;

            height: 1.3mm;

            background: #183C2F;
            z-index: 3;
        }

        /* =====================================
           HEADER KARTU
           Area: 3.6 - 13 mm
        ===================================== */

        .card-header {
            position: absolute;

            top: 3.6mm;
            left: 4.5mm;
            right: 4.5mm;

            height: 9.4mm;

            display: flex;
            align-items: flex-start;
            justify-content: space-between;

            gap: 2mm;

            border-bottom: .2mm solid #C2D2C2;
        }

        .card-header h2 {
            margin: 0;

            font-family: Georgia, serif;
            font-size: 13.5pt;
            line-height: 1.1;
            font-weight: 700;

            color: #183C2F;
        }

        .card-header p {
            margin: 1mm 0 0;

            font-size: 6pt;
            line-height: 1.2;
            color: #587461;
        }

        .side-label {
            padding: 1mm 2mm;

            border: .2mm solid #C5D4C4;
            border-radius: 20mm;

            background: #F8FAF6;

            font-size: 5pt;
            font-weight: bold;

            white-space: nowrap;
        }

        /* =====================================
           DEPAN: TIGA KOLOM TETAP
           Body: 15.4 - 44.4 mm
        ===================================== */

        .front-body {
            position: absolute;

            top: 15.4mm;
            bottom: 9.6mm;

            left: 4.5mm;
            right: 4.5mm;

            display: grid;

            grid-template-columns:
                18mm
                minmax(0, 1fr)
                19mm;

            column-gap: 2.6mm;

            align-items: center;
        }

        /* =====================================
           FOTO
        ===================================== */

        .photo-column {
            width: 18mm;

            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;

            gap: 1.3mm;
        }

        .photo-box {
            width: 18mm;
            height: 23mm;

            background: #DCEADD;
            border: .2mm solid #B5CBB9;
            border-radius: 1.4mm;

            overflow: hidden;
        }

        .photo-box img {
            display: block;

            width: 100%;
            height: 100%;

            object-fit: cover;
            object-position: center;
        }

        .photo-placeholder {
            width: 100%;
            height: 100%;

            display: flex;
            align-items: center;
            justify-content: center;

            font-size: 24pt;
            font-weight: bold;

            background: #D9E6DA;
            color: #78977F;
        }

        .photo-caption {
            margin: 0;

            font-size: 4.4pt;
            font-weight: bold;
            color: #42734E;

            text-align: center;
        }

        /* =====================================
           IDENTITAS
        ===================================== */

        .identity-column {
            min-width: 0;
            height: 100%;

            display: flex;
            flex-direction: column;
            justify-content: center;

            gap: 1.45mm;
        }

        .identity-field {
            min-width: 0;
        }

        .identity-label {
            display: block;
            margin-bottom: .4mm;

            font-size: 4.5pt;
            font-weight: bold;
            line-height: 1.15;

            text-transform: uppercase;
            color: #77907B;
        }

        .identity-value {
            display: block;

            font-size: 7pt;
            font-weight: 800;
            line-height: 1.15;

            color: #183C2F;
            overflow-wrap: anywhere;
        }

        .identity-value.nia {
            font-size: 6.9pt;
        }

        .identity-two {
            display: grid;
            grid-template-columns: minmax(0, 1fr) minmax(0, 1fr);
            gap: 1.4mm;
        }

        .identity-two .identity-value {
            font-size: 6.2pt;
        }

        /* =====================================
           QR
        ===================================== */

        .qr-column {
            width: 19mm;

            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;

            gap: 1.5mm;
        }

        .qr-box {
            width: 19mm;
            height: 19mm;

            padding: .8mm;

            display: flex;
            justify-content: center;
            align-items: center;

            border: .2mm solid #C5D5C7;
            border-radius: 1.3mm;

            background: #FFFFFF;
            overflow: hidden;
        }

        .qr-box svg {
            display: block;
            width: 100%;
            height: 100%;
        }

        .qr-label {
            margin: 0;

            font-size: 4.6pt;
            font-weight: bold;
            line-height: 1.4;
            text-align: center;

            color: #56725E;
        }

        /* =====================================
           FOOTER TETAP
           Tidak bersinggungan dengan body
        ===================================== */

        .card-footer {
            position: absolute;

            bottom: 3mm;

            left: 4.5mm;
            right: 4.5mm;

            height: 4.6mm;

            display: flex;
            align-items: center;
            justify-content: space-between;

            gap: 2mm;

            padding-top: .9mm;
            border-top: .2mm solid #C2D2C2;
        }

        .card-footer span {
            font-size: 4.6pt;
            font-weight: bold;

            color: #597461;
            white-space: nowrap;
        }

        /* =====================================
           BELAKANG
        ===================================== */

        .back-body {
            position: absolute;

            top: 15.4mm;
            bottom: 9.6mm;

            left: 4.5mm;
            right: 4.5mm;

            display: grid;

            grid-template-columns: minmax(0, 1fr) minmax(0, 1fr);

            gap: 3.5mm;
            align-items: start;
        }

        .back-column {
            min-width: 0;
        }

        .back-heading {
            margin: 0 0 2mm;

            font-size: 7pt;
            font-weight: 800;

            color: #183C2F;
        }

        .back-list {
            padding-left: 3.6mm;
            margin: 0;
        }

        .back-list li {
            margin: 0 0 1.2mm;

            font-size: 5.7pt;
            line-height: 1.4;

            color: #476450;
        }

        .back-description {
            margin: 0;

            font-size: 5.8pt;
            line-height: 1.45;
            color: #476450;
        }

        .back-identity {
            margin-top: 2.2mm;

            padding: 1.8mm;

            border: .2mm solid #CBDACC;
            border-radius: 1.3mm;

            background: #F7FAF5;
        }

        .back-identity-item + .back-identity-item {
            margin-top: 1.7mm;
        }

        .back-identity-label {
            display: block;

            font-size: 4.5pt;
            color: #7B917D;

            margin-bottom: .4mm;
        }

        .back-identity-value {
            display: block;

            font-size: 6.5pt;
            font-weight: bold;
            line-height: 1.2;

            overflow-wrap: anywhere;
        }

        /* =====================================
           TOMBOL HALAMAN
        ===================================== */

        .page-actions {
            display: flex;
            align-items: center;
            justify-content: center;

            flex-wrap: wrap;
            gap: 10px;

            margin-top: 27px;
        }

        .action-btn {
            padding: 12px 19px;

            border: 1px solid #183C2F;
            border-radius: 11px;

            font-size: 12px;
            font-weight: 800;

            background: #183C2F;
            color: #FFFFFF;

            text-decoration: none;
            cursor: pointer;
        }

        .action-btn.secondary {
            background: #FFFFFF;
            color: #183C2F;
        }

        .print-note {
            margin-top: 17px;

            text-align: center;

            font-size: 11px;
            line-height: 1.6;
            color: #728576;
        }

        /* =====================================
           PRINT A4
        ===================================== */

        @page {
            size: A4 portrait;
            margin: 12mm;
        }

        @media print {
            html,
            body {
                padding: 0 !important;
                margin: 0 !important;

                background: white !important;
            }

            .page {
                min-height: 0;
                padding: 0;
                margin: 0;
            }

            .no-print {
                display: none !important;
            }

            .card-sheet {
                width: 85.6mm;
                margin: 0;

                display: flex;
                flex-direction: column;
                align-items: flex-start;

                gap: 8mm;
            }

            .card {
                margin: 0;
                box-shadow: none;

                width: 85.6mm;
                height: 54mm;
                flex: 0 0 54mm;

                break-inside: avoid;
                page-break-inside: avoid;

                print-color-adjust: exact;
                -webkit-print-color-adjust: exact;
            }
        }

        @media (max-width: 390px) {
            .page {
                padding-left: 4px;
                padding-right: 4px;
            }
        }
    </style>
</head>

<body>

<div class="page">

    <!-- JUDUL DI LUAR AREA PRINT -->
    <div class="page-heading no-print">
        <h1>Cetak Kartu Anggota</h1>
        <p>NU Lesmana • Kartu depan dan belakang</p>
    </div>

    <main class="card-sheet">

        <!-- =====================================
             KARTU DEPAN
        ===================================== -->
        <section class="card" aria-label="KIA sisi depan">

            <!-- HEADER -->
            <header class="card-header">

                <div>
                    <h2>Kartu Anggota</h2>
                    <p>Pengurus Ranting NU Lesmana</p>
                </div>

                <span class="side-label">
                    DEPAN
                </span>

            </header>

            <!-- FOTO + IDENTITAS + QR -->
            <div class="front-body">

                <!-- FOTO -->
                <div class="photo-column">

                    <div class="photo-box">

                        @if($foto)
                            <img
                                src="{{ $foto }}"
                                alt="Foto {{ $nama }}"
                            >
                        @else
                            <div class="photo-placeholder">
                                {{ $inisial }}
                            </div>
                        @endif

                    </div>

                    <p class="photo-caption">
                        TERVERIFIKASI
                    </p>

                </div>

                <!-- IDENTITAS -->
                <div class="identity-column">

                    <div class="identity-field">
                        <span class="identity-label">
                            Nama Lengkap
                        </span>

                        <strong class="identity-value">
                            {{ $nama }}
                        </strong>
                    </div>

                    <div class="identity-field">
                        <span class="identity-label">
                            NIA
                        </span>

                        <strong class="identity-value nia">
                            {{ $niaKartu }}
                        </strong>
                    </div>

                    <div class="identity-two">

                        <div class="identity-field">
                            <span class="identity-label">
                                Banom
                            </span>

                            <strong class="identity-value">
                                {{ $banom }}
                            </strong>
                        </div>

                        <div class="identity-field">
                            <span class="identity-label">
                                Jenis Kelamin
                            </span>

                            <strong class="identity-value">
                                {{ $gender }}
                            </strong>
                        </div>

                    </div>

                    <div class="identity-field">
                        <span class="identity-label">
                            Tanggal Terdaftar
                        </span>

                        <strong class="identity-value">
                            {{ $tanggal }}
                        </strong>
                    </div>

                </div>

                <!-- QR -->
                <div class="qr-column">

                    <div class="qr-box">

                        {!! QrCode::format('svg')
                            ->size(130)
                            ->margin(1)
                            ->generate($qrTarget) !!}

                    </div>

                    <p class="qr-label">
                        SCAN QR<br>
                        AKUN ANGGOTA
                    </p>

                </div>

            </div>

            <!-- FOOTER -->
            <footer class="card-footer">
                <span>IDENTITAS KEANGGOTAAN</span>
                <span>NU LESMANA</span>
            </footer>

        </section>

        <!-- =====================================
             KARTU BELAKANG
        ===================================== -->
        <section class="card" aria-label="KIA sisi belakang">

            <!-- HEADER -->
            <header class="card-header">

                <div>
                    <h2>Kartu Anggota</h2>
                    <p>Perawatan dan Pengembalian</p>
                </div>

                <span class="side-label">
                    BELAKANG
                </span>

            </header>

            <!-- INFORMASI BELAKANG -->
            <div class="back-body">

                <div class="back-column">

                    <h3 class="back-heading">
                        Petunjuk Perawatan
                    </h3>

                    <ul class="back-list">
                        <li>
                            Simpan kartu dengan baik.
                        </li>

                        <li>
                            Hindarkan dari panas, air,
                            dan lipatan.
                        </li>

                        <li>
                            Jika hilang atau rusak,
                            hubungi pengurus NU Lesmana.
                        </li>
                    </ul>

                </div>

                <div class="back-column">

                    <h3 class="back-heading">
                        Jika Ditemukan
                    </h3>

                    <p class="back-description">
                        Mohon kembalikan kepada
                        pengurus Ranting NU Lesmana.
                    </p>

                    <div class="back-identity">

                        <div class="back-identity-item">

                            <span class="back-identity-label">
                                NAMA
                            </span>

                            <strong class="back-identity-value">
                                {{ $nama }}
                            </strong>

                        </div>

                        <div class="back-identity-item">

                            <span class="back-identity-label">
                                NIA
                            </span>

                            <strong class="back-identity-value">
                                {{ $niaKartu }}
                            </strong>

                        </div>

                    </div>

                </div>

            </div>

            <!-- FOOTER -->
            <footer class="card-footer">
                <span>KARTU ANGGOTA DIGITAL</span>
                <span>NU LESMANA</span>
            </footer>

        </section>

    </main>

    <!-- TOMBOL -->
    <div class="page-actions no-print">

        <a
            href="{{ route('member.kia') }}"
            class="action-btn secondary"
        >
            Kembali ke KIA
        </a>

        <button
            type="button"
            class="action-btn"
            onclick="window.print()"
        >
            Cetak / Simpan PDF
        </button>

    </div>

    <p class="print-note no-print">
        Ukuran 85,6 × 54 mm per sisi.
        Gunakan A4, skala 100%, dan aktifkan
        cetak warna latar belakang.
    </p>

</div>

</body>
</html>
