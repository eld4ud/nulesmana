@php
    $cardUser = $user ?? auth()->user();
    $cardMember = $member ?? $cardUser?->member;
    $cardNia = $nia ?? ($cardUser?->nia ?: $cardMember?->nia ?: 'Belum tersedia');
    $cardPhoto = $photoUrl ?? null;
    if (!$cardPhoto && $cardUser) {
        foreach (\Illuminate\Support\Facades\Storage::disk('public')->files('member-photos/'.$cardUser->id) as $f) {
            if (preg_match('/\/avatar\.(jpg|jpeg|png|webp)$/i', $f)) {
                $cardPhoto = \Illuminate\Support\Facades\Storage::disk('public')->url($f);
                break;
            }
        }
    }
@endphp
<div x-data="{ open:false, flipped:false }" class="nl-kia-widget">
    <button type="button" @click="open=true; flipped=false" class="nl-kia-trigger" aria-label="Buka detail kartu anggota">
        <div class="nl-kia-card nl-kia-front">
            <div class="nl-kia-top"><span>PRNU LESMANA <small>KARTU IDENTITAS ANGGOTA</small></span><span class="nl-kia-mark">NU</span></div>
            <div class="nl-kia-content">
                <div class="nl-kia-photo">
                    @if($cardPhoto)<img src="{{ $cardPhoto }}" alt="Foto anggota">@else<span>{{ strtoupper(substr($cardUser?->name ?? 'A',0,1)) }}</span>@endif
                </div>
                <div class="nl-kia-fields"><span>NAMA ANGGOTA</span><strong>{{ $cardMember?->name ?: $cardUser?->name }}</strong><span>BANOM</span><b>{{ $cardMember?->banom ?: 'Anggota' }}</b><span>NIA</span><b class="nl-kia-nia">{{ $cardNia }}</b></div>
            </div>
            <div class="nl-kia-bottom"><span>ANGGOTA TERVERIFIKASI</span><span>NU LESMANA • {{ date('Y') }}</span></div>
        </div>
        <span class="nl-kia-hint">Klik kartu untuk memperbesar dan membaliknya ↗</span>
    </button>
    <template x-teleport="body">
        <div x-show="open" x-cloak class="nl-kia-overlay" role="dialog" aria-modal="true" aria-label="Detail KIA" @keydown.escape.window="open=false" @click.self="open=false">
            <div class="nl-kia-dialog">
                <div class="nl-kia-dialogbar"><strong>KIA DIGITAL · NU LESMANA</strong><button type="button" @click="open=false" aria-label="Tutup">✕</button></div>
                <button type="button" class="nl-kia-flipbox" @click="flipped=!flipped" :aria-label="flipped ? 'Tampilkan depan kartu' : 'Tampilkan belakang kartu'">
                    <div class="nl-kia-rotor" :class="{ 'nl-kia-turned': flipped }">
                        <div class="nl-kia-face nl-kia-card nl-kia-front">
                            <div class="nl-kia-top"><span>PRNU LESMANA <small>KARTU IDENTITAS ANGGOTA</small></span><span class="nl-kia-mark">NU</span></div>
                            <div class="nl-kia-content"><div class="nl-kia-photo">@if($cardPhoto)<img src="{{ $cardPhoto }}" alt="Foto anggota">@else<span>{{ strtoupper(substr($cardUser?->name ?? 'A',0,1)) }}</span>@endif</div><div class="nl-kia-fields"><span>NAMA ANGGOTA</span><strong>{{ $cardMember?->name ?: $cardUser?->name }}</strong><span>BANOM</span><b>{{ $cardMember?->banom ?: 'Anggota' }}</b><span>NIA</span><b class="nl-kia-nia">{{ $cardNia }}</b></div></div>
                            <div class="nl-kia-bottom"><span>ANGGOTA TERVERIFIKASI</span><span>NU LESMANA • {{ date('Y') }}</span></div>
                        </div>
                        <div class="nl-kia-face nl-kia-back"><div class="nl-kia-backmark">NU</div><h3>NU LESMANA</h3><p>Kartu identitas digital anggota terverifikasi.</p><div class="nl-kia-backnia">NIA · {{ $cardNia }}</div><small>Kartu ini hanya berlaku bagi anggota yang terdaftar dan berstatus aktif.</small></div>
                    </div>
                </button>
                <p class="nl-kia-tip">Klik kartu untuk melihat sisi lainnya</p>
                <div class="nl-kia-actions"><a href="{{ route('member.cetak-kartu') }}">Halaman Cetak ↗</a><a href="{{ route('member.kia') }}">Profil KIA</a><button type="button" @click="open=false">Tutup</button></div>
            </div>
        </div>
    </template>
</div>
@once
<style>
[x-cloak]{display:none!important}.nl-kia-widget{width:100%;font-family:Arial,sans-serif}.nl-kia-trigger{border:0;background:transparent;padding:0;display:block;width:100%;text-align:left;cursor:pointer}.nl-kia-card{position:relative;aspect-ratio:85.6/54;width:100%;max-width:540px;overflow:hidden;border-radius:20px;padding:6%;box-sizing:border-box;background:linear-gradient(135deg,#183c2f 0%,#123326 70%,#255640 100%);color:#f5f4f0;box-shadow:0 18px 35px #0e291b33;display:flex;flex-direction:column;justify-content:space-between}.nl-kia-top,.nl-kia-bottom{display:flex;align-items:center;justify-content:space-between;gap:10px}.nl-kia-top{font-size:clamp(12px,2vw,18px);font-weight:900;letter-spacing:.04em}.nl-kia-top small{display:block;font-size:clamp(6px,1vw,9px);font-weight:600;letter-spacing:.13em;margin-top:5px;opacity:.7}.nl-kia-mark{display:grid;place-items:center;width:45px;height:45px;border:1px solid #ffffff77;border-radius:50%;font-size:15px}.nl-kia-content{display:flex;gap:6%;align-items:center}.nl-kia-photo{width:25%;aspect-ratio:3/4;background:#f5f4f0;border:3px solid #e1d9b5;border-radius:9px;display:grid;place-items:center;color:#183c2f;font-size:40px;font-weight:900;overflow:hidden;flex-shrink:0}.nl-kia-photo img{width:100%;height:100%;object-fit:cover}.nl-kia-fields{min-width:0;display:flex;flex-direction:column;gap:2px}.nl-kia-fields span{font-size:clamp(6px,1vw,9px);letter-spacing:.1em;opacity:.68;margin-top:3px}.nl-kia-fields strong{font-size:clamp(12px,2vw,21px);line-height:1.1;overflow-wrap:anywhere}.nl-kia-fields b{font-size:clamp(10px,1.5vw,14px);overflow-wrap:anywhere}.nl-kia-fields .nl-kia-nia{color:#e1d9b5;font-family:monospace}.nl-kia-bottom{font-size:clamp(6px,1vw,9px);letter-spacing:.08em;border-top:1px solid #ffffff44;padding-top:10px}.nl-kia-hint{display:block;margin:12px 0;color:#59635e;font-size:12px;font-weight:700}.nl-kia-overlay{position:fixed;inset:0;background:#071a13d9;z-index:99999;display:flex;align-items:center;justify-content:center;padding:18px;backdrop-filter:blur(10px)}.nl-kia-dialog{width:min(650px,100%);background:#f5f4f0;border-radius:24px;padding:20px;box-shadow:0 25px 80px #0008}.nl-kia-dialogbar{display:flex;justify-content:space-between;align-items:center;color:#183c2f;margin-bottom:18px;font-size:12px;letter-spacing:.08em}.nl-kia-dialogbar button{border:0;background:#e1e7e1;border-radius:50%;height:35px;width:35px;cursor:pointer}.nl-kia-flipbox{display:block;border:0;background:transparent;width:min(540px,100%);aspect-ratio:85.6/54;margin:auto;padding:0;perspective:1200px;cursor:pointer}.nl-kia-rotor{width:100%;height:100%;position:relative;transform-style:preserve-3d;transition:transform .75s cubic-bezier(.2,.7,.2,1)}.nl-kia-rotor.nl-kia-turned{transform:rotateY(180deg)}.nl-kia-face{position:absolute;inset:0;width:100%;height:100%;backface-visibility:hidden;-webkit-backface-visibility:hidden}.nl-kia-back{transform:rotateY(180deg);border-radius:20px;background:linear-gradient(140deg,#183c2f,#255640);color:#f5f4f0;display:flex;flex-direction:column;align-items:center;justify-content:center;text-align:center;padding:30px;box-sizing:border-box}.nl-kia-backmark{border:2px solid #e1d9b5;border-radius:50%;width:65px;height:65px;display:grid;place-items:center;font-size:22px;font-weight:900}.nl-kia-back h3{margin:12px 0 3px;font-size:22px}.nl-kia-back p{font-size:12px}.nl-kia-backnia{border-top:1px solid #ffffff55;border-bottom:1px solid #ffffff55;padding:10px;margin:10px 0;font-family:monospace;font-size:12px}.nl-kia-back small{font-size:10px;opacity:.8}.nl-kia-tip{text-align:center;color:#65766b;font-size:12px}.nl-kia-actions{display:flex;flex-wrap:wrap;gap:8px;justify-content:center}.nl-kia-actions a,.nl-kia-actions button{border:1px solid #183c2f;border-radius:10px;padding:10px 13px;text-decoration:none;font-size:12px;font-weight:800;color:#183c2f;background:transparent;cursor:pointer}.nl-kia-actions a:first-child{background:#183c2f;color:white}@media(max-width:500px){.nl-kia-card{border-radius:14px}.nl-kia-mark{width:30px;height:30px;font-size:11px}.nl-kia-photo{border-width:2px}.nl-kia-bottom{padding-top:5px}.nl-kia-dialog{padding:12px}.nl-kia-backmark{width:40px;height:40px;font-size:14px}.nl-kia-back h3{font-size:15px}.nl-kia-back p,.nl-kia-backnia{font-size:9px}.nl-kia-back small{font-size:8px}}@media(prefers-reduced-motion:reduce){.nl-kia-rotor{transition:none}}
</style>
@endonce
