<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title>Cetak KIA - {{ $user->name ?? 'Anggota' }}</title>
    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    @include('components.kia-style')
    <style>
        *{box-sizing:border-box}body{margin:0;background:#f5f4f0;color:#183c2f;font-family:'DM Sans',sans-serif}
        .kp-shell{max-width:1080px;margin:45px auto;padding:24px}
        .kp-heading{font-size:40px;font-weight:800;letter-spacing:-.04em;margin:0 0 8px}
        .kp-desc{color:#718276;font-size:14px;line-height:1.6;margin:0 0 25px}
        .kp-actions{display:flex;gap:10px;flex-wrap:wrap;margin:0 0 32px}
        .kp-btn{display:inline-flex;align-items:center;justify-content:center;gap:8px;text-decoration:none;border:1px solid #183c2f;background:#183c2f;color:#fff;border-radius:11px;padding:12px 18px;font-size:13px;font-weight:800;cursor:pointer}
        .kp-btn.alt{background:white;color:#183c2f;border-color:#ced8ce}
        .kp-cards{display:grid;grid-template-columns:repeat(2,minmax(0,1fr));gap:24px}
        .kp-card-caption{font-size:11px;text-transform:uppercase;letter-spacing:.12em;font-weight:800;color:#718376;margin:0 0 14px}
        .kp-note{margin-top:32px;font-size:12px;color:#6d7b72}
        @media(max-width:750px){.kp-cards{grid-template-columns:1fr}.kp-shell{padding:15px}.kp-heading{font-size:29px}}
        @page{size:A4;margin:12mm}
        @media print{
            html,body{background:white!important;margin:0!important}
            .kp-shell{max-width:none;margin:0;padding:0}
            .kp-heading,.kp-desc,.kp-actions,.kp-card-caption,.kp-note{display:none!important}
            .kp-cards{display:flex;gap:8mm;align-items:flex-start}
            .kp-cards>section{width:85.6mm;flex:none;break-inside:avoid}
            .kp-cards .kia-unified-card{width:85.6mm!important;height:54mm!important}
        }
    </style>
</head>
<body>
@php
    $cardUser = $user ?? auth()->user();
    $cardMember = $member ?? ($cardUser?->member ?? null);
    $cardNia = $nia ?? ($cardMember?->nia ?: ($cardUser?->nia ?? null));
@endphp
<main class="kp-shell">
    <h1 class="kp-heading">Cetak Kartu Anggota</h1>
    <p class="kp-desc">Desain depan dan belakang identik dengan kartu digital. Cetak pada ukuran kartu 85,6 × 54 mm atau simpan menjadi PDF.</p>
    <div class="kp-actions">
        <button class="kp-btn" type="button" onclick="window.print()">Cetak / Simpan PDF</button>
        <a class="kp-btn alt" href="{{ route('member.kia') }}">Kembali ke KIA</a>
        <a class="kp-btn alt" href="{{ route('member.dashboard') }}">Dashboard</a>
    </div>
    <div class="kp-cards">
        <section>
            <p class="kp-card-caption">Sisi Depan</p>
            @include('components.kia-card', ['side' => 'front', 'user' => $cardUser, 'member' => $cardMember, 'nia' => $cardNia])
        </section>
        <section>
            <p class="kp-card-caption">Sisi Belakang</p>
            @include('components.kia-card', ['side' => 'back', 'user' => $cardUser, 'member' => $cardMember, 'nia' => $cardNia])
        </section>
    </div>
    <p class="kp-note">Aktifkan “Cetak grafik latar belakang” pada browser agar warna mint dan garis emas ikut tercetak. Sisi belakang perlu disesuaikan orientasinya saat mencetak bolak-balik.</p>
</main>
</body>
</html>
