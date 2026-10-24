
<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="color-scheme" content="light">

    <title>@yield('title', 'Panel Admin') | NU Lesmana</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <!-- GOOGLE FONTS -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>

    <link
        href="https://fonts.googleapis.com/css2?family=Amiri:wght@400;700&family=Bebas+Neue&family=DM+Sans:wght@400;500;600;700;800&display=swap"
        rel="stylesheet"
    >

    <!-- PHOSPHOR ICONS -->
    <script src="https://unpkg.com/@phosphor-icons/web"></script>

    <style>
        :root {
            --nu-green: #183C2F;
            --nu-green-hover: #265642;
            --nu-ivory: #F5F4F0;
            --nu-ink: #18291F;
            --nu-muted: #738276;
            --nu-line: #E2E8DF;
            --nu-white: #FFFFFF;
        }

        * {
            box-sizing: border-box;
        }

        html {
            scroll-behavior: smooth;
        }

        body {
            margin: 0;
            min-height: 100vh;
            background: var(--nu-ivory);
            color: var(--nu-ink);
            font-family: 'DM Sans', sans-serif;
            -webkit-font-smoothing: antialiased;
        }

        .font-arabic {
            font-family: 'Amiri', serif;
            font-weight: 400;
        }

        .font-display {
            font-family: 'Bebas Neue', sans-serif;
            font-weight: 400;
            letter-spacing: .02em;
        }

        a {
            text-decoration: none;
        }

        button {
            font-family: inherit;
        }

        button:focus-visible,
        a:focus-visible,
        input:focus-visible,
        select:focus-visible {
            outline: 2px solid #6B9F7E;
            outline-offset: 3px;
        }

        /* ======================================
           LAYOUT UTAMA ADMIN
        ====================================== */

        .admin-shell {
            display: grid;
            grid-template-columns: 250px minmax(0, 1fr);
            min-height: 100vh;
            max-width: 1600px;
            margin: 0 auto;
            background: #F8F9F6;
        }

        /* ======================================
           SIDEBAR
        ====================================== */

        .admin-sidebar {
            background: #FFFFFF;
            border-right: 1px solid var(--nu-line);
            padding: 28px 17px;
            display: flex;
            flex-direction: column;
            min-width: 0;
        }

        .admin-brand {
            display: flex;
            align-items: center;
            gap: 12px;
            margin-bottom: 45px;
            padding: 0 10px;
            color: var(--nu-ink);
        }

        .admin-brand-logo {
            width: 43px;
            height: 43px;
            flex-shrink: 0;
            border-radius: 12px;
            background: var(--nu-green);
            color: white;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 800;
            font-size: 14px;
            letter-spacing: -.06em;
        }

        .admin-brand-name {
            display: block;
            font-size: 13px;
            font-weight: 800;
            letter-spacing: -.03em;
            white-space: nowrap;
        }

        .admin-brand-desc {
            display: block;
            font-size: 10px;
            font-weight: 700;
            color: #8A988D;
            letter-spacing: .09em;
            text-transform: uppercase;
            margin-top: 3px;
        }

        .admin-nav-title {
            font-size: 10px;
            font-weight: 800;
            color: #96A198;
            letter-spacing: .16em;
            text-transform: uppercase;
            margin-bottom: 13px;
            padding: 0 13px;
        }

        .admin-nav {
            display: flex;
            flex-direction: column;
            gap: 5px;
        }

        .admin-link {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 13px 13px;
            border-radius: 11px;
            color: #5F7064;
            font-size: 12px;
            font-weight: 800;
            white-space: nowrap;
            transition:
                background .2s ease,
                color .2s ease;
        }

        .admin-link:hover {
            background: #EBF1EA;
            color: var(--nu-green);
        }

        .admin-link[aria-current="page"] {
            background: var(--nu-green);
            color: #FFFFFF;
        }

        .admin-nav-icon {
            width: 22px;
            flex-shrink: 0;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            font-size: 19px;
        }

        .admin-nav-label {
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .admin-sidebar-bottom {
            margin-top: auto;
            padding: 24px 11px 0;
            border-top: 1px solid var(--nu-line);
        }

        .admin-profile-name {
            font-size: 12px;
            font-weight: 800;
            color: var(--nu-ink);
            overflow-wrap: anywhere;
        }

        .admin-profile-role {
            font-size: 11px;
            color: var(--nu-muted);
            margin-top: 4px;
        }

        .admin-logout {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            border: 0;
            background: transparent;
            color: #A43D3D;
            font-size: 12px;
            font-weight: 800;
            padding: 12px 0 0;
            cursor: pointer;
        }

        .admin-logout:hover {
            color: #752323;
        }

        /* ======================================
           CONTENT
        ====================================== */

        .admin-main {
            padding: 36px 44px 65px;
            min-width: 0;
            width: 100%;
        }

        .admin-topbar {
            display: flex;
            align-items: flex-start;
            justify-content: space-between;
            flex-wrap: wrap;
            gap: 20px;
            margin-bottom: 31px;
        }

        .admin-eyebrow {
            font-size: 10px;
            font-weight: 800;
            letter-spacing: .16em;
            text-transform: uppercase;
            color: #6F8674;
            margin-bottom: 11px;
        }

        .admin-heading {
            font-size: clamp(28px, 3vw, 42px);
            font-weight: 800;
            letter-spacing: -.06em;
            line-height: 1.1;
            color: #14261B;
        }

        .admin-subtitle {
            font-size: 13px;
            line-height: 1.7;
            color: #718075;
            margin-top: 9px;
            max-width: 700px;
        }

        .admin-website-btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
            background: #FFFFFF;
            border: 1px solid var(--nu-line);
            padding: 12px 17px;
            border-radius: 11px;
            font-size: 12px;
            font-weight: 800;
            color: var(--nu-green);
            transition: background .2s ease;
        }

        .admin-website-btn:hover {
            background: #E9F0E8;
        }

        .admin-panel {
            background: white;
            border: 1px solid var(--nu-line);
            border-radius: 20px;
        }

        .admin-alert {
            padding: 15px 18px;
            border-radius: 14px;
            margin-bottom: 20px;
            font-size: 13px;
            font-weight: 700;
        }

        .admin-alert-success {
            background: #EAF4E9;
            border: 1px solid #B9D7BD;
            color: #183C2F;
        }

        .admin-alert-error {
            background: #FFF0F0;
            border: 1px solid #E6C1C1;
            color: #9A3535;
        }

        /* ======================================
           RESPONSIVE
        ====================================== */

        @media (max-width: 1200px) {
            .admin-main {
                padding: 30px 27px 50px;
            }

            .admin-shell {
                grid-template-columns: 225px minmax(0, 1fr);
            }
        }

        @media (max-width: 800px) {
            .admin-shell {
                display: block;
            }

            .admin-sidebar {
                border-right: 0;
                border-bottom: 1px solid var(--nu-line);
                padding: 18px 15px 13px;
            }

            .admin-brand {
                margin-bottom: 18px;
                padding: 0 4px;
            }

            .admin-nav-title {
                display: none;
            }

            .admin-nav {
                flex-direction: row;
                overflow-x: auto;
                padding-bottom: 4px;
                scrollbar-width: thin;
            }

            .admin-link {
                flex-shrink: 0;
                padding: 11px 13px;
            }

            .admin-sidebar-bottom {
                margin-top: 10px;
                padding: 10px 4px 0;
                display: flex;
                align-items: center;
                justify-content: space-between;
                gap: 14px;
            }

            .admin-profile-role {
                margin-bottom: 0;
            }

            .admin-logout {
                padding-top: 0;
            }

            .admin-main {
                padding: 25px 17px 45px;
            }
        }

        @media (max-width: 480px) {
            .admin-topbar {
                margin-bottom: 23px;
            }

            .admin-heading {
                font-size: 30px;
            }

            .admin-website-btn {
                padding: 11px 14px;
            }
        }

        @media (prefers-reduced-motion: reduce) {
            html {
                scroll-behavior: auto;
            }

            .admin-link,
            .admin-website-btn {
                transition: none;
            }
        }
    </style>

    @stack('styles')
</head>

<body>

    <div class="admin-shell">

        <!-- ======================================
             SIDEBAR ADMIN BERSAMA
        ======================================= -->
        <aside class="admin-sidebar">

            <!-- LOGO -->
            <a
                href="{{ route('admin.dashboard') }}"
                class="admin-brand"
            >
                <span class="admin-brand-logo">
                    NU
                </span>

                <span>
                    <strong class="admin-brand-name">
                        NU LESMANA
                    </strong>

                    <small class="admin-brand-desc">
                        Panel Pengurus
                    </small>
                </span>
            </a>

            <!-- NAVIGASI -->
            <div>
                <p class="admin-nav-title">
                    Navigasi
                </p>

                <nav
                    class="admin-nav"
                    aria-label="Navigasi admin"
                >

                    <!-- 01. DASHBOARD -->
                    <a
                        href="{{ route('admin.dashboard') }}"
                        class="admin-link"
                        @if(request()->routeIs('admin.dashboard'))
                            aria-current="page"
                        @endif
                    >
                        <i class="ph ph-squares-four admin-nav-icon"></i>

                        <span class="admin-nav-label">
                            Dashboard
                        </span>
                    </a>

                    <!-- 02. KELOLA ANGGOTA -->
                    <a
                        href="{{ route('admin.members.index') }}"
                        class="admin-link"
                        @if(request()->routeIs('admin.members.*'))
                            aria-current="page"
                        @endif
                    >
                        <i class="ph ph-users-three admin-nav-icon"></i>

                        <span class="admin-nav-label">
                            Kelola Anggota
                        </span>
                    </a>

                    <!-- 03. KELOLA BERITA -->
                    <a
                        href="{{ route('admin.news.index') }}"
                        class="admin-link"
                        @if(request()->routeIs('admin.news.*'))
                            aria-current="page"
                        @endif
                    >
                        <i class="ph ph-newspaper admin-nav-icon"></i>

                        <span class="admin-nav-label">
                            Kelola Berita
                        </span>
                    </a>

                    <!-- 04. INFAQ -->
                    <a
                        href="{{ route('admin.infaq.index') }}"
                        class="admin-link"
                        @if(request()->routeIs('admin.infaq.*'))
                            aria-current="page"
                        @endif
                    >
                        <i class="ph ph-wallet admin-nav-icon"></i>

                        <span class="admin-nav-label">
                            Infaq / Kas
                        </span>
                    </a>

                    <!-- 05. KELOLA STRUKTUR -->
                    @if(\Illuminate\Support\Facades\Route::has('admin.struktur.index'))

                        <a
                            href="{{ route('admin.struktur.index') }}"
                            class="admin-link"
                            @if(request()->routeIs('admin.struktur.*'))
                                aria-current="page"
                            @endif
                        >
                            <i class="ph ph-tree-structure admin-nav-icon"></i>

                            <span class="admin-nav-label">
                                Kelola Struktur
                            </span>
                        </a>

                    @endif

                    <!-- 06. KELOLA ULASAN -->
                    @if(\Illuminate\Support\Facades\Route::has('admin.reviews.index'))

                        <a
                            href="{{ route('admin.reviews.index') }}"
                            class="admin-link"
                            @if(request()->routeIs('admin.reviews.*'))
                                aria-current="page"
                            @endif
                        >
                            <i class="ph ph-chat-circle-text admin-nav-icon"></i>

                            <span class="admin-nav-label">
                                Kelola Ulasan
                            </span>
                        </a>

                    @endif

                    <!-- OPSIONAL: KOTAK SARAN -->
                    @if(\Illuminate\Support\Facades\Route::has('admin.feedback.index'))

                        <a
                            href="{{ route('admin.feedback.index') }}"
                            class="admin-link"
                            @if(request()->routeIs('admin.feedback.*'))
                                aria-current="page"
                            @endif
                        >
                            <i class="ph ph-chat-centered-dots admin-nav-icon"></i>

                            <span class="admin-nav-label">
                                Kotak Saran
                            </span>
                        </a>

                    @endif

                </nav>
            </div>

            <!-- PROFIL ADMIN -->
            <div class="admin-sidebar-bottom">

                <div>
                    <p class="admin-profile-name">
                        {{ auth()->user()?->name ?? 'Administrator' }}
                    </p>

                    <p class="admin-profile-role">
                        Pengurus NU Lesmana
                    </p>
                </div>

                <form
                    action="{{ route('logout') }}"
                    method="POST"
                >
                    @csrf

                    <button
                        type="submit"
                        class="admin-logout"
                    >
                        <i class="ph ph-sign-out text-lg"></i>
                        Keluar
                    </button>
                </form>

            </div>

        </aside>

        <!-- ======================================
             HALAMAN ADMIN
        ======================================= -->
        <main class="admin-main">

            <!-- Header standar untuk semua modul.
                 Halaman ulasan sudah memiliki
                 header editorial tersendiri. -->
            @unless(request()->routeIs('admin.reviews.index'))

                <header class="admin-topbar">

                    <div>
                        <p class="admin-eyebrow">
                            Panel Pengurus / NU Lesmana
                        </p>

                        <h1 class="admin-heading">
                            @yield('heading', 'Dashboard')
                        </h1>

                        <p class="admin-subtitle">
                            @yield(
                                'subtitle',
                                'Pengelolaan informasi dan layanan warga'
                            )
                        </p>
                    </div>

                    <a
                        href="{{ route('home') }}"
                        target="_blank"
                        rel="noopener noreferrer"
                        class="admin-website-btn"
                    >
                        <i class="ph ph-arrow-square-out text-base"></i>
                        Lihat Website
                    </a>

                </header>

            @endunless

            <!-- NOTIFIKASI GLOBAL -->
            @unless(request()->routeIs('admin.reviews.index'))

                @if(session('success'))
                    <div
                        role="status"
                        class="admin-alert admin-alert-success"
                    >
                        <i class="ph ph-check-circle mr-2"></i>
                        {{ session('success') }}
                    </div>
                @endif

                @if($errors->any())
                    <div
                        role="alert"
                        class="admin-alert admin-alert-error"
                    >
                        <i class="ph ph-warning-circle mr-2"></i>
                        {{ $errors->first() }}
                    </div>
                @endif

            @endunless

            <!-- KONTEN HALAMAN -->
            @yield('content')

        </main>

    </div>

    @stack('scripts')

</body>
</html>
