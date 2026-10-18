<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="color-scheme" content="light">
    <title>Dashboard Pengurus | NU Lesmana</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    <style>
        :root {
            --forest: #183c2f;
            --forest-light: #275743;
            --ivory: #f5f4f0;
            --white: #ffffff;
            --ink: #17231d;
            --muted: #69786d;
            --line: #e3e8e1;
            --pale: #edf2ec;
            --danger: #a43131;
        }

        * { box-sizing: border-box; }
        html { scroll-behavior: smooth; }
        body {
            margin: 0;
            background: var(--ivory);
            color: var(--ink);
            font-family: 'DM Sans', Arial, sans-serif;
            -webkit-font-smoothing: antialiased;
        }
        a { color: inherit; text-decoration: none; }
        button { font: inherit; cursor: pointer; }
        button:focus-visible, a:focus-visible {
            outline: 3px solid #82af91;
            outline-offset: 3px;
        }

        .admin-shell {
            display: grid;
            grid-template-columns: 246px minmax(0, 1fr);
            min-height: 100vh;
        }
        .sidebar {
            padding: 30px 17px 24px;
            background: #fff;
            border-right: 1px solid var(--line);
            display: flex;
            flex-direction: column;
            gap: 36px;
        }
        .brand {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 0 10px;
        }
        .brand-mark {
            display: grid;
            place-items: center;
            width: 44px;
            height: 44px;
            border-radius: 12px;
            background: var(--forest);
            color: #fff;
            font-weight: 800;
            font-size: 13px;
            letter-spacing: -.02em;
        }
        .brand-name { margin: 0; font-size: 14px; font-weight: 800; }
        .brand-sub {
            margin: 3px 0 0;
            color: var(--muted);
            font-size: 10px;
            letter-spacing: .11em;
            text-transform: uppercase;
        }
        .nav-heading {
            margin: 0 12px 12px;
            color: #8b968e;
            font-size: 10px;
            font-weight: 800;
            letter-spacing: .16em;
            text-transform: uppercase;
        }
        .nav-list { display: flex; flex-direction: column; gap: 5px; }
        .nav-link {
            display: flex;
            align-items: center;
            gap: 13px;
            border-radius: 11px;
            padding: 12px 14px;
            font-size: 13px;
            font-weight: 700;
            color: #59675d;
            transition: background .15s, color .15s;
        }
        .nav-link:hover { background: var(--pale); color: var(--forest); }
        .nav-link[aria-current='page'] {
            color: white;
            background: var(--forest);
        }
        .nav-number {
            width: 21px;
            font-size: 11px;
            letter-spacing: .04em;
            opacity: .73;
            font-variant-numeric: tabular-nums;
        }
        .sidebar-bottom {
            margin-top: auto;
            padding: 17px 9px 0;
            border-top: 1px solid var(--line);
        }
        .profile-name {
            font-weight: 800;
            font-size: 13px;
            overflow-wrap: anywhere;
        }
        .profile-role { color: var(--muted); margin: 3px 0 15px; font-size: 12px; }
        .logout {
            border: 0;
            padding: 7px 0;
            background: none;
            color: var(--danger);
            font-size: 12px;
            font-weight: 800;
        }

        .main {
            min-width: 0;
            max-width: 1350px;
            width: 100%;
            margin: 0 auto;
            padding: 36px 46px 70px;
        }
        .page-heading {
            display: flex;
            flex-wrap: wrap;
            align-items: flex-start;
            justify-content: space-between;
            gap: 20px;
            margin-bottom: 32px;
        }
        .eyebrow {
            color: var(--forest-light);
            font-weight: 800;
            font-size: 10px;
            letter-spacing: .13em;
            text-transform: uppercase;
        }
        h1 {
            margin: 10px 0 8px;
            font-size: clamp(30px, 3.1vw, 44px);
            line-height: 1.1;
            letter-spacing: -.055em;
            font-weight: 800;
        }
        .intro { margin: 0; color: var(--muted); font-size: 13px; line-height: 1.6; }
        .button {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 9px;
            border: 1px solid var(--line);
            border-radius: 10px;
            padding: 11px 15px;
            background: #fff;
            color: var(--forest);
            font-size: 12px;
            font-weight: 800;
            white-space: nowrap;
        }
        .button-dark {
            background: var(--forest);
            border-color: var(--forest);
            color: #fff;
        }
        .button:hover { border-color: #9bb1a0; }
        .button-dark:hover { background: var(--forest-light); }
        .alert {
            padding: 15px 18px;
            background: #e9f2e9;
            border: 1px solid #bbd3c0;
            border-radius: 11px;
            font-size: 13px;
            margin-bottom: 21px;
        }
        .alert-error { background: #fff0f0; border-color: #e9bebe; color: #872b2b; }

        .stat-grid {
            display: grid;
            grid-template-columns: repeat(3, minmax(0, 1fr));
            gap: 15px;
            margin-bottom: 24px;
        }
        .stat {
            min-height: 168px;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            padding: 23px;
            background: #fff;
            border: 1px solid var(--line);
            border-radius: 16px;
        }
        .stat-highlight { background: var(--forest); border-color: var(--forest); color: #fff; }
        .stat-top { display: flex; align-items: center; justify-content: space-between; gap: 8px; }
        .stat-label { font-size: 12px; font-weight: 750; }
        .stat-tag { font-size: 10px; opacity: .7; }
        .stat-number {
            font-weight: 800;
            font-size: clamp(32px, 3.5vw, 46px);
            letter-spacing: -.045em;
            font-variant-numeric: tabular-nums;
        }
        .stat-foot { margin: 3px 0 0; color: var(--muted); font-size: 11px; }
        .stat-highlight .stat-foot { color: #c5dfcd; }

        .content-grid {
            display: grid;
            grid-template-columns: minmax(0, 1.7fr) minmax(265px, .8fr);
            gap: 17px;
            align-items: start;
        }
        .panel {
            min-width: 0;
            overflow: hidden;
            background: #fff;
            border: 1px solid var(--line);
            border-radius: 16px;
        }
        .panel-head {
            display: flex;
            flex-wrap: wrap;
            align-items: flex-start;
            justify-content: space-between;
            gap: 12px;
            padding: 23px 24px 19px;
            border-bottom: 1px solid var(--line);
        }
        .panel-title { margin: 0; font-size: 16px; font-weight: 800; letter-spacing: -.025em; }
        .panel-desc { margin: 5px 0 0; color: var(--muted); font-size: 12px; line-height: 1.6; }
        .small-link { font-size: 12px; font-weight: 800; color: var(--forest); }
        .members { padding: 3px 24px 12px; }
        .member-row {
            display: flex;
            align-items: center;
            gap: 14px;
            padding: 18px 0;
            border-bottom: 1px solid #edf0eb;
        }
        .member-row:last-child { border-bottom: 0; }
        .member-avatar {
            display: grid;
            place-items: center;
            flex: 0 0 39px;
            height: 39px;
            border-radius: 12px;
            background: var(--pale);
            color: var(--forest);
            font-size: 15px;
            font-weight: 800;
        }
        .member-text { min-width: 0; flex: 1; }
        .member-name { margin: 0; font-size: 13px; font-weight: 800; overflow-wrap: anywhere; }
        .member-desc { margin: 5px 0 0; color: var(--muted); font-size: 11px; overflow-wrap: anywhere; }
        .row-actions { display: flex; align-items: center; gap: 7px; flex-wrap: wrap; }
        .row-actions form { margin: 0; }
        .action {
            padding: 9px 11px;
            border-radius: 9px;
            border: 1px solid var(--line);
            background: #fff;
            color: var(--ink);
            font-size: 11px;
            font-weight: 800;
        }
        .action-approve { color: #fff; background: var(--forest); border-color: var(--forest); }
        .action-reject { color: #942e2e; }
        .action:hover { filter: brightness(.96); }
        .empty { padding: 35px 12px; text-align: center; color: var(--muted); font-size: 13px; line-height: 1.7; }
        .empty strong { display: block; margin-bottom: 6px; font-size: 17px; color: var(--forest); }
        .quick-links { padding: 11px 22px 20px; }
        .quick-link {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 10px;
            padding: 15px 2px;
            border-bottom: 1px solid var(--line);
            font-size: 13px;
            font-weight: 700;
        }
        .quick-link:last-child { border-bottom: 0; }
        .quick-link:hover { color: var(--forest-light); }
        .tip {
            padding: 15px 17px;
            margin: 0 22px 22px;
            background: var(--pale);
            border-radius: 11px;
            color: #486452;
            font-size: 11px;
            line-height: 1.7;
        }

        .mobile-logout { display: none; margin-top: 22px; }
        @media (max-width: 1100px) {
            .main { padding: 30px 25px 50px; }
            .content-grid { grid-template-columns: minmax(0, 1fr); }
        }
        @media (max-width: 760px) {
            .admin-shell { grid-template-columns: minmax(0, 1fr); }
            .sidebar { gap: 14px; padding: 16px; border-right: 0; border-bottom: 1px solid var(--line); }
            .brand { padding: 0; }
            .nav-heading, .sidebar-bottom { display: none; }
            .nav-list { flex-direction: row; gap: 4px; overflow-x: auto; }
            .nav-link { flex-shrink: 0; padding: 10px 12px; white-space: nowrap; }
            .main { padding: 25px 16px 45px; }
            .stat-grid { grid-template-columns: 1fr; gap: 10px; }
            .stat { min-height: 125px; }
            .member-row { align-items: flex-start; flex-wrap: wrap; }
            .member-text { flex-basis: calc(100% - 55px); }
            .row-actions { padding-left: 53px; }
            .mobile-logout { display: block; }
        }
        @media (prefers-reduced-motion: reduce) {
            html { scroll-behavior: auto; }
            .nav-link { transition: none; }
        }
    </style>
</head>
<body>
    <div class="admin-shell">
        <aside class="sidebar" aria-label="Sidebar admin">
            <a href="{{ route('admin.dashboard') }}" class="brand" aria-label="Dashboard NU Lesmana">
                <span class="brand-mark">NU</span>
                <span>
                    <span class="brand-name">NU LESMANA</span>
                    <span class="brand-sub">Panel Pengurus</span>
                </span>
            </a>

            <div>
                <p class="nav-heading">Navigasi</p>
                <nav class="nav-list" aria-label="Menu admin">
                    <a class="nav-link" href="{{ route('admin.dashboard') }}" aria-current="page">
                        <span class="nav-number">01</span> Dashboard
                    </a>
                    <a class="nav-link" href="{{ route('admin.members.index') }}">
                        <span class="nav-number">02</span> Kelola Anggota
                    </a>
                    <a class="nav-link" href="{{ route('admin.news.index') }}">
                        <span class="nav-number">03</span> Kelola Berita
                    </a>
                    <a class="nav-link" href="{{ route('admin.infaq.index') }}">
                        <span class="nav-number">04</span> Infaq / Kas
                    </a>
                    <a class="nav-link" href="{{ route('admin.struktur.index') }}">
                        <span class="nav-number">05</span> Kelola Struktur
                    </a>
                </nav>
            </div>

            <div class="sidebar-bottom">
                <div class="profile-name">{{ auth()->user()?->name ?? 'Pengurus' }}</div>
                <p class="profile-role">Administrator NU Lesmana</p>
                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button class="logout" type="submit">Keluar dari akun →</button>
                </form>
            </div>
        </aside>

        <main class="main" id="konten">
            <header class="page-heading">
                <div>
                    <p class="eyebrow">Panel Pengurus / Ringkasan</p>
                    <h1>Dashboard Admin</h1>
                    <p class="intro">Pantau data anggota, antrean verifikasi, dan berita dalam satu halaman.</p>
                </div>
                <a class="button" href="{{ route('home') }}" target="_blank" rel="noopener noreferrer">
                    Buka website <span aria-hidden="true">↗</span>
                </a>
            </header>

            @if (session('success'))
                <div class="alert" role="status">{{ session('success') }}</div>
            @endif

            @if ($errors->any())
                <div class="alert alert-error" role="alert">
                    {{ $errors->first() }}
                </div>
            @endif

            <section class="stat-grid" aria-label="Statistik portal">
                <article class="stat stat-highlight">
                    <div class="stat-top">
                        <span class="stat-label">Anggota terverifikasi</span>
                        <span class="stat-tag">AKTIF</span>
                    </div>
                    <div>
                        <div class="stat-number">{{ number_format((int) ($totalApprovedMembers ?? 0), 0, ',', '.') }}</div>
                        <p class="stat-foot">Sudah disetujui pengurus</p>
                    </div>
                </article>

                <article class="stat">
                    <div class="stat-top">
                        <span class="stat-label">Antrean terbaru</span>
                        <span class="stat-tag">PERLU DICEK</span>
                    </div>
                    <div>
                        <div class="stat-number">{{ count($pendingMembers ?? []) }}</div>
                        <p class="stat-foot">Maks. 5 pendaftaran terbaru ditampilkan</p>
                    </div>
                </article>

                <article class="stat">
                    <div class="stat-top">
                        <span class="stat-label">Berita terpublikasi</span>
                        <span class="stat-tag">PUBLIK</span>
                    </div>
                    <div>
                        <div class="stat-number">{{ number_format((int) ($totalNews ?? 0), 0, ',', '.') }}</div>
                        <p class="stat-foot">Berita dan agenda portal</p>
                    </div>
                </article>
            </section>

            <div class="content-grid">
                <section class="panel" aria-labelledby="pending-heading">
                    <div class="panel-head">
                        <div>
                            <h2 class="panel-title" id="pending-heading">Pendaftaran Terbaru</h2>
                            <p class="panel-desc">Tinjau identitas sebelum menerbitkan NIA dan KIA.</p>
                        </div>
                        <a href="{{ route('admin.members.index') }}" class="small-link">Lihat semua ↗</a>
                    </div>

                    <div class="members">
                        @forelse ($pendingMembers ?? [] as $member)
                            <article class="member-row">
                                <div class="member-avatar" aria-hidden="true">
                                    {{ mb_strtoupper(mb_substr($member->name ?: 'A', 0, 1)) }}
                                </div>
                                <div class="member-text">
                                    <h3 class="member-name">{{ $member->name }}</h3>
                                    <p class="member-desc">
                                        {{ $member->banom ?: 'Belum memilih banom' }}
                                        @if ($member->phone)
                                            · {{ $member->phone }}
                                        @endif
                                    </p>
                                </div>
                                <div class="row-actions">
                                    <form method="POST" action="{{ route('admin.members.approve', $member->id) }}">
                                        @csrf
                                        @method('PATCH')
                                        <button type="submit" class="action action-approve" aria-label="Setujui {{ $member->name }}">
                                            ACC
                                        </button>
                                    </form>
                                    <form
                                        method="POST"
                                        action="{{ route('admin.members.reject', $member->id) }}"
                                        onsubmit="return confirm('Tolak pendaftaran anggota ini?')"
                                    >
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="action action-reject" aria-label="Tolak {{ $member->name }}">
                                            Tolak
                                        </button>
                                    </form>
                                </div>
                            </article>
                        @empty
                            <div class="empty">
                                <strong>Antrean sudah kosong.</strong>
                                Belum ada calon anggota yang perlu diverifikasi.
                            </div>
                        @endforelse
                    </div>
                </section>

                <aside class="panel" aria-labelledby="quick-heading">
                    <div class="panel-head">
                        <div>
                            <h2 class="panel-title" id="quick-heading">Akses Cepat</h2>
                            <p class="panel-desc">Langsung ke modul pengelolaan.</p>
                        </div>
                    </div>
                    <div class="quick-links">
                        <a class="quick-link" href="{{ route('admin.members.index') }}">
                            Kelola Anggota <span aria-hidden="true">↗</span>
                        </a>
                        <a class="quick-link" href="{{ route('admin.news.index') }}">
                            Kelola Berita <span aria-hidden="true">↗</span>
                        </a>
                        <a class="quick-link" href="{{ route('admin.struktur.index') }}">
                            <span>Kelola Struktur Organisasi</span>
                            <span aria-hidden="true">↗</span>
                        </a>
                        <a class="quick-link" href="{{ route('admin.infaq.index') }}">
                            Infaq / Kas <span aria-hidden="true">↗</span>
                        </a>
                        <a class="quick-link" href="{{ route('home') }}" target="_blank" rel="noopener noreferrer">
                            Website Publik <span aria-hidden="true">↗</span>
                        </a>
                    </div>
                    <p class="tip">
                        ACC hanya untuk anggota yang datanya telah diperiksa.
                        NIA dan status resmi tidak boleh diubah melalui profil warga.
                    </p>
                </aside>
            </div>

            <div class="mobile-logout">
                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button class="button" type="submit">Keluar dari akun admin</button>
                </form>
            </div>
        </main>
    </div>
</body>
</html>
