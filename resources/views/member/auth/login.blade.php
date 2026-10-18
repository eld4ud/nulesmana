@extends('layouts.member')

@section('title', 'Masuk Anggota')

@php
    // Nama input dijaga sesuai form login sebelumnya:
    // login_type, login, password, remember.
    $loginFields = [
        'email' => [
            'label' => 'Alamat Email',
            'placeholder' => 'nama@email.com',
            'hint' => 'Contoh: warga@email.com',
            'inputmode' => 'email',
            'autocomplete' => 'email',
        ],
        'phone' => [
            'label' => 'Nomor HP / WhatsApp',
            'placeholder' => '081234567890',
            'hint' => 'Masukkan nomor yang terhubung dengan akun.',
            'inputmode' => 'tel',
            'autocomplete' => 'tel',
        ],
        'nia' => [
            'label' => 'Nomor Induk Anggota',
            'placeholder' => 'Masukkan NIA Anda',
            'hint' => 'NIA diberikan setelah keanggotaan disetujui.',
            'inputmode' => 'text',
            'autocomplete' => 'off',
        ],
        'username' => [
            'label' => 'Username',
            'placeholder' => 'username Anda',
            'hint' => 'Gunakan username yang dibuat saat mendaftar.',
            'inputmode' => 'text',
            'autocomplete' => 'username',
        ],
    ];

    $selectedLoginType = old('login_type', 'email');

    if (!array_key_exists($selectedLoginType, $loginFields)) {
        $selectedLoginType = 'email';
    }
@endphp

@section('content')
<style>
    .nl-auth {
        --forest: #183c2f;
        --forest-soft: #2b5b46;
        --ivory: #f5f4f0;
        --ink: #192620;
        --muted: #69786f;
        --line: #dfe5dd;
        display: grid;
        grid-template-columns: minmax(0, .9fr) minmax(0, 1.1fr);
        max-width: 1120px;
        margin: 92px auto 45px;
        border: 1px solid var(--line);
        border-radius: 22px;
        overflow: hidden;
        background: #fff;
        color: var(--ink);
        font-family: 'DM Sans', Arial, sans-serif;
        box-shadow: 0 18px 65px rgba(20, 43, 28, .06);
    }
    .nl-auth * { box-sizing: border-box; }
    .nl-auth a { color: inherit; text-decoration: none; }
    .nl-auth button { cursor: pointer; font: inherit; }
    .nl-auth button:focus-visible,
    .nl-auth a:focus-visible,
    .nl-auth input:focus-visible {
        outline: 3px solid #9bbfa5;
        outline-offset: 3px;
    }

    .nl-side {
        min-height: 640px;
        padding: clamp(30px, 4vw, 52px);
        background: var(--forest);
        color: #fff;
        display: flex;
        flex-direction: column;
        justify-content: space-between;
        gap: 48px;
    }
    .nl-eyebrow {
        margin: 0;
        font-size: 10px;
        font-weight: 800;
        letter-spacing: .17em;
        text-transform: uppercase;
        color: #c0d8c7;
    }
    .nl-side h1 {
        margin: 22px 0 14px;
        font-weight: 800;
        font-size: clamp(40px, 4.3vw, 66px);
        line-height: 1.03;
        letter-spacing: -.06em;
        max-width: 380px;
    }
    .nl-side-intro {
        max-width: 340px;
        color: #d4e4d8;
        font-size: 13px;
        line-height: 1.8;
        margin: 0;
    }
    .nl-preview {
        max-width: 380px;
        border: 1px solid rgba(255,255,255,.2);
        border-radius: 14px;
        padding: 22px;
        background: #214b39;
    }
    .nl-preview-head {
        display: flex;
        align-items: flex-start;
        justify-content: space-between;
        gap: 15px;
        padding-bottom: 27px;
    }
    .nl-preview-head p { margin: 0; }
    .nl-preview-overline { font-size: 9px; letter-spacing: .13em; opacity: .75; font-weight: 800; }
    .nl-preview-title { margin-top: 6px!important; font-size: 19px; font-weight: 800; letter-spacing: -.04em; }
    .nl-preview-mark {
        display: grid;
        place-items: center;
        flex: 0 0 34px;
        width: 34px;
        height: 34px;
        border: 1px solid rgba(255,255,255,.45);
        border-radius: 9px;
        font-size: 10px;
        font-weight: 800;
    }
    .nl-preview-body {
        display: grid;
        grid-template-columns: 42px minmax(0,1fr);
        gap: 13px;
        align-items: center;
    }
    .nl-preview-avatar {
        display: grid;
        place-items: center;
        width: 42px;
        height: 50px;
        border-radius: 8px;
        background: rgba(255,255,255,.12);
        font-weight: 800;
        font-size: 18px;
    }
    .nl-preview-name { font-size: 12px; font-weight: 800; margin: 0 0 4px; }
    .nl-preview-data { font-size: 10px; opacity: .75; margin: 0; }
    .nl-preview-footer {
        border-top: 1px solid rgba(255,255,255,.18);
        margin: 23px 0 0;
        padding-top: 12px;
        font-size: 9px;
        opacity: .8;
        letter-spacing: .03em;
    }

    .nl-form-pane {
        padding: clamp(28px, 4.2vw, 58px);
        background: white;
        display: flex;
        align-items: center;
    }
    .nl-form-inner { width: 100%; max-width: 470px; margin: 0 auto; }
    .nl-form-eyebrow {
        color: var(--forest-soft);
        font-size: 10px;
        letter-spacing: .15em;
        text-transform: uppercase;
        font-weight: 800;
        margin: 0;
    }
    .nl-form-title {
        font-size: clamp(30px, 3.4vw, 45px);
        line-height: 1.1;
        letter-spacing: -.055em;
        margin: 12px 0 9px;
        font-weight: 800;
    }
    .nl-form-desc { font-size: 13px; line-height: 1.75; color: var(--muted); margin: 0 0 28px; }
    .nl-label {
        display: block;
        font-size: 10px;
        font-weight: 800;
        text-transform: uppercase;
        letter-spacing: .08em;
        color: #3b5544;
        margin-bottom: 9px;
    }
    .nl-form-row { margin: 0 0 23px; }
    .nl-tabs { display: grid; grid-template-columns: repeat(4,1fr); gap: 6px; }
    .nl-tab {
        min-width: 0;
        padding: 11px 4px;
        border: 1px solid var(--line);
        border-radius: 9px;
        background: var(--ivory);
        color: #536458;
        font-size: 11px!important;
        font-weight: 800!important;
    }
    .nl-tab[aria-pressed='true'] {
        background: var(--forest);
        border-color: var(--forest);
        color: white;
    }
    .nl-field {
        display: block;
        width: 100%;
        min-height: 50px;
        padding: 13px 15px;
        color: var(--ink);
        background: #fbfcfa;
        border: 1px solid #dce3db;
        border-radius: 10px;
        font-size: 14px;
        font-family: inherit;
        outline: none;
    }
    .nl-field:focus {
        background: #fff;
        border-color: var(--forest);
        box-shadow: 0 0 0 3px rgba(24, 60, 47, .09);
    }
    .nl-hint { font-size: 11px; line-height: 1.6; margin: 8px 0 0; color: #7b887d; }
    .nl-password-wrap { position: relative; }
    .nl-password-wrap .nl-field { padding-right: 105px; }
    .nl-show-password {
        position: absolute;
        top: 50%;
        right: 12px;
        transform: translateY(-50%);
        padding: 6px;
        border: 0;
        background: transparent;
        color: var(--forest);
        font-size: 11px!important;
        font-weight: 800!important;
    }
    .nl-utility-row {
        display: flex;
        align-items: center;
        justify-content: space-between;
        flex-wrap: wrap;
        gap: 13px;
        margin: 0 0 22px;
    }
    .nl-checkbox {
        display: flex;
        align-items: center;
        gap: 9px;
        color: #546356;
        font-size: 12px;
        font-weight: 600;
        cursor: pointer;
    }
    .nl-checkbox input { accent-color: var(--forest); }
    .nl-text-link { color: var(--forest)!important; font-size: 12px; font-weight: 800; }
    .nl-submit {
        display: block;
        width: 100%;
        padding: 16px;
        border: 1px solid var(--forest);
        border-radius: 10px;
        background: var(--forest);
        color: #fff;
        font-size: 13px!important;
        font-weight: 800!important;
    }
    .nl-submit:hover { background: var(--forest-soft); }
    .nl-errors {
        border: 1px solid #edc3c3;
        border-radius: 10px;
        padding: 12px 15px;
        margin-bottom: 18px;
        background: #fff3f2;
        color: #952e2e;
        font-size: 12px;
        line-height: 1.6;
    }
    .nl-status {
        border: 1px solid #bdd5c2;
        border-radius: 10px;
        padding: 12px 15px;
        margin-bottom: 18px;
        background: #eaf4ec;
        color: var(--forest);
        font-size: 12px;
    }
    .nl-bottom {
        margin: 23px 0 0;
        padding-top: 18px;
        display: flex;
        justify-content: space-between;
        flex-wrap: wrap;
        gap: 10px;
        border-top: 1px solid var(--line);
        color: #627267;
        font-size: 11px;
        line-height: 1.7;
    }
    .nl-bottom p { margin: 0; }
    .nl-note {
        margin: 21px 0 0;
        color: #718275;
        font-size: 10px;
        line-height: 1.7;
    }
    .nl-separator {
        display: flex;
        align-items: center;
        gap: 12px;
        margin: 22px 0;
        color: #849085;
        font-size: 11px;
    }
    .nl-separator:before, .nl-separator:after {
        content: '';
        height: 1px;
        flex: 1;
        background: var(--line);
    }
    .nl-google {
        display: block;
        text-align: center;
        padding: 13px 16px;
        border: 1px solid var(--line);
        border-radius: 10px;
        color: var(--forest);
        font-weight: 800;
        font-size: 12px;
    }
    @media (max-width: 900px) {
        .nl-auth { grid-template-columns: 1fr; }
        .nl-side { min-height: 0; padding: 30px; gap: 25px; }
        .nl-side h1 { font-size: clamp(34px, 9vw, 55px); max-width: none; }
        .nl-preview { display: none; }
        .nl-form-pane { padding: 31px 28px; }
    }
    @media (max-width: 520px) {
        .nl-auth { margin: 95px 0 30px; border-radius: 15px; }
        .nl-side, .nl-form-pane { padding: 23px; }
        .nl-bottom { flex-direction: column; }
    }
</style>

<div class="nl-auth" id="nl-login-app">
    <section class="nl-side" aria-label="Informasi portal anggota">
        <div>
            <p class="nl-eyebrow">Portal Anggota / NU Lesmana</p>
            <h1>MASUK KE AKUN<br>ANGGOTA.</h1>
            <p class="nl-side-intro">
                Akses informasi keanggotaan, perbarui data pribadi,
                dan lihat kartu digital setelah disetujui pengurus.
            </p>
        </div>

        <div class="nl-preview" aria-label="Contoh tampilan kartu anggota">
            <div class="nl-preview-head">
                <div>
                    <p class="nl-preview-overline">PENGURUS RANTING</p>
                    <p class="nl-preview-title">NU LESMANA</p>
                </div>
                <span class="nl-preview-mark">NU</span>
            </div>
            <div class="nl-preview-body">
                <div class="nl-preview-avatar" aria-hidden="true">N</div>
                <div>
                    <p class="nl-preview-name">Nama Anggota</p>
                    <p class="nl-preview-data">Badan Otonom</p>
                </div>
            </div>
            <p class="nl-preview-footer">PRATINJAU KARTU · KIA AKTIF SETELAH VERIFIKASI</p>
        </div>
    </section>

    <section class="nl-form-pane" aria-labelledby="nl-login-title">
        <div class="nl-form-inner">
            <p class="nl-form-eyebrow">Selamat datang kembali</p>
            <h2 class="nl-form-title" id="nl-login-title">Login anggota</h2>
            <p class="nl-form-desc">Pilih salah satu metode masuk dengan akun yang sudah didaftarkan.</p>

            @if (session('status'))
                <div class="nl-status" role="status">{{ session('status') }}</div>
            @endif

            @if ($errors->any())
                <div class="nl-errors" role="alert">
                    @foreach ($errors->all() as $error)
                        <div>{{ $error }}</div>
                    @endforeach
                </div>
            @endif

            <form method="POST" action="{{ route('member.login.store') }}">
                @csrf
                <input
                    type="hidden"
                    name="login_type"
                    id="nl-login-type"
                    value="{{ $selectedLoginType }}"
                >

                <div class="nl-form-row">
                    <span class="nl-label">Masuk dengan</span>
                    <div class="nl-tabs" role="group" aria-label="Metode login">
                        <button class="nl-tab" type="button" data-login-type="email" aria-pressed="{{ $selectedLoginType === 'email' ? 'true' : 'false' }}">Email</button>
                        <button class="nl-tab" type="button" data-login-type="phone" aria-pressed="{{ $selectedLoginType === 'phone' ? 'true' : 'false' }}">No. HP</button>
                        <button class="nl-tab" type="button" data-login-type="nia" aria-pressed="{{ $selectedLoginType === 'nia' ? 'true' : 'false' }}">NIA</button>
                        <button class="nl-tab" type="button" data-login-type="username" aria-pressed="{{ $selectedLoginType === 'username' ? 'true' : 'false' }}">Username</button>
                    </div>
                </div>

                <div class="nl-form-row">
                    <label class="nl-label" for="nl-login-identity" id="nl-login-label">{{ $loginFields[$selectedLoginType]['label'] }}</label>
                    <input
                        class="nl-field"
                        id="nl-login-identity"
                        name="login"
                        type="text"
                        placeholder="{{ $loginFields[$selectedLoginType]['placeholder'] }}"
                        inputmode="{{ $loginFields[$selectedLoginType]['inputmode'] }}"
                        autocomplete="{{ $loginFields[$selectedLoginType]['autocomplete'] }}"
                        value="{{ old('login') }}"
                        required
                        autofocus
                    >
                    <p class="nl-hint" id="nl-login-hint">{{ $loginFields[$selectedLoginType]['hint'] }}</p>
                </div>

                <div class="nl-form-row">
                    <label class="nl-label" for="nl-login-password">Password</label>
                    <div class="nl-password-wrap">
                        <input
                            class="nl-field"
                            id="nl-login-password"
                            name="password"
                            type="password"
                            placeholder="Masukkan password akun"
                            autocomplete="current-password"
                            required
                        >
                        <button type="button" class="nl-show-password" id="nl-toggle-password">Tampilkan</button>
                    </div>
                </div>

                <div class="nl-utility-row">
                    <label class="nl-checkbox">
                        <input type="checkbox" name="remember" value="1" {{ old('remember') ? 'checked' : '' }}>
                        Ingat saya
                    </label>
                    @if (Route::has('password.request'))
                        <a href="{{ route('password.request') }}" class="nl-text-link">Lupa password?</a>
                    @endif
                </div>

                <button type="submit" class="nl-submit">Masuk ke Portal →</button>
            </form>

            @if (Route::has('member.google.redirect'))
                <div class="nl-separator">atau</div>
                <a class="nl-google" href="{{ route('member.google.redirect') }}">Lanjutkan dengan Google</a>
            @endif

            <div class="nl-bottom">
                <p>Belum punya akun? <a href="{{ route('member.signup') }}" class="nl-text-link">Daftar anggota</a></p>
                @if (Route::has('login'))
                    <p>Pengurus? <a href="{{ route('login') }}" class="nl-text-link">Login admin</a></p>
                @endif
            </div>

            <p class="nl-note">
                NIA dan kartu anggota digital baru aktif setelah pendaftaran
                disetujui oleh pengurus NU Lesmana.
            </p>
        </div>
    </section>
</div>

<script>
    (() => {
        const root = document.getElementById('nl-login-app');

        if (!root) return;

        const definitions = @json($loginFields);
        const typeInput = root.querySelector('#nl-login-type');
        const identity = root.querySelector('#nl-login-identity');
        const label = root.querySelector('#nl-login-label');
        const hint = root.querySelector('#nl-login-hint');
        const password = root.querySelector('#nl-login-password');
        const togglePassword = root.querySelector('#nl-toggle-password');
        const tabs = root.querySelectorAll('[data-login-type]');

        const changeType = (type) => {
            const config = definitions[type];

            if (!config) return;

            typeInput.value = type;
            label.textContent = config.label;
            hint.textContent = config.hint;
            identity.placeholder = config.placeholder;
            identity.setAttribute('inputmode', config.inputmode);
            identity.setAttribute('autocomplete', config.autocomplete);
            identity.value = '';

            tabs.forEach((tab) => {
                tab.setAttribute('aria-pressed', String(tab.dataset.loginType === type));
            });
        };

        tabs.forEach((tab) => {
            tab.addEventListener('click', () => changeType(tab.dataset.loginType));
        });

        togglePassword.addEventListener('click', () => {
            const isHidden = password.type === 'password';
            password.type = isHidden ? 'text' : 'password';
            togglePassword.textContent = isHidden ? 'Sembunyikan' : 'Tampilkan';
        });
    })();
</script>
@endsection
