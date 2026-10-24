@extends('layouts.member')
@section('title', 'Infaq Anggota')
@section('content')
@php
    $namaAnggota = auth()->user()?->name ?? 'Anggota';
@endphp
<style>
    .nia-funds{--ink:#183C2F;--muted:#617269;--line:#D8DED6;--paper:#F5F4F0;--white:#fff;color:var(--ink);font-family:'DM Sans',sans-serif;max-width:1140px;margin:0 auto}
    .nia-funds *{box-sizing:border-box}
    .nia-funds button,.nia-funds input{font:inherit}
    .nia-funds .eyebrow{font-size:10px;font-weight:800;letter-spacing:.18em;text-transform:uppercase;color:#6C8372}
    .nia-funds .headline{font-family:'Bebas Neue',Impact,sans-serif;font-size:clamp(56px,8vw,100px);font-weight:400;letter-spacing:.01em;line-height:.9;margin:14px 0 18px}
    .nia-funds .intro{color:var(--muted);font-size:14px;line-height:1.8;max-width:560px;margin:0}
    .nia-funds .rule{border-color:var(--line)}
    .nia-funds .intro-bar{padding:10px 0 38px;border-bottom:1px solid var(--line);display:flex;align-items:end;justify-content:space-between;gap:24px}
    .nia-funds .outline-link{display:inline-flex;align-items:center;gap:9px;color:var(--ink);font-size:12px;font-weight:800;text-decoration:none;border-bottom:1px solid currentColor;padding-bottom:4px;white-space:nowrap}
    .nia-funds .preview-tag{display:inline-flex;gap:7px;align-items:center;background:#E7ECE5;border:1px solid #BFCBBF;padding:7px 11px;font-size:10px;font-weight:800;letter-spacing:.08em;text-transform:uppercase}
    .nia-funds .workarea{display:grid;grid-template-columns:minmax(0,1.65fr) minmax(275px,1fr);gap:45px;padding:32px 0 50px;align-items:start}
    .nia-funds .subhead{margin:0 0 9px;font-size:23px;font-weight:800;letter-spacing:-.035em}
    .nia-funds .description{color:var(--muted);font-size:12px;line-height:1.75;margin:0}
    .nia-funds .section-head{padding-bottom:19px;border-bottom:1px solid var(--line)}
    .nia-funds .section{margin-top:26px}
    .nia-funds .field-title{display:block;margin-bottom:13px;font-size:11px;font-weight:800;letter-spacing:.08em;text-transform:uppercase}
    .nia-funds .amounts{display:grid;grid-template-columns:repeat(3,minmax(0,1fr));gap:10px}
    .nia-funds .choice{position:relative;display:block;cursor:pointer;min-width:0}
    .nia-funds .choice input{position:absolute;opacity:0;pointer-events:none}
    .nia-funds .choice-face{display:flex;align-items:center;justify-content:center;min-height:58px;padding:10px 7px;background:#fff;border:1px solid #D0D9D0;color:#183C2F;font-size:13px;font-weight:800;transition:border-color .15s,background .15s}
    .nia-funds .choice input:checked+.choice-face{background:#183C2F;border-color:#183C2F;color:#fff}
    .nia-funds .choice input:focus-visible+.choice-face{outline:3px solid #829E87;outline-offset:3px}
    .nia-funds .custom-amount{margin-top:12px;display:none}
    .nia-funds .custom-amount.active{display:block}
    .nia-funds .custom-amount input{width:100%;padding:13px 15px;background:#fff;border:1px solid #BFCBBF;border-radius:0;outline:none;font-size:14px;color:#183C2F}
    .nia-funds .custom-amount input:focus{border-color:#183C2F;box-shadow:0 0 0 2px #BFCFBF}
    .nia-funds .methods{display:grid;grid-template-columns:1fr;gap:9px}
    .nia-funds .method{display:flex;align-items:center;gap:13px;padding:14px 15px;border:1px solid #D0D9D0;background:#fff;cursor:pointer;transition:border-color .15s,background .15s}
    .nia-funds .method:has(input:checked){border-color:#183C2F;background:#F0F4EE}
    .nia-funds .method input{accent-color:#183C2F;flex-shrink:0}
    .nia-funds .method-icon{display:grid;place-items:center;width:44px;height:38px;background:#E8EEE7;color:#183C2F;font-size:11px;font-weight:900;letter-spacing:.04em;flex-shrink:0}
    .nia-funds .method-name{display:block;font-size:13px;font-weight:800}
    .nia-funds .method-note{display:block;font-size:11px;color:#718076;margin-top:3px;line-height:1.4}
    .nia-funds .preview-button{margin-top:25px;display:flex;align-items:center;justify-content:space-between;width:100%;background:#183C2F;border:1px solid #183C2F;color:#fff;padding:16px 19px;cursor:pointer;text-align:left;font-size:12px;font-weight:800}
    .nia-funds .preview-button:hover{background:#27513C}
    .nia-funds .feedback{display:none;color:#9A3D32;margin:10px 0 0;font-size:12px;font-weight:700}
    .nia-funds .feedback.show{display:block}
    .nia-funds .preview-result{margin-top:17px;border:1px solid #AFC4B0;background:#E9F0E8;padding:20px;display:none}
    .nia-funds .preview-result.show{display:block}
    .nia-funds .preview-result strong{font-size:15px;display:block;margin:8px 0}
    .nia-funds .preview-result p{font-size:12px;line-height:1.7;color:#4B6555;margin:0}
    .nia-funds .sidebar{border-left:1px solid var(--line);padding-left:32px;min-width:0}
    .nia-funds .side-card{padding-bottom:23px;margin-bottom:24px;border-bottom:1px solid var(--line)}
    .nia-funds .side-label{font-size:10px;font-weight:800;letter-spacing:.13em;text-transform:uppercase;color:#728679;margin:0 0 11px}
    .nia-funds .side-value{font-size:27px;font-weight:800;letter-spacing:-.045em;margin:0 0 10px}
    .nia-funds .side-caption{font-size:12px;color:var(--muted);line-height:1.75;margin:0}
    .nia-funds .side-notice{background:#E8EDE5;padding:20px;margin-top:28px}
    .nia-funds .side-notice b{display:block;font-size:12px;margin-bottom:10px}
    .nia-funds .side-notice p{color:#52685B;font-size:12px;line-height:1.75;margin:0}
    .nia-funds .history{border-top:1px solid var(--line);padding:31px 0 70px}
    .nia-funds .history-top{display:flex;gap:20px;justify-content:space-between;align-items:center}
    .nia-funds .history-empty{margin-top:20px;padding:30px 24px;border:1px dashed #BFC9BE;background:#FBFBF8;text-align:center}
    .nia-funds .history-empty svg{color:#7F9686;margin:0 auto 13px}
    .nia-funds .history-empty b{font-size:13px;display:block}
    .nia-funds .history-empty p{color:var(--muted);font-size:12px;line-height:1.75;margin:8px auto 0;max-width:480px}
    @media(max-width:850px){.nia-funds .workarea{grid-template-columns:1fr;gap:20px}.nia-funds .sidebar{border-left:0;border-top:1px solid var(--line);padding:30px 0 0}.nia-funds .intro-bar{align-items:start;flex-direction:column}}
    @media(max-width:510px){.nia-funds .amounts{grid-template-columns:repeat(2,minmax(0,1fr))}.nia-funds .headline{font-size:65px}.nia-funds .history-top{align-items:start;flex-direction:column}.nia-funds .side-value{font-size:25px}}
    @media(prefers-reduced-motion:reduce){.nia-funds *{transition:none!important;animation:none!important}}
</style>
<div class="nia-funds" id="nia-funds">
    <header class="intro-bar">
        <div>
            <div class="eyebrow">PORTAL ANGGOTA / LAYANAN KEUANGAN</div>
            <h1 class="headline">INFAQ ANGGOTA.</h1>
            <p class="intro">Ruang kontribusi sukarela untuk mendukung kegiatan dan program NU Lesmana. Pilih nominal dan metode untuk melihat alur pembayaran yang direncanakan.</p>
        </div>
        <a href="{{ route('member.dashboard') }}" class="outline-link"><span aria-hidden="true">←</span> Dashboard anggota</a>
    </header>
    <div class="workarea">
        <section aria-labelledby="infaq-form-heading">
            <div class="section-head">
                <div class="preview-tag"><span aria-hidden="true">●</span> Pratinjau fitur</div>
                <h2 class="subhead" id="infaq-form-heading" style="margin-top:16px">Rencanakan kontribusi</h2>
                <p class="description">Form ini belum terhubung dengan layanan pembayaran. Tidak ada dana yang ditagih, dipindahkan, atau dicatat saat kamu mencobanya.</p>
            </div>
            <form id="nia-infaq-form" novalidate>
                <div class="section">
                    <span class="field-title">01 / Nominal infaq</span>
                    <div class="amounts" role="group" aria-label="Pilihan nominal infaq">
                        <label class="choice"><input type="radio" name="nia_nominal" value="5000"><span class="choice-face">Rp5.000</span></label>
                        <label class="choice"><input type="radio" name="nia_nominal" value="10000" checked><span class="choice-face">Rp10.000</span></label>
                        <label class="choice"><input type="radio" name="nia_nominal" value="20000"><span class="choice-face">Rp20.000</span></label>
                        <label class="choice"><input type="radio" name="nia_nominal" value="50000"><span class="choice-face">Rp50.000</span></label>
                        <label class="choice"><input type="radio" name="nia_nominal" value="100000"><span class="choice-face">Rp100.000</span></label>
                        <label class="choice"><input type="radio" name="nia_nominal" value="lainnya"><span class="choice-face">Lainnya</span></label>
                    </div>
                    <div id="nia-custom-amount" class="custom-amount">
                        <label class="field-title" for="nia-other-amount" style="margin-top:15px">Nominal lainnya (rupiah)</label>
                        <input id="nia-other-amount" type="number" min="1000" max="100000000" step="1000" inputmode="numeric" placeholder="Contoh: 15000">
                    </div>
                </div>
                <div class="section">
                    <span class="field-title">02 / Metode pembayaran</span>
                    <div class="methods" role="group" aria-label="Pilihan metode pembayaran">
                        <label class="method"><input type="radio" name="nia_method" value="QRIS" checked><span class="method-icon">QR</span><span><span class="method-name">QRIS</span><span class="method-note">Scan melalui aplikasi bank atau dompet digital yang mendukung QRIS</span></span></label>
                        <label class="method"><input type="radio" name="nia_method" value="E-wallet"><span class="method-icon">EW</span><span><span class="method-name">E-wallet</span><span class="method-note">Opsi dompet digital melalui penyedia pembayaran resmi</span></span></label>
                        <label class="method"><input type="radio" name="nia_method" value="Transfer bank"><span class="method-icon">VA</span><span><span class="method-name">Transfer bank</span><span class="method-note">Rencana pembayaran melalui virtual account</span></span></label>
                    </div>
                </div>
                <button type="submit" class="preview-button">Lihat ringkasan pilihan <span aria-hidden="true">↗</span></button>
                <p id="nia-infaq-error" class="feedback" role="alert"></p>
                <div id="nia-infaq-result" class="preview-result" role="status" aria-live="polite">
                    <div class="eyebrow">SIMULASI / BUKAN TAGIHAN</div>
                    <strong id="nia-infaq-summary">—</strong>
                    <p>Metode ini masih berupa konsep. QR, nomor virtual account, ataupun tautan pembayaran asli belum diterbitkan. Infaq baru akan diproses setelah integrasi resmi tersedia.</p>
                </div>
            </form>
        </section>
        <aside class="sidebar" aria-label="Informasi dan transparansi">
            <section class="side-card"><p class="side-label">Anggota</p><h3 class="side-value">{{ $namaAnggota }}</h3><p class="side-caption">Akun anggota terverifikasi. Infaq tetap bersifat sukarela dan tidak memengaruhi status KIA.</p></section>
            <section class="side-card"><p class="side-label">Saldo kas organisasi</p><h3 class="side-value">Belum ditampilkan</h3><p class="side-caption">Ringkasan keuangan akan muncul setelah pengurus menentukan data yang dapat dipublikasikan.</p></section>
            <section class="side-card"><p class="side-label">Riwayat pribadi</p><h3 class="side-value">Belum terhubung</h3><p class="side-caption">Kelak hanya transaksi yang dikaitkan dan diverifikasi ke akunmu yang akan tampil di sini.</p></section>
            <section class="side-notice"><b>Tentang keamanan pembayaran</b><p>Versi ini tidak meminta PIN, OTP, maupun data rekening. Pada versi pembayaran asli, status transaksi harus dikonfirmasi server oleh penyedia pembayaran, bukan dari tombol di browser.</p></section>
        </aside>
    </div>
    <section class="history" aria-labelledby="nia-history-heading">
        <div class="history-top"><div><div class="eyebrow">ARSIP PRIBADI</div><h2 id="nia-history-heading" class="subhead" style="margin-top:10px">Riwayat infaq saya</h2></div><span class="preview-tag">Belum terhubung ke transaksi</span></div>
        <div class="history-empty">
            <svg xmlns="http://www.w3.org/2000/svg" width="36" height="36" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" aria-hidden="true"><rect x="5" y="3" width="14" height="18" rx="2"/><path d="M9 8h6M9 12h6M9 16h3"/></svg>
            <b>Belum ada riwayat yang dapat ditampilkan</b>
            <p>Catatan kas admin saat ini belum otomatis terkait dengan akun anggota. Agar akurat, riwayat akan ditampilkan setelah ada sistem transaksi dan verifikasi pembayaran.</p>
        </div>
    </section>
</div>
<script>
(function(){
    const root=document.getElementById('nia-funds');
    if(!root)return;
    const form=root.querySelector('#nia-infaq-form');
    const otherWrap=root.querySelector('#nia-custom-amount');
    const otherInput=root.querySelector('#nia-other-amount');
    const error=root.querySelector('#nia-infaq-error');
    const result=root.querySelector('#nia-infaq-result');
    const summary=root.querySelector('#nia-infaq-summary');
    const rupiah=new Intl.NumberFormat('id-ID');
    const chosenNominal=()=>form.querySelector('input[name="nia_nominal"]:checked')?.value||'';
    const chosenMethod=()=>form.querySelector('input[name="nia_method"]:checked')?.value||'';
    const hideResult=()=>{result.classList.remove('show');error.classList.remove('show');error.textContent='';};
    const updateAmount=()=>{const custom=chosenNominal()==='lainnya';otherWrap.classList.toggle('active',custom);otherInput.required=custom;hideResult();};
    form.querySelectorAll('input[name="nia_nominal"]').forEach(input=>input.addEventListener('change',updateAmount));
    form.querySelectorAll('input[name="nia_method"]').forEach(input=>input.addEventListener('change',hideResult));
    otherInput.addEventListener('input',hideResult);
    form.addEventListener('submit',event=>{
        event.preventDefault();
        const nominal=chosenNominal()==='lainnya'?Number(otherInput.value):Number(chosenNominal());
        if(!Number.isSafeInteger(nominal)||nominal<1000||nominal>100000000){error.textContent='Masukkan nominal dari Rp1.000 sampai Rp100.000.000.';error.classList.add('show');result.classList.remove('show');if(chosenNominal()==='lainnya')otherInput.focus();return;}
        const metode=chosenMethod();
        summary.textContent='Rp'+rupiah.format(nominal)+' · '+metode;
        error.classList.remove('show');result.classList.add('show');
        result.scrollIntoView({behavior:window.matchMedia('(prefers-reduced-motion: reduce)').matches?'auto':'smooth',block:'nearest'});
    });
    updateAmount();
})();
</script>
@endsection
