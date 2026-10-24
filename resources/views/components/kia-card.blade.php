{{-- Satu sumber desain untuk kartu di dashboard, halaman KIA, dan hasil cetak. --}}
@php
    $kiaUser = $user ?? auth()->user();
    $kiaMember = $member ?? $kiaUser?->member;
    $kiaName = $kiaMember?->name ?: $kiaUser?->name ?: 'Anggota';
    $kiaNia = $nia ?? ($kiaMember?->nia ?: $kiaUser?->nia ?: 'Belum tersedia');
    $kiaBanom = $kiaMember?->banom ?: 'Anggota NU';
    $kiaSide = $side ?? 'front';
    $kiaPhoto = $photoUrl ?? ($kiaMember?->photo
        ? \Illuminate\Support\Facades\Storage::disk('public')->url($kiaMember->photo)
        : null);
@endphp

@if($kiaSide === 'front')
<div class="nla-id-card nla-id-front" aria-label="Kartu anggota sisi depan">
    <div class="nla-id-inner">
        <header class="nla-id-title">Kartu Anggota</header>
        <div class="nla-id-rule"><span></span><b>✦</b><span></span></div>
        <div class="nla-id-person">
            <div class="nla-id-portrait">
                @if($kiaPhoto)
                    <img src="{{ $kiaPhoto }}" alt="Foto {{ $kiaName }}">
                @else
                    <span>{{ mb_strtoupper(mb_substr($kiaName, 0, 1)) }}</span>
                @endif
                <small>Foto anggota</small>
            </div>
            <div class="nla-id-fields">
                <span>Nama</span>
                <strong>{{ $kiaName }}</strong>
                <span>NIA</span>
                <strong class="nla-id-number">{{ $kiaNia }}</strong>
                <span>Banom</span>
                <strong>{{ $kiaBanom }}</strong>
            </div>
        </div>
        <footer class="nla-id-footer"><span>IDENTITAS KEANGGOTAAN</span><span>NU LESMANA</span></footer>
    </div>
</div>
@else
<div class="nla-id-card nla-id-back" aria-label="Kartu anggota sisi belakang">
    <div class="nla-id-inner">
        <header class="nla-id-title">Kartu Anggota</header>
        <div class="nla-id-rule"><span></span><b>✦</b><span></span></div>
        <div class="nla-id-back-layout">
            <div class="nla-id-back-copy">
                <strong>Perawatan &amp; pengembalian</strong>
                <ul>
                    <li>Simpan kartu dengan baik agar tetap terbaca.</li>
                    <li>Hindarkan dari panas, air, dan lipatan.</li>
                    <li>Jika hilang, hubungi pengurus organisasi.</li>
                </ul>
                <div class="nla-id-note">
                    Jika ditemukan, mohon kembalikan kepada:<br>
                    <b>Pengurus Ranting NU Lesmana</b>
                </div>
            </div>
            <div class="nla-id-qr-wrap">
                @if($kiaMember && $kiaMember->user_id)
                    <div class="nla-id-qr" data-nla-qr="{{ route('member.kartu.qr-profile', ['member' => $kiaMember->id], false) }}" aria-label="QR menuju kartu anggota setelah login">
                        <small>Memuat QR…</small>
                    </div>
                @else
                    <div class="nla-id-qr"><small>QR belum tersedia</small></div>
                @endif
                <span>SCAN KIA</span>
            </div>
        </div>
        <footer class="nla-id-footer"><span>PINDAI DENGAN AKUN PEMILIK KARTU</span><span>NU LESMANA</span></footer>
    </div>
</div>
@endif

@once
<style>
/* Proporsi kartu ATM standar 85.6 x 54 mm; satu gaya lintas halaman. */
.nla-id-card{aspect-ratio:85.6/54;width:100%;position:relative;overflow:hidden;border-radius:13px;background:linear-gradient(125deg,#e8f2e9 0%,#f4f7ed 46%,#ecf2e8 100%);color:#194b3c;border:1px solid #d1d9ca;box-shadow:0 14px 35px #123a2e1e;font-family:'DM Sans',Arial,sans-serif;container-type:inline-size}
.nla-id-card::before{content:"";position:absolute;inset:2%;border:1px solid #cfb77b;border-radius:9px;pointer-events:none}
.nla-id-card::after{content:"";position:absolute;inset:0;background:repeating-radial-gradient(ellipse at 110% 80%,transparent 0 11px,#b3cfbd22 12px 13px,transparent 14px 20px);pointer-events:none}
.nla-id-inner{position:relative;z-index:1;width:100%;height:100%;padding:4.5% 5.5% 0;display:flex;flex-direction:column;box-sizing:border-box}
.nla-id-title{font:700 5.7cqw/1.05 Georgia,'Times New Roman',serif;letter-spacing:-.04em;color:#13503e}
.nla-id-rule{display:flex;align-items:center;gap:8px;margin-top:3.2%;color:#c8ad70;font-size:2.7cqw}
.nla-id-rule span{height:1px;background:#c8ad70;flex:1}
.nla-id-rule span:first-child{flex:.37}
.nla-id-person{display:flex;align-items:center;flex:1;min-height:0;gap:5%;padding:3% 0 4%}
.nla-id-portrait{width:25%;height:100%;max-height:95%;border-radius:5px;border:1px solid #cbd4c9;background:#dcebe0;display:flex;flex-direction:column;justify-content:end;overflow:hidden;position:relative;color:#678f79;text-align:center;flex-shrink:0}
.nla-id-portrait>span{font-size:19cqw;font-family:Georgia,serif;line-height:1;margin:auto;font-weight:700}
.nla-id-portrait img{width:100%;height:100%;object-fit:cover;object-position:center 28%;position:absolute;inset:0}
.nla-id-portrait small{position:relative;z-index:1;background:#ffffffdc;color:#587569;font-size:1.75cqw;padding:2% 0}
.nla-id-fields{display:flex;flex-direction:column;min-width:0;flex:1;gap:.4cqw;line-height:1.2}
.nla-id-fields>span{font-size:2.05cqw;color:#537768}
.nla-id-fields>strong{font-weight:750;font-size:3.65cqw;overflow-wrap:anywhere;color:#184d3d;line-height:1.07;margin-bottom:1.5cqw}
.nla-id-fields .nla-id-number{font-size:3.55cqw;letter-spacing:.01em;font-family:'DM Sans',Arial,sans-serif}
.nla-id-footer{background:#166046;color:white;padding:2.3% 4%;display:flex;align-items:center;justify-content:space-between;gap:8px;font-size:1.7cqw;letter-spacing:.07em;font-weight:750;margin:auto -5.5% 0;border-top:2px solid #c8ad70}
.nla-id-back-layout{display:flex;flex:1;gap:4%;align-items:center;min-height:0;padding:3% 0 4%}
.nla-id-back-copy{min-width:0;flex:1;font-size:2.15cqw;line-height:1.55;color:#2b6450}
.nla-id-back-copy>strong{display:block;margin-bottom:1.3cqw;font-size:2.9cqw;color:#185442}
.nla-id-back-copy ul{padding-left:1.7em;margin:0 0 3cqw}
.nla-id-back-copy li{margin-bottom:.5cqw}
.nla-id-note{padding:2%;border:1px solid #d3ddce;border-radius:4px;background:#f7f9f3c9;font-size:1.9cqw}
.nla-id-qr-wrap{width:24%;min-width:0;text-align:center;flex-shrink:0}
.nla-id-qr{aspect-ratio:1;background:#fff;display:grid;place-items:center;padding:5%;border-radius:4px;border:1px solid #d3dbce;box-sizing:border-box}
.nla-id-qr img,.nla-id-qr canvas{width:100%!important;height:auto!important;display:block}
.nla-id-qr small{color:#777;font-size:1.7cqw}
.nla-id-qr-wrap>span{display:block;font-size:1.8cqw;letter-spacing:.12em;font-weight:800;margin-top:1.2cqw}
/* fallback pada browser lama yang belum mendukung cqw */
@supports not (font-size:1cqw){.nla-id-title{font-size:21px}.nla-id-fields>span{font-size:8px}.nla-id-fields>strong{font-size:13px}.nla-id-footer{font-size:7px}.nla-id-back-copy{font-size:8px}.nla-id-back-copy>strong{font-size:11px}.nla-id-note{font-size:7px}}
@media print{.nla-id-card{width:85.6mm!important;height:54mm!important;aspect-ratio:auto;border-radius:2mm;box-shadow:none;break-inside:avoid;print-color-adjust:exact;-webkit-print-color-adjust:exact}}
</style>
<script src="https://cdnjs.cloudflare.com/ajax/libs/qrcodejs/1.0.0/qrcode.min.js" defer></script>
<script>
window.addEventListener('load', function () {
    document.querySelectorAll('[data-nla-qr]').forEach(function (el) {
        if (el.dataset.nlaQrRendered) return;
        if (typeof QRCode === 'undefined') {
            el.innerHTML = '<small>QR tidak termuat. Periksa internet.</small>';
            return;
        }
        const url = new URL(el.dataset.nlaQr, window.location.origin).href;
        el.replaceChildren();
        new QRCode(el, { text: url, width: 160, height: 160, correctLevel: QRCode.CorrectLevel.M, colorDark: '#183C2F', colorLight: '#FFFFFF' });
        el.dataset.nlaQrRendered = '1';
    });
});
</script>
@endonce
