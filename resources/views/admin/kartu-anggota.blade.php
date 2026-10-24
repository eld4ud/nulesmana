<!doctype html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Kartu Anggota - {{ $member->name }}</title>
    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        *{box-sizing:border-box}
        body{margin:0;background:#f5f4f0;color:#183c2f;font-family:'DM Sans',Arial,sans-serif}
        .top{max-width:1120px;margin:28px auto 15px;padding:0 16px}
        h1{font-size:30px;margin:0 0 6px}p{font-size:13px;color:#697c70}
        .buttons{display:flex;flex-wrap:wrap;gap:10px;margin-top:15px}
        .buttons a,.buttons button{background:#183c2f;color:white;text-decoration:none;padding:11px 16px;border-radius:10px;border:0;font-weight:800;font-size:13px;cursor:pointer}
        .cards{max-width:1120px;padding:0 16px;margin:28px auto;display:grid;grid-template-columns:repeat(2,minmax(0,1fr));gap:18px}
        .side-label{margin:0 0 8px;font-size:11px;font-weight:800}
        @page{size:A4 portrait;margin:12mm}
        @media(max-width:650px){.cards{grid-template-columns:1fr}}
        @media print{
            html,body{background:#fff;print-color-adjust:exact;-webkit-print-color-adjust:exact}
            .top,.side-label{display:none!important}
            .cards{display:flex!important;gap:5mm;margin:0!important;padding:0!important;max-width:none}
            .side{width:85.6mm;flex:0 0 85.6mm}
        }
    </style>
</head>
<body>
    <header class="top">
        <h1>Kartu Anggota NU Lesmana</h1>
        <p>{{ $member->name }} • {{ $member->banom }} • {{ $nia }}</p>
        <div class="buttons">
            <a href="{{ route('admin.members.index') }}">← Kelola Anggota</a>
            <button type="button" onclick="window.print()">Cetak / PDF</button>
        </div>
        <p>Tunggu QR muncul sebelum cetak. QR hanya mengizinkan pemilik yang login membuka halaman KIA miliknya.</p>
    </header>
    <main class="cards">
        <section class="side"><p class="side-label">DEPAN</p>@include('member.components.kia-card', ['side'=>'front'])</section>
        <section class="side"><p class="side-label">BELAKANG</p>@include('member.components.kia-card', ['side'=>'back'])</section>
    </main>
</body>
</html>
