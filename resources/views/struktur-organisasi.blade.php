<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Struktur Organisasi | NU Lesmana</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Bebas+Neue&family=DM+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <script src="https://unpkg.com/@phosphor-icons/web"></script>

    <style>
        body {
            font-family: 'DM Sans', sans-serif;
            background: #F5F4F0;
            color: #17251E;
        }

        .font-display {
            font-family: 'Bebas Neue', sans-serif;
            letter-spacing: .015em;
        }

        .banom-tabs {
            display: flex;
            gap: 8px;
            overflow-x: auto;
            scrollbar-width: none;
            padding-bottom: 6px;
        }

        .banom-tabs::-webkit-scrollbar { display: none; }

        .banom-tab {
            flex-shrink: 0;
            border-radius: 100px;
            border: 1px solid #D5DED5;
            padding: 11px 17px;
            font-size: 12px;
            font-weight: 800;
            color: #365545;
            background: #FFFFFF;
        }

        .banom-tab[aria-selected="true"] {
            background: #183C2F;
            border-color: #183C2F;
            color: #FFFFFF;
        }

        .org-row {
            position: relative;
            display: grid;
            grid-template-columns: repeat(var(--columns), minmax(0, 1fr));
            gap: 16px;
            justify-content: center;
            margin: 24px auto 0;
            max-width: min(100%, calc(var(--columns) * 280px));
        }

        .org-row + .org-row {
            border-top: 1px solid #E0E7DF;
            padding-top: 24px;
        }

        .org-position {
            border-radius: 16px;
            border: 1px solid #DCE5DC;
            background: #F8FAF7;
            padding: 22px;
            min-width: 0;
        }

        .org-position.lead {
            border-color: #183C2F;
            background: #183C2F;
            color: white;
        }

        .org-position .role {
            display: block;
            font-size: 11px;
            text-transform: uppercase;
            letter-spacing: .09em;
            font-weight: 800;
            opacity: .7;
        }

        .org-position .person {
            display: block;
            margin-top: 12px;
            font-weight: 800;
            font-size: 16px;
            overflow-wrap: anywhere;
        }

        .org-position .description {
            display: block;
            margin-top: 7px;
            font-size: 12px;
            line-height: 1.7;
            opacity: .75;
        }

        [hidden] { display: none !important; }

        @media (max-width: 700px) {
            .org-row {
                grid-template-columns: minmax(0, 1fr);
                max-width: 480px;
            }
        }
    </style>
</head>

<body class="min-h-screen overflow-x-hidden">
    <x-site-navbar />

    <main class="mx-auto max-w-7xl px-4 pb-24 pt-36 sm:px-6">
        <header class="max-w-3xl">
            <p class="text-xs font-bold uppercase tracking-[.18em] text-[#547360]">
                PRNU Lesmana / Badan Otonom
            </p>

            <h1 class="font-display mt-4 text-6xl leading-none text-[#183C2F] sm:text-8xl">
                STRUKTUR ORGANISASI.
            </h1>

            <p class="mt-4 max-w-2xl text-sm leading-7 text-[#647569] sm:text-base">
                Susunan pengurus yang telah ditetapkan dan jumlah anggota
                terverifikasi pada masing-masing Badan Otonom NU Lesmana.
            </p>
        </header>

        <section id="struktur-banom" class="mt-12 rounded-3xl border border-[#E1E8E0] bg-white p-5 sm:p-9">
            <div class="flex flex-wrap items-end justify-between gap-4 border-b border-[#E7EBE5] pb-7">
                <div>
                    <p class="text-xs font-bold uppercase tracking-[.15em] text-[#647569]">Data Organisasi</p>
                    <h2 class="font-display mt-2 text-4xl text-[#183C2F] sm:text-5xl">LIMA BADAN OTONOM</h2>
                </div>
                <p class="text-sm font-semibold text-[#647569]">
                    {{ collect($banoms)->sum('count') }} anggota terverifikasi
                </p>
            </div>

            <div class="banom-tabs my-7" role="tablist" aria-label="Pilih Badan Otonom">
                @foreach ($banoms as $key => $banom)
                    <button
                        type="button"
                        class="banom-tab"
                        id="tab-{{ strtolower($key) }}"
                        role="tab"
                        aria-controls="panel-{{ strtolower($key) }}"
                        aria-selected="{{ $loop->first ? 'true' : 'false' }}"
                        tabindex="{{ $loop->first ? '0' : '-1' }}"
                        data-banom-tab="{{ strtolower($key) }}"
                    >
                        {{ $banom['label'] }}
                    </button>
                @endforeach
            </div>

            @foreach ($banoms as $key => $banom)
                <section
                    id="panel-{{ strtolower($key) }}"
                    role="tabpanel"
                    aria-labelledby="tab-{{ strtolower($key) }}"
                    data-banom-panel="{{ strtolower($key) }}"
                    @if (!$loop->first) hidden @endif
                >
                    <div class="flex flex-wrap items-center justify-between gap-4 rounded-2xl bg-[#EDF2EC] px-6 py-5">
                        <div>
                            <h3 class="text-lg font-extrabold text-[#183C2F]">{{ $banom['label'] }}</h3>
                            <p class="mt-1 text-xs text-[#65776A]">Anggota yang sudah disetujui pengurus</p>
                        </div>
                        <div class="text-right">
                            <p class="text-3xl font-extrabold text-[#183C2F]">{{ $banom['count'] }}</p>
                            <p class="text-[11px] text-[#65776A]">Anggota terverifikasi</p>
                        </div>
                    </div>

                    @if ($banom['positions']->isEmpty())
                        <div class="py-16 text-center">
                            <i class="ph ph-users-three text-4xl text-[#183C2F]" aria-hidden="true"></i>
                            <p class="mt-4 text-sm font-bold text-[#183C2F]">Struktur kepengurusan belum dipublikasikan</p>
                            <p class="mt-2 text-xs text-[#728173]">Pengurus akan melengkapi susunan jabatan melalui panel admin.</p>
                        </div>
                    @else
                        @foreach ($banom['positions']->groupBy('level') as $level => $group)
                            <div class="org-row" style="--columns: {{ min(3, $group->count()) }};">
                                @foreach ($group as $position)
                                    <article class="org-position {{ (int) $level === 1 ? 'lead' : '' }}">
                                        <i class="ph ph-user-circle text-2xl" aria-hidden="true"></i>
                                        <span class="role mt-3">{{ $position->role }}</span>
                                        <span class="person">{{ $position->member_name ?: $position->person_name }}</span>
                                        @if ($position->description)
                                            <span class="description">{{ $position->description }}</span>
                                        @endif
                                    </article>
                                @endforeach
                            </div>
                        @endforeach
                    @endif
                </section>
            @endforeach

            <p class="mt-10 border-t border-[#E7EBE5] pt-6 text-xs leading-6 text-[#718073]">
                Jumlah anggota otomatis mengikuti persetujuan (ACC) dan perubahan data Banom.
                Nama anggota biasa tidak ditampilkan di halaman publik; hanya jabatan pengurus
                yang dipublikasikan oleh admin.
            </p>
        </section>

        <a href="{{ route('home') }}" class="mt-8 inline-flex items-center gap-2 text-sm font-bold text-[#183C2F]">
            <i class="ph ph-arrow-left"></i> Kembali ke Beranda
        </a>
    </main>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const tabs = Array.from(document.querySelectorAll('[data-banom-tab]'));
            const panels = Array.from(document.querySelectorAll('[data-banom-panel]'));

            function activate(key) {
                tabs.forEach(tab => {
                    const active = tab.dataset.banomTab === key;
                    tab.setAttribute('aria-selected', active ? 'true' : 'false');
                    tab.tabIndex = active ? 0 : -1;
                });

                panels.forEach(panel => {
                    panel.hidden = panel.dataset.banomPanel !== key;
                });
            }

            tabs.forEach((tab, index) => {
                tab.addEventListener('click', () => activate(tab.dataset.banomTab));
                tab.addEventListener('keydown', event => {
                    if (event.key !== 'ArrowRight' && event.key !== 'ArrowLeft') return;
                    event.preventDefault();
                    const next = (index + (event.key === 'ArrowRight' ? 1 : -1) + tabs.length) % tabs.length;
                    tabs[next].focus();
                    activate(tabs[next].dataset.banomTab);
                });
            });
        });
    </script>
</body>
</html>
