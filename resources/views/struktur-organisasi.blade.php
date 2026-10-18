<!DOCTYPE html>
<html lang="id" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Struktur Badan Otonom | NU Lesmana</title>
    <meta name="description" content="Susunan kepengurusan Badan Otonom NU Lesmana dan statistik anggota terverifikasi.">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    {{-- Mempertahankan utilitas Tailwind yang dipakai komponen navbar Nulesmana. --}}
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Bebas+Neue&family=DM+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <script src="https://unpkg.com/@phosphor-icons/web"></script>

    <style>
        :root {
            --forest: #183C2F;
            --forest-dark: #102B21;
            --ivory: #F5F4F0;
            --ink: #17231E;
            --muted: #63736A;
            --line: #DCE3DC;
            --card: #FFFFFF;
        }

        *, *::before, *::after { box-sizing: border-box; }
        body { margin: 0; background: var(--ivory); color: var(--ink); font-family: 'DM Sans', sans-serif; }
        .struktur-wrap { width: min(1190px, calc(100% - 40px)); margin-inline: auto; }
        .display-type { font-family: 'Bebas Neue', Impact, sans-serif; font-weight: 400; letter-spacing: .015em; }
        .eyebrow { font-size: 11px; font-weight: 800; letter-spacing: .18em; text-transform: uppercase; color: #5F7466; }

        .hero { padding: 158px 0 50px; border-bottom: 1px solid var(--line); }
        .hero-layout { display: grid; grid-template-columns: minmax(0, 1fr) 280px; align-items: end; gap: 35px; }
        .hero h1 { max-width: 850px; margin: 17px 0 14px; font-size: clamp(66px, 9vw, 122px); line-height: .89; color: var(--forest); }
        .hero-description { max-width: 570px; margin: 0; color: var(--muted); line-height: 1.8; font-size: 14px; }
        .hero-aside { border-left: 1px solid #CBD7CB; padding-left: 25px; }
        .hero-aside strong { display: block; font: 400 82px/.95 'Bebas Neue', sans-serif; color: var(--forest); }
        .hero-aside small { display: block; max-width: 170px; color: var(--muted); font-size: 12px; line-height: 1.6; }

        .directory { padding: 42px 0 85px; }
        .directory-header { display: flex; align-items: end; justify-content: space-between; gap: 20px; margin-bottom: 23px; }
        .directory-header h2 { font: 400 43px/1 'Bebas Neue', sans-serif; color: var(--forest); margin: 9px 0 0; }
        .directory-header .note { color: var(--muted); font-size: 12px; text-align: right; }
        .tabs { display: flex; gap: 7px; overflow-x: auto; padding: 0 0 14px; scrollbar-width: thin; }
        .tab { flex: 0 0 auto; appearance: none; border: 1px solid #D2DED4; background: transparent; border-radius: 100px; padding: 12px 19px; color: #41574A; font: 700 12px 'DM Sans', sans-serif; cursor: pointer; transition: background .15s, color .15s, border-color .15s; }
        .tab:hover { border-color: var(--forest); }
        .tab[aria-selected="true"] { background: var(--forest); color: #FFFFFF; border-color: var(--forest); }
        .tab:focus-visible { outline: 3px solid #86B09A; outline-offset: 3px; }

        .panel { background: var(--card); border: 1px solid var(--line); border-radius: 20px; padding: 35px; }
        .panel[hidden] { display: none !important; }
        .panel-intro { display: flex; align-items: center; justify-content: space-between; gap: 25px; padding-bottom: 27px; border-bottom: 1px solid var(--line); }
        .panel-num { display: block; font: 400 14px 'Bebas Neue', sans-serif; letter-spacing: .1em; color: var(--muted); }
        .panel-title { margin: 6px 0 6px; font-size: clamp(24px, 3.5vw, 35px); letter-spacing: -.045em; color: var(--forest); }
        .panel-subtitle { margin: 0; color: var(--muted); font-size: 12px; line-height: 1.7; }
        .member-count { flex: 0 0 auto; display: flex; flex-direction: column; align-items: end; gap: 2px; }
        .member-count strong { font: 400 56px/1 'Bebas Neue', sans-serif; color: var(--forest); }
        .member-count small { font-size: 10px; font-weight: 700; color: var(--muted); }

        .tree { padding: 32px 0 5px; }
        .tree-section + .tree-section { margin-top: 22px; }
        .tree-step { display: flex; align-items: center; gap: 12px; margin: 0 auto 16px; width: min(940px, 100%); }
        .tree-step span { flex: none; color: #829286; font-size: 10px; font-weight: 800; letter-spacing: .13em; text-transform: uppercase; }
        .tree-step::after { content: ''; height: 1px; flex: 1; background: #E4E9E4; }
        .tree-grid { display: grid; grid-template-columns: repeat(var(--cols), minmax(0, 1fr)); gap: 13px; max-width: min(100%, calc(var(--cols) * 312px)); margin-inline: auto; }
        .person-card { min-width: 0; min-height: 174px; background: #F8F9F6; border: 1px solid #DFE7DE; border-radius: 14px; padding: 22px; display: flex; flex-direction: column; align-items: start; }
        .person-card.lead { background: var(--forest); color: #FFFFFF; border-color: var(--forest); }
        .person-head { width: 100%; display: flex; align-items: center; justify-content: space-between; gap: 10px; margin-bottom: 22px; }
        .person-number { font: 400 28px/1 'Bebas Neue', sans-serif; opacity: .7; }
        .person-symbol { width: 30px; height: 30px; border: 1px solid currentColor; border-radius: 50%; display: grid; place-items: center; opacity: .42; font-size: 15px; }
        .person-role { font-size: 10px; letter-spacing: .15em; text-transform: uppercase; font-weight: 800; opacity: .67; }
        .person-name { display: block; margin-top: 8px; font-size: 16px; font-weight: 800; line-height: 1.4; overflow-wrap: anywhere; }
        .person-meta { display: inline-block; margin-top: 9px; font-size: 10px; line-height: 1.6; opacity: .7; }
        .demo-tag { display: inline-flex; border-radius: 4px; font-size: 9px; letter-spacing: .04em; font-weight: 800; border: 1px solid currentColor; padding: 3px 6px; margin-top: 12px; opacity: .7; }
        .empty { text-align: center; padding: 55px 25px; color: var(--muted); font-size: 13px; }
        .panel-footer { margin-top: 29px; border-top: 1px solid var(--line); padding-top: 20px; font-size: 11px; line-height: 1.8; color: var(--muted); }
        .bottom-nav { display: flex; align-items: center; justify-content: space-between; gap: 16px; margin-top: 25px; }
        .back-link { text-decoration: none; color: var(--forest); font-size: 12px; font-weight: 800; }
        .back-link:hover { text-decoration: underline; }
        .small-mark { font-size: 10px; color: var(--muted); }
        @media (max-width: 850px) {
            .hero-layout { grid-template-columns: minmax(0, 1fr); }
            .hero-aside { display: none; }
        }
        @media (max-width: 680px) {
            .struktur-wrap { width: min(100% - 28px, 1190px); }
            .hero { padding: 130px 0 34px; }
            .hero h1 { font-size: clamp(57px, 13vw, 85px); }
            .directory { padding-top: 28px; }
            .panel { padding: 20px 16px; border-radius: 15px; }
            .panel-intro { align-items: flex-start; }
            .member-count strong { font-size: 45px; }
            .tree-grid { grid-template-columns: 1fr; max-width: 420px; }
            .person-card { min-height: 147px; }
            .directory-header h2 { font-size: 37px; }
            .directory-header .note { display: none; }
        }
        @media (prefers-reduced-motion: reduce) { .tab { transition: none; } }
    </style>
</head>
<body>
    <x-site-navbar />

    <header class="hero">
        <div class="struktur-wrap hero-layout">
            <div>
                <div class="eyebrow">PRNU LESMANA <span aria-hidden="true">/</span> BADAN OTONOM</div>
                <h1 class="display-type">STRUKTUR<br>ORGANISASI.</h1>
                <p class="hero-description">
                    Susunan kepengurusan lima Badan Otonom NU Lesmana.
                    Data pengurus dikelola melalui dashboard admin, sedangkan jumlah anggota
                    terverifikasi dihitung dari pendaftaran yang telah disetujui.
                </p>
            </div>
            <div class="hero-aside" aria-label="Lima badan otonom">
                <strong>05</strong>
                <small>Badan Otonom dalam satu direktori kepengurusan.</small>
            </div>
        </div>
    </header>

    <main id="struktur-banom" class="struktur-wrap directory">
        <div class="directory-header">
            <div>
                <div class="eyebrow">DIREKTORI PENGURUS</div>
                <h2>KENALI SUSUNANNYA.</h2>
            </div>
            <div class="note">Pilih salah satu Banom untuk melihat struktur.</div>
        </div>

        <div class="tabs" role="tablist" aria-label="Pilih Badan Otonom">
            @foreach ($banoms as $key => $banom)
                <button
                    type="button"
                    id="tab-{{ strtolower($key) }}"
                    role="tab"
                    class="tab"
                    aria-selected="{{ $loop->first ? 'true' : 'false' }}"
                    aria-controls="panel-{{ strtolower($key) }}"
                    tabindex="{{ $loop->first ? '0' : '-1' }}"
                    data-tab="{{ strtolower($key) }}"
                >{{ $banom['label'] }}</button>
            @endforeach
        </div>

        @foreach ($banoms as $key => $banom)
            <section
                id="panel-{{ strtolower($key) }}"
                class="panel"
                role="tabpanel"
                aria-labelledby="tab-{{ strtolower($key) }}"
                data-panel="{{ strtolower($key) }}"
                @if (!$loop->first) hidden @endif
            >
                <div class="panel-intro">
                    <div>
                        <span class="panel-num">0{{ $loop->iteration }} / 05</span>
                        <h3 class="panel-title">{{ $banom['label'] }}</h3>
                        <p class="panel-subtitle">Susunan jabatan yang ditampilkan untuk publik.</p>
                    </div>
                    <div class="member-count">
                        <strong>{{ $banom['count'] }}</strong>
                        <small>ANGGOTA ACC</small>
                    </div>
                </div>

                @if ($banom['positions']->isEmpty())
                    <div class="empty">Belum ada pengurus yang dipublikasikan untuk Banom ini.</div>
                @else
                    <div class="tree">
                        @foreach ($banom['positions']->groupBy('level') as $level => $group)
                            <section class="tree-section" aria-label="Tingkat organisasi {{ $level }}">
                                <div class="tree-step">
                                    <span>
                                        {{ (int) $level === 1 ? 'Pimpinan' : ((int) $level === 2 ? 'Pengurus harian' : 'Bidang & program') }}
                                    </span>
                                </div>
                                <div class="tree-grid" style="--cols: {{ min(3, $group->count()) }};">
                                    @foreach ($group as $position)
                                        @php
                                            $isExample = $position->member_id === null
                                                && str_starts_with((string) $position->person_name, 'Contoh ');
                                        @endphp
                                        <article class="person-card {{ (int) $level === 1 ? 'lead' : '' }}">
                                            <div class="person-head">
                                                <span class="person-number">{{ str_pad((string) $loop->iteration, 2, '0', STR_PAD_LEFT) }}</span>
                                                <span class="person-symbol" aria-hidden="true">✦</span>
                                            </div>
                                            <span class="person-role">{{ $position->role }}</span>
                                            <strong class="person-name">{{ $position->member_name ?: ($position->person_name ?: 'Belum ditentukan') }}</strong>
                                            @if ($isExample)
                                                <span class="demo-tag">DATA CONTOH</span>
                                            @elseif ($position->description && !str_starts_with((string) $position->description, 'Data contoh'))
                                                <span class="person-meta">{{ $position->description }}</span>
                                            @endif
                                        </article>
                                    @endforeach
                                </div>
                            </section>
                        @endforeach
                    </div>
                @endif

                <p class="panel-footer">
                    Data berlabel <strong>DATA CONTOH</strong> adalah placeholder untuk kebutuhan tampilan,
                    bukan penetapan pengurus resmi. Admin dapat menggantinya kapan saja.
                    Jumlah anggota ACC dihitung terpisah dari struktur jabatan.
                </p>
            </section>
        @endforeach

        <div class="bottom-nav">
            <a class="back-link" href="{{ route('home') }}">← Kembali ke beranda</a>
            <span class="small-mark">NU LESMANA / ORGANISASI</span>
        </div>
    </main>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const tabs = [...document.querySelectorAll('[data-tab]')];
            const panels = [...document.querySelectorAll('[data-panel]')];

            function showBanom(key, focus = false) {
                tabs.forEach(tab => {
                    const selected = tab.dataset.tab === key;
                    tab.setAttribute('aria-selected', selected ? 'true' : 'false');
                    tab.tabIndex = selected ? 0 : -1;
                    if (selected && focus) tab.focus();
                });
                panels.forEach(panel => {
                    panel.hidden = panel.dataset.panel !== key;
                });
            }

            tabs.forEach((tab, index) => {
                tab.addEventListener('click', () => showBanom(tab.dataset.tab));
                tab.addEventListener('keydown', event => {
                    if (!['ArrowLeft', 'ArrowRight', 'Home', 'End'].includes(event.key)) return;
                    event.preventDefault();
                    let next = index;
                    if (event.key === 'ArrowLeft') next = (index - 1 + tabs.length) % tabs.length;
                    if (event.key === 'ArrowRight') next = (index + 1) % tabs.length;
                    if (event.key === 'Home') next = 0;
                    if (event.key === 'End') next = tabs.length - 1;
                    showBanom(tabs[next].dataset.tab, true);
                });
            });
        });
    </script>
</body>
</html>
