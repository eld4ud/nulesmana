<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="color-scheme" content="light">
    <title>{{ $user->role === 'admin' ? 'Pengaturan Admin' : 'Pengaturan Profil' }} | NU Lesmana</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    <style>
        :root {
            --forest: #183c2f;
            --forest-hover: #285540;
            --ivory: #f5f4f0;
            --ink: #18241e;
            --muted: #63746a;
            --line: #dce4dc;
            --white: #fff;
        }

        * {
            box-sizing: border-box;
        }

        html {
            font-family: 'DM Sans', Arial, sans-serif;
            color: var(--ink);
            background: var(--ivory);
        }

        body {
            margin: 0;
            min-height: 100vh;
        }

        a {
            color: inherit;
            text-decoration: none;
        }

        button,
        input {
            font: inherit;
        }

        a:focus-visible,
        button:focus-visible,
        input:focus-visible {
            outline: 3px solid #87aa91;
            outline-offset: 3px;
        }

        .site-header {
            border-bottom: 1px solid var(--line);
            background: var(--white);
        }

        .topbar {
            max-width: 1120px;
            margin: 0 auto;
            padding: 18px 24px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 20px;
        }

        .brand {
            display: inline-flex;
            align-items: center;
            gap: 12px;
            font-size: 14px;
            font-weight: 800;
        }

        .brand-symbol {
            display: grid;
            place-items: center;
            width: 42px;
            height: 42px;
            border-radius: 12px;
            background: var(--forest);
            color: #fff;
            font-size: 12px;
            letter-spacing: .06em;
        }

        .brand-caption {
            display: block;
            margin-top: 3px;
            font-size: 10px;
            letter-spacing: .11em;
            color: var(--muted);
        }

        .top-actions {
            display: flex;
            flex-wrap: wrap;
            gap: 8px;
        }

        .top-actions a {
            padding: 11px 14px;
            border-radius: 10px;
            border: 1px solid var(--line);
            font-size: 12px;
            font-weight: 700;
            background: #fff;
        }

        .top-actions a:hover {
            border-color: var(--forest);
        }

        .shell {
            width: min(100% - 36px, 1040px);
            margin: 0 auto;
            padding: 54px 0 85px;
        }

        .eyebrow {
            font-size: 11px;
            font-weight: 800;
            letter-spacing: .16em;
            text-transform: uppercase;
            color: var(--forest);
        }

        h1 {
            margin: 12px 0 12px;
            font-size: clamp(34px, 5vw, 54px);
            line-height: 1.08;
            letter-spacing: -.05em;
        }

        .intro {
            max-width: 600px;
            margin: 0;
            color: var(--muted);
            font-size: 14px;
            line-height: 1.75;
        }

        .profile-layout {
            display: grid;
            grid-template-columns: 270px minmax(0, 1fr);
            gap: 24px;
            align-items: start;
            margin-top: 38px;
        }

        .panel {
            border: 1px solid var(--line);
            border-radius: 20px;
            background: #fff;
        }

        .sidebar {
            padding: 24px;
        }

        .avatar {
            width: 56px;
            height: 56px;
            border-radius: 16px;
            display: grid;
            place-items: center;
            background: var(--forest);
            color: #fff;
            font-weight: 800;
            font-size: 22px;
        }

        .profile-name {
            margin: 16px 0 4px;
            font-size: 17px;
            overflow-wrap: anywhere;
        }

        .profile-email {
            margin: 0;
            color: var(--muted);
            font-size: 12px;
            overflow-wrap: anywhere;
        }

        .role-pill {
            display: inline-block;
            margin-top: 22px;
            padding: 8px 12px;
            border: 1px solid #cee0d2;
            border-radius: 999px;
            background: #eef4ed;
            font-size: 11px;
            font-weight: 800;
            color: var(--forest);
        }

        .sidebar-note {
            margin: 18px 0 0;
            padding-top: 18px;
            border-top: 1px solid var(--line);
            color: var(--muted);
            font-size: 12px;
            line-height: 1.65;
        }

        .forms {
            display: grid;
            gap: 18px;
        }

        .section {
            padding: 29px;
        }

        .section h2 {
            margin: 0;
            font-size: 20px;
            letter-spacing: -.025em;
        }

        .section-lead {
            margin: 8px 0 24px;
            color: var(--muted);
            font-size: 13px;
            line-height: 1.7;
        }

        .fields {
            display: grid;
            gap: 17px;
        }

        label {
            display: block;
            margin-bottom: 8px;
            font-size: 12px;
            font-weight: 800;
        }

        .input {
            width: 100%;
            min-height: 48px;
            padding: 12px 14px;
            border: 1px solid #d6dfd6;
            border-radius: 11px;
            outline: none;
            background: #fbfcf9;
            color: var(--ink);
            font-size: 13px;
            transition: border-color .15s ease;
        }

        .input:focus {
            border-color: var(--forest);
        }

        .error {
            display: block;
            margin-top: 7px;
            color: #ad2929;
            font-size: 12px;
        }

        .hint {
            margin: 7px 0 0;
            color: var(--muted);
            font-size: 12px;
            line-height: 1.5;
        }

        .form-footer {
            display: flex;
            flex-wrap: wrap;
            align-items: center;
            gap: 14px;
            margin-top: 25px;
        }

        .save {
            border: 0;
            border-radius: 11px;
            padding: 13px 20px;
            background: var(--forest);
            color: #fff;
            font-size: 13px;
            font-weight: 800;
            cursor: pointer;
        }

        .save:hover {
            background: var(--forest-hover);
        }

        .success {
            color: #22643a;
            font-size: 12px;
            font-weight: 700;
        }

        .notice {
            margin: 0 0 20px;
            padding: 12px 14px;
            border: 1px solid #c7dcca;
            border-radius: 11px;
            background: #eff6ee;
            color: #245d38;
            font-size: 12px;
            line-height: 1.6;
        }

        @media (max-width: 720px) {
            .topbar {
                padding: 14px 18px;
            }

            .shell {
                padding-top: 35px;
            }

            .profile-layout {
                grid-template-columns: 1fr;
            }

            .section {
                padding: 23px 18px;
            }
        }
    </style>
</head>
<body>
@php
    $isAdmin = $user->role === 'admin';
    $dashboardUrl = $isAdmin ? route('admin.dashboard') : route('member.dashboard');
    $profileUpdateUrl = $isAdmin ? route('admin.profile.update') : route('profile.update');
    $initial = mb_strtoupper(mb_substr($user->name ?: 'N', 0, 1));
@endphp

<header class="site-header">
    <div class="topbar">
        <a href="{{ route('home') }}" class="brand">
            <span class="brand-symbol">NU</span>
            <span>
                NU LESMANA
                <span class="brand-caption">PORTAL RESMI WARGA</span>
            </span>
        </a>

        <nav class="top-actions" aria-label="Navigasi profil">
            <a href="{{ $dashboardUrl }}">← Dashboard</a>
            <a href="{{ route('home') }}">Website Utama ↗</a>
        </nav>
    </div>
</header>

<main class="shell">
    <p class="eyebrow">NU Lesmana / Pengaturan Akun</p>
    <h1>{{ $isAdmin ? 'Pengaturan Admin' : 'Pengaturan Profil' }}</h1>
    <p class="intro">
        Kelola identitas akun dan keamanan login. Pengaturan ini tidak mengubah
        status keanggotaan, peran akun, atau Nomor Induk Anggota.
    </p>

    <div class="profile-layout">
        <aside class="sidebar panel">
            <div class="avatar" aria-hidden="true">{{ $initial }}</div>
            <h2 class="profile-name">{{ $user->name }}</h2>
            <p class="profile-email">{{ $user->email }}</p>

            <span class="role-pill">
                {{ $isAdmin ? 'Administrator' : 'Anggota NU Lesmana' }}
            </span>

            <p class="sidebar-note">
                @if($isAdmin)
                    Akun pengurus dipakai untuk mengelola layanan dan memverifikasi pendaftaran.
                    Admin tidak perlu memiliki NIA anggota.
                @else
                    Data NIA, banom, dan status ACC dikelola oleh sistem dan pengurus.
                @endif
            </p>
        </aside>

        <div class="forms">
            <section class="section panel" aria-labelledby="identity-title">
                <h2 id="identity-title">Informasi Akun</h2>
                <p class="section-lead">Perbarui nama dan alamat email akun Anda.</p>

                @if(session('status') === 'profile-updated')
                    <p class="notice" role="status">Informasi profil berhasil disimpan.</p>
                @endif

                <form method="POST" action="{{ $profileUpdateUrl }}">
                    @csrf
                    @method('PATCH')

                    <div class="fields">
                        <div>
                            <label for="name">Nama lengkap</label>
                            <input
                                id="name"
                                name="name"
                                type="text"
                                class="input"
                                value="{{ old('name', $user->name) }}"
                                required
                                autocomplete="name"
                            >
                            @error('name')
                                <span class="error">{{ $message }}</span>
                            @enderror
                        </div>

                        <div>
                            <label for="email">Alamat email</label>
                            <input
                                id="email"
                                name="email"
                                type="email"
                                class="input"
                                value="{{ old('email', $user->email) }}"
                                required
                                autocomplete="email"
                            >
                            @error('email')
                                <span class="error">{{ $message }}</span>
                            @enderror
                            <p class="hint">Jika email diganti, verifikasi email mungkin perlu dilakukan kembali.</p>
                        </div>
                    </div>

                    <div class="form-footer">
                        <button type="submit" class="save">Simpan Perubahan</button>
                    </div>
                </form>
            </section>

            @if(\Illuminate\Support\Facades\Route::has('password.update'))
                <section class="section panel" aria-labelledby="security-title">
                    <h2 id="security-title">Keamanan Akun</h2>
                    <p class="section-lead">Ganti password secara berkala untuk menjaga keamanan akun.</p>

                    @if(session('status') === 'password-updated')
                        <p class="notice" role="status">Password berhasil diperbarui.</p>
                    @endif

                    <form method="POST" action="{{ route('password.update') }}">
                        @csrf
                        @method('PUT')

                        <div class="fields">
                            <div>
                                <label for="current_password">Password saat ini</label>
                                <input
                                    id="current_password"
                                    name="current_password"
                                    type="password"
                                    class="input"
                                    autocomplete="current-password"
                                    required
                                >
                                @error('current_password', 'updatePassword')
                                    <span class="error">{{ $message }}</span>
                                @enderror
                            </div>

                            <div>
                                <label for="password">Password baru</label>
                                <input
                                    id="password"
                                    name="password"
                                    type="password"
                                    class="input"
                                    autocomplete="new-password"
                                    required
                                >
                                @error('password', 'updatePassword')
                                    <span class="error">{{ $message }}</span>
                                @enderror
                            </div>

                            <div>
                                <label for="password_confirmation">Konfirmasi password baru</label>
                                <input
                                    id="password_confirmation"
                                    name="password_confirmation"
                                    type="password"
                                    class="input"
                                    autocomplete="new-password"
                                    required
                                >
                                @error('password_confirmation', 'updatePassword')
                                    <span class="error">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-footer">
                            <button type="submit" class="save">Perbarui Password</button>
                        </div>
                    </form>
                </section>
            @endif
        </div>
    </div>
</main>
</body>
</html>
