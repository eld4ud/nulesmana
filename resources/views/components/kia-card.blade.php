
{{-- KIA bersama: dashboard, halaman KIA, modal, dan cetak. Desain mint-emas + QR. --}}
@php
    $cardUser = $user ?? auth()->user();
    $cardMember = $member ?? ($cardUser?->member ?? null);
    $cardName = $cardMember?->name ?: ($cardUser?->name ?? 'Anggota');
    $cardNia = $nia ?? ($cardMember?->nia ?: ($cardUser?->nia ?? 'Belum tersedia'));
    $cardBanom = $cardMember?->banom ?: 'Anggota NU';
    $cardGender = $cardMember?->gender ?: 'Belum diisi';
    $cardStatus = $cardMember?->status ?: ($cardUser?->status ?? 'pending');
    $cardSide = $side ?? 'front';
    $cardPhotoPath = $cardMember?->photo;
    $cardPhotoUrl = filled($cardPhotoPath) ? '/storage/' . ltrim($cardPhotoPath, '/') : null;
    $cardQRRouteExists = \Illuminate\Support\Facades\Route::has('member.kartu.qr-profile');
    $cardQRUrl = $cardQRRouteExists && $cardMember?->id
        ? route('member.kartu.qr-profile', ['member' => $cardMember->id], false)
        : null;
@endphp
@if($cardSide === 'back')
<div class="kia-unified-card kia-unified-back" aria-label="Kartu anggota sisi belakang">
    <div class="kia-unified-inner">
        <header class="kia-unified-heading">
            <div>
                <h3>Kartu Anggota</h3>
                <p>Pengurus Ranting NU Lesmana</p>
            </div>
            <span class="kia-unified-star" aria-hidden="true">✦</span>
        </header>
        <div class="kia-unified-divider"></div>
        <div class="kia-unified-back-main">
            <div class="kia-unified-back-copy">
                <strong>Informasi Kartu</strong>
                <ul>
                    <li>Simpan kartu dengan baik agar tetap terbaca.</li>
                    <li>Hindarkan dari kerusakan, panas, dan air.</li>
                    <li>Jika hilang, hubungi pengurus organisasi.</li>
                </ul>
                <p>Jika ditemukan, mohon kembalikan kepada:<br><b>Pengurus Ranting NU Lesmana</b></p>
            </div>
            <div class="kia-unified-qr-side">
                <div class="kia-unified-qr" @if($cardQRUrl) data-nla-qr="{{ $cardQRUrl }}" @endif>
                    <small>{{ $cardQRUrl ? 'Memuat QR…' : 'QR belum tersedia' }}</small>
                </div>
                <span>SCAN KIA</span>
            </div>
        </div>
        <footer class="kia-unified-footer">
            <span>PINDAI DENGAN AKUN PEMILIK KARTU</span>
            <span>NU LESMANA</span>
        </footer>
    </div>
</div>
@else
<div class="kia-unified-card kia-unified-front" aria-label="Kartu anggota sisi depan">
    <div class="kia-unified-inner">
        <header class="kia-unified-heading">
            <div>
                <h3>Kartu Anggota</h3>
                <p>Pengurus Ranting NU Lesmana</p>
            </div>
            <span class="kia-unified-star" aria-hidden="true">✦</span>
        </header>
        <div class="kia-unified-divider"></div>
        <div class="kia-unified-main">
            <div class="kia-unified-photo">
                @if($cardPhotoUrl)
                    <img src="{{ $cardPhotoUrl }}" alt="Foto {{ $cardName }}" onerror="this.hidden=true;this.nextElementSibling.hidden=false">
                    <span hidden>{{ mb_strtoupper(mb_substr($cardName, 0, 1)) }}</span>
                @else
                    <span>{{ mb_strtoupper(mb_substr($cardName, 0, 1)) }}</span>
                @endif
            </div>
            <div class="kia-unified-fields">
                <span>Nama Lengkap</span>
                <strong>{{ $cardName }}</strong>
                <span>NIA</span>
                <strong class="kia-unified-number">{{ $cardNia }}</strong>
                <span>Banom</span>
                <strong>{{ $cardBanom }}</strong>
                <span>Jenis Kelamin</span>
                <strong>{{ $cardGender }}</strong>
            </div>
        </div>
        <footer class="kia-unified-footer">
            <span>{{ $cardStatus === 'approved' ? 'ANGGOTA TERVERIFIKASI' : 'STATUS: ' . strtoupper($cardStatus) }}</span>
            <span>NU LESMANA</span>
        </footer>
    </div>
</div>
@endif
@once
<style>
.kia-unified-card{position:relative;box-sizing:border-box;width:100%;aspect-ratio:85.6/54;overflow:hidden;border:1px solid #d5d9c8;border-radius:16px;background:#edf4e9;color:#173d2e;font-family:'DM Sans',Arial,sans-serif;text-align:left;container-type:inline-size;box-shadow:0 5px 0 #b69c60,0 15px 32px #183c2f14}
.kia-unified-card *{box-sizing:border-box}
.kia-unified-card::before{content:'';position:absolute;inset:1.2%;border:1px solid #cdbd90;border-radius:12px;pointer-events:none}
.kia-unified-inner{height:100%;position:relative;display:flex;flex-direction:column;padding:4.2% 5% 3.7%}
.kia-unified-heading{display:flex;align-items:center;justify-content:space-between;gap:3%}
.kia-unified-heading h3{font:700 5.2cqw/1.05 Georgia,'Times New Roman',serif;letter-spacing:-.03em;color:#173f30;margin:0}
.kia-unified-heading p{font-size:1.8cqw;color:#698073;margin:.65cqw 0 0;line-height:1.25}
.kia-unified-star{color:#ac9056;font-size:3.7cqw}
.kia-unified-divider{height:1px;margin:3% 0;background:#cbd7c8;flex-shrink:0}
.kia-unified-main{display:flex;align-items:center;gap:5%;flex:1;min-height:0}
.kia-unified-photo{position:relative;flex:0 0 25%;height:77%;max-height:100%;display:grid;place-items:center;overflow:hidden;border:1px solid #c6d1c3;border-radius:8px;background:#dce9dc;color:#46735a;font:700 14cqw Georgia,serif}
.kia-unified-photo img{width:100%;height:100%;display:block;object-fit:cover;object-position:center 25%}
.kia-unified-photo img[hidden]{display:none}
.kia-unified-photo span[hidden]{display:none}
.kia-unified-fields{display:flex;min-width:0;flex:1;flex-direction:column;justify-content:center;gap:.55cqw}
.kia-unified-fields span{font-size:1.73cqw;line-height:1.15;text-transform:uppercase;font-weight:750;color:#758d7c}
.kia-unified-fields strong{font-size:2.76cqw;line-height:1.12;font-weight:800;overflow-wrap:anywhere;color:#173d2e;margin-bottom:1.05cqw}
.kia-unified-fields .kia-unified-number{font-size:2.9cqw;letter-spacing:.005em}
.kia-unified-footer{display:flex;align-items:center;justify-content:space-between;gap:3%;margin-top:3%;padding-top:2.75%;border-top:1px solid #cad7c9;font-size:1.62cqw;line-height:1.2;font-weight:800;color:#718b76;text-transform:uppercase}
.kia-unified-back-main{display:flex;flex:1;align-items:center;gap:4%;min-height:0}
.kia-unified-back-copy{flex:1;min-width:0;font-size:2.0cqw;line-height:1.43;color:#345d48}
.kia-unified-back-copy>strong{font-size:2.7cqw;color:#173d2e}
.kia-unified-back-copy ul{padding-left:1.35em;margin:1.2cqw 0 2cqw}
.kia-unified-back-copy li{margin-bottom:.6cqw}
.kia-unified-back-copy p{margin:0;border:1px solid #d1dbc8;background:#f7faf3;padding:1.2cqw;border-radius:3px}
.kia-unified-qr-side{flex:0 0 23%;text-align:center}
.kia-unified-qr{width:100%;aspect-ratio:1;display:grid;place-items:center;padding:5%;border:1px solid #cbd5c5;border-radius:5px;background:#fff}
.kia-unified-qr canvas,.kia-unified-qr img{width:100%!important;height:auto!important;display:block}
.kia-unified-qr small{font-size:1.65cqw;color:#657669;overflow-wrap:anywhere}
.kia-unified-qr-side>span{display:block;font-size:1.75cqw;font-weight:800;letter-spacing:.12em;margin-top:1.2cqw}
@supports not (font-size:1cqw){
.kia-unified-heading h3{font-size:22px}
.kia-unified-heading p{font-size:9px}
.kia-unified-fields span{font-size:8px}
.kia-unified-fields strong{font-size:12px}
.kia-unified-footer{font-size:8px}
.kia-unified-back-copy{font-size:9px}
.kia-unified-back-copy>strong{font-size:12px}
}
@media print{
.kia-unified-card{width:85.6mm!important;height:54mm!important;aspect-ratio:auto!important;border-radius:2mm!important;box-shadow:none!important;break-inside:avoid;-webkit-print-color-adjust:exact;print-color-adjust:exact}
.kia-unified-card::before{border-radius:1mm}
.kia-unified-photo{border-radius:1mm}
}
</style>
<script src="https://cdnjs.cloudflare.com/ajax/libs/qrcodejs/1.0.0/qrcode.min.js" defer></script>
<script>
(function () {
    function renderNlaQR() {
        const qrLibrary = window['QRCode'];
        document.querySelectorAll('[data-nla-qr]').forEach(function (element) {
            if (element.dataset.nlaQrRendered === '1') return;
            if (typeof qrLibrary !== 'function') {
                element.innerHTML = '<small>QR belum dapat dimuat. Periksa koneksi internet.</small>';
                return;
            }
            try {
                const path = element.dataset.nlaQr;
                if (!path) {
                    element.innerHTML = '<small>QR belum tersedia</small>';
                    return;
                }
                const fullUrl = /^https?:\/\//i.test(path)
                    ? path
                    : window.location.origin + (path.startsWith('/') ? '' : '/') + path;
                element.replaceChildren();
                Reflect.construct(qrLibrary, [
                    element,
                    {
                        text: fullUrl,
                        width: 180,
                        height: 180,
                        correctLevel: qrLibrary.CorrectLevel.M,
                        colorDark: '#183C2F',
                        colorLight: '#FFFFFF'
                    }
                ]);
                element.dataset.nlaQrRendered = '1';
            } catch (error) {
                element.innerHTML = '<small>QR tidak tersedia</small>';
            }
        });
    }
    if (document.readyState === 'complete') {
        renderNlaQR();
    } else {
        window.addEventListener('load', renderNlaQR, { once: true });
    }
})();
</script>
@endonce
