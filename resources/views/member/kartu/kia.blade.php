@extends('layouts.member')
@section('title', 'Kartu Anggota Digital')
@section('content')
@php
    $cardUser = $user ?? auth()->user();
    $cardMember = $member ?? ($cardUser?->member ?? null);
    $cardNia = $nia ?? ($cardMember?->nia ?: ($cardUser?->nia ?? null));
@endphp
@include('components.kia-style')
<style>
    .ku-shell{max-width:1020px;margin:20px auto 60px;color:#173e2e;font-family:'DM Sans',sans-serif}
    .ku-intro{text-align:center;margin:0 auto 25px}
    .ku-eyebrow{font-size:11px;letter-spacing:.18em;font-weight:800;color:#7a8e7c;text-transform:uppercase}
    .ku-title{font-family:'Bebas Neue',Impact,sans-serif;font-size:clamp(42px,7vw,80px);line-height:1;margin:9px 0 5px;font-weight:400}
    .ku-subtitle{font-size:13px;color:#718275}
    .ku-preview{max-width:650px;margin:26px auto 0}
    .ku-actions{display:flex;flex-wrap:wrap;justify-content:center;gap:10px;margin:32px auto 0}
    .ku-btn{min-height:45px;display:inline-flex;align-items:center;justify-content:center;gap:8px;padding:12px 19px;border:1px solid #173d2e;border-radius:12px;background:#183c2f;color:#fff!important;text-decoration:none;font-size:12px;font-weight:800;cursor:pointer}
    .ku-btn.ku-outline{background:#fff;color:#183c2f!important;border-color:#c9d6cd}
    .ku-btn.ku-print{background:#fff;color:#183c2f!important;border-color:#183c2f}
    .ku-hint{text-align:center;font-size:12px;color:#849086;margin-top:18px}
    .ku-upload{max-width:650px;margin:45px auto 0;padding:22px;border:1px solid #d9e2d9;border-radius:18px;background:white}
    .ku-upload h2{font-weight:800;font-size:18px;margin:0 0 7px}
    .ku-upload p{color:#748275;font-size:12px;margin:0 0 15px;line-height:1.6}
    .ku-upload input{width:100%;border:1px solid #d4dfd3;border-radius:8px;padding:12px;margin-bottom:12px;font-size:12px}
    .ku-alert{padding:12px 14px;margin:14px auto;border-radius:10px;max-width:650px;background:#e8f4e8;border:1px solid #b7d4bc;font-size:13px}
    .ku-dialog{border:0;border-radius:20px;padding:20px;background:#f5f4f0;color:#173d2e;width:min(700px,calc(100vw - 28px));max-width:none;max-height:95vh;overflow:auto;box-shadow:0 20px 70px #0004}
    .ku-dialog::backdrop{background:#061910ce}
    .ku-dialog-head{display:flex;justify-content:space-between;align-items:center;gap:10px;margin-bottom:17px;font-size:12px;font-weight:800}
    .ku-close{border:1px solid #becdbf;background:white;border-radius:9px;width:38px;height:38px;cursor:pointer}
    .ku-flip-button{display:block;border:0;padding:0;background:transparent;width:100%;perspective:1300px;cursor:pointer}
    .ku-rotor{position:relative;width:100%;aspect-ratio:85.6/54;transform-style:preserve-3d;transition:transform .6s ease}
    .ku-rotor.is-flipped{transform:rotateY(180deg)}
    .ku-face{position:absolute;inset:0;backface-visibility:hidden;-webkit-backface-visibility:hidden}
    .ku-face.is-back{transform:rotateY(180deg)}
    .ku-face>.kia-unified-card{height:100%}
    @media(prefers-reduced-motion:reduce){.ku-rotor{transition:none}}
</style>
<div class="ku-shell">
    <div class="ku-intro">
        <div class="ku-eyebrow">NU LESMANA / PORTAL ANGGOTA</div>
        <h1 class="ku-title">KARTU ANGGOTA.</h1>
        <p class="ku-subtitle">Kartu identitas resmi anggota Ranting NU Lesmana.</p>
    </div>
    @if(session('success'))<div class="ku-alert" role="status">{{ session('success') }}</div>@endif
    @if($errors->any())<div class="ku-alert" role="alert" style="background:#fff2ee;border-color:#f0c7c1">{{ $errors->first() }}</div>@endif
    <div class="ku-preview">
        @include('components.kia-card', ['side' => 'front', 'user' => $cardUser, 'member' => $cardMember, 'nia' => $cardNia])
    </div>
    <div class="ku-actions">
        <button type="button" class="ku-btn" id="kuOpen">↻ Lihat Belakang</button>
        <a class="ku-btn ku-print" href="{{ route('member.cetak-kartu') }}">▤ Cetak KIA</a>
        <a class="ku-btn ku-outline" href="{{ route('member.dashboard') }}">← Dashboard Anggota</a>
    </div>
    <p class="ku-hint">Data kartu mengikuti identitas anggota yang disetujui pengurus.</p>
    @if(\Illuminate\Support\Facades\Route::has('member.foto.upload'))
    <section class="ku-upload">
        <h2>Perbarui Foto Anggota</h2>
        <p>Foto hasil pendaftaran akan dipakai pada KIA dan dashboard. Pilih foto yang sesuai untuk menggantinya (maksimal 2 MB).</p>
        <form action="{{ route('member.foto.upload', [], false) }}" method="POST" enctype="multipart/form-data">
            @csrf
            <label for="kuPhoto" style="display:block;font-size:12px;font-weight:800;margin-bottom:8px">Pilih foto JPG, PNG, atau WebP</label>
            <input type="file" name="foto" id="kuPhoto" accept="image/jpeg,image/png,image/webp" required>
            <button type="submit" class="ku-btn">Simpan Foto</button>
        </form>
    </section>
    @endif
</div>
<dialog class="ku-dialog" id="kuDialog" aria-label="Kartu anggota depan dan belakang">
    <div class="ku-dialog-head"><span>KARTU ANGGOTA / NU LESMANA</span><button type="button" class="ku-close" id="kuClose" aria-label="Tutup">✕</button></div>
    <button type="button" class="ku-flip-button" id="kuTurn" aria-label="Balik kartu" aria-pressed="false">
        <div class="ku-rotor" id="kuRotor">
            <div class="ku-face">@include('components.kia-card', ['side' => 'front', 'user' => $cardUser, 'member' => $cardMember, 'nia' => $cardNia])</div>
            <div class="ku-face is-back">@include('components.kia-card', ['side' => 'back', 'user' => $cardUser, 'member' => $cardMember, 'nia' => $cardNia])</div>
        </div>
    </button>
    <div class="ku-actions" style="margin-top:15px"><button class="ku-btn" id="kuFlip" type="button">↻ Balik Kartu</button><button type="button" id="kuCloseBottom" class="ku-btn ku-outline">Tutup</button></div>
</dialog>
<script>
(function(){
    const dialog=document.getElementById('kuDialog');
    const rotor=document.getElementById('kuRotor');
    const turn=document.getElementById('kuTurn');
    const open=document.getElementById('kuOpen');
    const closeButtons=[document.getElementById('kuClose'),document.getElementById('kuCloseBottom')];
    const flip=document.getElementById('kuFlip');
    function setFlip(next){rotor.classList.toggle('is-flipped',next);turn.setAttribute('aria-pressed',String(next));}
    open.addEventListener('click',()=>{setFlip(true);dialog.showModal();});
    function toggleFlip(){setFlip(!rotor.classList.contains('is-flipped'));}
    turn.addEventListener('click',toggleFlip);
    flip.addEventListener('click',toggleFlip);
    closeButtons.forEach(button=>button.addEventListener('click',()=>dialog.close()));
    dialog.addEventListener('close',()=>setFlip(false));
})();
</script>
@endsection
