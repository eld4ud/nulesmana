@extends('layouts.member')
@section('title', 'KIA Digital')
@section('content')
<style>
:root {
    --forest: #183c2f;
    --ivory: #f5f4f0;
    --muted: #7a8c80;
}
.kia-shell {
    font-family: Arial,sans-serif;
    color: var(--forest);
    max-width: 1120px;
    margin: 24px auto;
    padding: 22px;
}
.kia-grid {
    display: grid;
    grid-template-columns: minmax(0,1fr) minmax(0,1.2fr);
    gap: 26px;
    align-items: center;
}
.kia-panel {
    background: #fff;
    border: 1px solid #e8ebe6;
    border-radius: 26px;
    padding: 32px;
    box-shadow: 0 12px 38px #183c2f0c;
}
.kia-kicker {
    font-size: 11px;
    font-weight: 900;
    letter-spacing: 2px;
    text-transform: uppercase;
}
.kia-title {
    font-size: clamp(28px,4vw,46px);
    line-height: 1.08;
    margin: 14px 0;
}
.kia-description {
    color: #64766c;
    line-height: 1.7;
    font-size: 14px;
}
.kia-actions {
    display: flex;
    gap: 10px;
    flex-wrap: wrap;
    margin-top: 23px;
}
.kia-btn {
    display: inline-block;
    background: var(--forest);
    color: white!important;
    border: 0;
    border-radius: 12px;
    padding: 12px 16px;
    font-size: 13px;
    font-weight: 800;
    text-decoration: none;
    cursor: pointer;
}
.kia-btn.secondary {
    background: var(--ivory);
    color: var(--forest)!important;
}
.kia-card-button {
    border: 0;
    background: transparent;
    padding: 0;
    cursor: pointer;
    width: 100%;
    text-align: left;
}
.kia-card {
    width: 100%;
    max-width: 480px;
    aspect-ratio: 85.6/54;
    border-radius: 19px;
    padding: 6%;
    box-sizing: border-box;
    background: linear-gradient(145deg,#214f3c,#102e24);
    color: var(--ivory);
    box-shadow: 0 18px 38px #122c2240;
    position: relative;
    overflow: hidden;
}
.kia-card:after {
    content: '';
    position: absolute;
    width: 210px;
    height: 210px;
    border: 1px solid #ffffff23;
    border-radius: 50%;
    right: -75px;
    top: -100px;
}
.kia-card h3 {
    font-size: clamp(17px,2vw,24px);
    margin: 3px 0 18px;
    font-weight: 900;
    letter-spacing: .3px;
}
.kia-card small {
    font-size: 9px;
    letter-spacing: 1.2px;
    color: #d2dfd6;
}
.kia-content {
    display: flex;
    align-items: center;
    gap: 18px;
}
.kia-photo {
    width: 28%;
    aspect-ratio: 3/4;
    border: 2px solid #d8e1d6;
    border-radius: 11px;
    overflow: hidden;
    background: #f5f4f0;
    color: #183c2f;
    display: grid;
    place-items: center;
    font-size: 40px;
    font-weight: 900;
    flex-shrink: 0;
}
.kia-photo img {
    width: 100%;
    height: 100%;
    object-fit: cover;
}
.kia-details {
    min-width: 0;
    display: grid;
    gap: 8px;
}
.kia-details span {
    font-size: 9px;
    opacity: .75;
    display: block;
}
.kia-details strong {
    font-size: clamp(11px,1.5vw,16px);
    overflow-wrap: anywhere;
    display: block;
}
.kia-card-footer {
    font-size: 9px;
    margin-top: 13px;
    border-top: 1px solid #ffffff50;
    padding-top: 9px;
}
.kia-hint {
    font-size: 12px;
    color: #6b7c72;
    margin-top: 14px;
}
.kia-overlay[hidden] {
    display: none!important;
}
.kia-overlay {
    position: fixed;
    inset: 0;
    background: #071a14d9;
    z-index: 99999;
    display: grid;
    place-items: center;
    padding: 22px;
}
.kia-dialog {
    width: min(100%,610px);
    position: relative;
}
.kia-modal-top {
    display: flex;
    justify-content: space-between;
    align-items: center;
    color: white;
    margin-bottom: 14px;
    gap: 10px;
}
.kia-close {
    border: 1px solid #ffffff55;
    background: #ffffff22;
    color: white;
    border-radius: 10px;
    padding: 10px 14px;
    cursor: pointer;
}
.kia-scene {
    perspective: 1100px;
    cursor: pointer;
}
.kia-rotor {
    position: relative;
    aspect-ratio: 85.6/54;
    transform-style: preserve-3d;
    transition: transform .65s cubic-bezier(.2,.8,.2,1);
}
.kia-rotor.flipped {
    transform: rotateY(180deg);
}
.kia-face {
    position: absolute;
    inset: 0;
    backface-visibility: hidden;
    -webkit-backface-visibility: hidden;
}
.kia-face .kia-card {
    max-width: none;
    height: 100%;
    box-shadow: none;
}
.kia-face.back {
    transform: rotateY(180deg);
}
.kia-back {
    display: flex;
    flex-direction: column;
    justify-content: center;
    text-align: center;
    align-items: center;
    gap: 12px;
}
.kia-back h3 {
    font-size: 26px;
    margin: 0;
}
.kia-back p {
    font-size: 13px;
    line-height: 1.6;
    max-width: 320px;
}
.kia-flip {
    color: white;
    background: none;
    border: 1px solid #ffffff66;
    border-radius: 12px;
    padding: 10px 16px;
    margin-top: 15px;
    cursor: pointer;
}
.kia-upload {
    margin-top: 22px;
    padding-top: 20px;
    border-top: 1px solid #e7ece7;
}
.kia-upload input {
    width: 100%;
    margin: 12px 0;
    font-size: 13px;
}
.kia-upload label {
    display: block;
    font-weight: 800;
    font-size: 13px;
}
.kia-success {
    padding: 12px;
    border-radius: 10px;
    background: #e7f4e8;
    color: #21603b;
    font-size: 13px;
    margin: 15px 0;
}
@media(max-width:790px) {
    .kia-grid {
        grid-template-columns: 1fr;
    }
    .kia-panel {
        padding: 24px;
    }
    .kia-card {
        margin: auto;
    }
    .kia-shell {
        padding: 12px;
    }
}
</style>
<div class="kia-shell">
    <div class="kia-grid">
        <section class="kia-panel">
            <div class="kia-kicker">
                NU LESMANA · PORTAL ANGGOTA
            </div>
            <h1 class="kia-title">
                KIA Digital Saya
            </h1>
            <p class="kia-description">
                Lihat identitas keanggotaan, unggah foto profil, dan cetak kartu. Klik pratinjau kartu untuk membuka tampilan besar dan membaliknya.
            </p>
            @if(session('success'))
            <div class="kia-success">
                {{ session('success') }}
            </div>
            @endif

            <div class="kia-actions">
                <a class="kia-btn" href="{{ route('member.cetak-kartu') }}">
                    Cetak Kartu ↗
                </a>
                <a class="kia-btn secondary" href="{{ route('member.dashboard') }}">
                    Dashboard
                </a>
                <a class="kia-btn secondary" href="{{ url('/') }}">
                    Website Utama
                </a>
            </div>
            <div class="kia-upload">
                <h2 style="font-size:20px;font-weight:900;margin:0 0 8px">
                    Foto Profil Anggota
                </h2>
                <p class="kia-description">
                    Foto ditampilkan pada KIA dan hasil cetak.
                </p>
                @if(Route::has('member.foto.upload'))
                <form action="{{ route('member.foto.upload') }}" method="POST" enctype="multipart/form-data">
                    @csrf

                    <label for="kiaFoto">
                        Pilih foto JPG, PNG, atau WebP (maksimal 2 MB)
                    </label>
                    <input id="kiaFoto" name="foto" type="file" accept="image/jpeg,image/png,image/webp" required>
                    @error('foto')
                    <p style="color:#b42318;font-size:12px">
                        {{ $message }}
                    </p>
                    @enderror
                    <button class="kia-btn" type="submit">
                        Simpan Foto
                    </button>
                </form>
                @else

                <p class="kia-description">
                    Route unggah foto belum terdaftar. Periksa route
                    <code>
                        member.foto.upload
                    </code>
                    .
                </p>
                @endif

            </div>
        </section>
        <section>
            <button type="button" class="kia-card-button" data-open-kia aria-label="Perbesar dan balik kartu">
                <div class="kia-card">
                    <small>
                        PENGURUS RANTING · KARTU IDENTITAS ANGGOTA
                    </small>
                    <h3>
                        NU LESMANA
                    </h3>
                    <div class="kia-content">
                        <div class="kia-photo">
                            @if(!empty($photoUrl))
                            <img src="{{ $photoUrl }}" alt="Foto anggota">
                            @else
{{ strtoupper(mb_substr($user->name, 0, 1)) }}
                            @endif

                        </div>
                        <div class="kia-details">
                            <div>
                                <span>
                                    NAMA ANGGOTA
                                </span>
                                <strong>
                                    {{ $member->name ?: $user->name }}
                                </strong>
                            </div>
                            <div>
                                <span>
                                    BANOM
                                </span>
                                <strong>
                                    {{ $member->banom ?: 'Anggota' }}
                                </strong>
                            </div>
                            <div>
                                <span>
                                    NOMOR INDUK ANGGOTA
                                </span>
                                <strong>
                                    {{ $nia }}
                                </strong>
                            </div>
                        </div>
                    </div>
                    <div class="kia-card-footer">
                        ANGGOTA TERVERIFIKASI · NU LESMANA
                    </div>
                </div>
            </button>
            <p class="kia-hint">
                Klik kartu untuk memperbesar · klik lagi untuk membalik
            </p>
        </section>
    </div>
</div>
<div class="kia-overlay" id="kiaOverlay" hidden>
    <div class="kia-dialog" role="dialog" aria-modal="true" aria-label="Detail KIA">
        <div class="kia-modal-top">
            <strong>
                Kartu Identitas Anggota
            </strong>
            <button type="button" class="kia-close" id="kiaClose">
                Tutup ✕
            </button>
        </div>
        <div class="kia-scene" id="kiaScene" role="button" tabindex="0" aria-label="Balik kartu">
            <div class="kia-rotor" id="kiaRotor">
                <div class="kia-face">
                    <div class="kia-card">
                        <small>
                            PENGURUS RANTING · KARTU IDENTITAS ANGGOTA
                        </small>
                        <h3>
                            NU LESMANA
                        </h3>
                        <div class="kia-content">
                            <div class="kia-photo">
                                @if(!empty($photoUrl))
                                <img src="{{ $photoUrl }}" alt="Foto anggota">
                                @else
{{ strtoupper(mb_substr($user->name, 0, 1)) }}
                            @endif

                            </div>
                            <div class="kia-details">
                                <div>
                                    <span>
                                        NAMA ANGGOTA
                                    </span>
                                    <strong>
                                        {{ $member->name ?: $user->name }}
                                    </strong>
                                </div>
                                <div>
                                    <span>
                                        BANOM
                                    </span>
                                    <strong>
                                        {{ $member->banom ?: 'Anggota' }}
                                    </strong>
                                </div>
                                <div>
                                    <span>
                                        NOMOR INDUK ANGGOTA
                                    </span>
                                    <strong>
                                        {{ $nia }}
                                    </strong>
                                </div>
                            </div>
                        </div>
                        <div class="kia-card-footer">
                            ANGGOTA TERVERIFIKASI · NU LESMANA
                        </div>
                    </div>
                </div>
                <div class="kia-face back">
                    <div class="kia-card kia-back">
                        <small>
                            PENGURUS RANTING
                        </small>
                        <h3>
                            NU LESMANA
                        </h3>
                        <p>
                            Kartu identitas digital anggota terverifikasi. Simpan dan gunakan secara bertanggung jawab.
                        </p>
                        <strong>
                            {{ $nia }}
                        </strong>
                    </div>
                </div>
            </div>
        </div>
        <button type="button" class="kia-flip" id="kiaFlip">
            ↻ Balik Kartu
        </button>
    </div>
</div>
<script>
    (function () {
        const overlay = document.getElementById('kiaOverlay');
        const rotor = document.getElementById('kiaRotor');

        if (!overlay || !rotor) return;

        const closeButton = document.getElementById('kiaClose');
        const flipButton = document.getElementById('kiaFlip');
        const scene = document.getElementById('kiaScene');

        function openCard() {
            overlay.hidden = false;
            rotor.classList.remove('flipped');
            document.body.style.overflow = 'hidden';
            closeButton.focus();
        }

        function closeCard() {
            overlay.hidden = true;
            document.body.style.overflow = '';
        }

        function flipCard() {
            rotor.classList.toggle('flipped');
        }

        document.querySelectorAll('[data-open-kia]').forEach(function (button) {
            button.addEventListener('click', openCard);
        });

        closeButton.addEventListener('click', closeCard);
        flipButton.addEventListener('click', flipCard);
        scene.addEventListener('click', flipCard);

        scene.addEventListener('keydown', function (event) {
            if (event.key === 'Enter' || event.key === ' ') {
                event.preventDefault();
                flipCard();
            }
        });

        overlay.addEventListener('click', function (event) {
            if (event.target === overlay) closeCard();
        });

        document.addEventListener('keydown', function (event) {
            if (event.key === 'Escape' && !overlay.hidden) closeCard();
        });
    })();
</script>
@endsection

