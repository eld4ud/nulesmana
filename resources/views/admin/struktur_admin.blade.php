<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kelola Struktur Organisasi | NU Lesmana</title>
    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <script src="https://unpkg.com/@phosphor-icons/web"></script>
    <style>
        :root {
            --forest: #183C2F;
            --ivory: #F5F4F0;
            --border: #E1E7DE;
            --muted: #69786D;
        }

        * { box-sizing: border-box; }
        body { margin: 0; background: var(--ivory); color: #1B2A21; font-family: 'DM Sans', sans-serif; }
        a { text-decoration: none; color: inherit; }
        button, input, select, textarea { font: inherit; }
        button { cursor: pointer; }
        .layout { display: grid; grid-template-columns: 242px minmax(0, 1fr); min-height: 100vh; }
        .side { padding: 30px 18px; background: white; border-right: 1px solid var(--border); }
        .brand { display: block; padding: 7px 12px 28px; font-size: 17px; font-weight: 800; color: var(--forest); }
        .brand small { display: block; margin-top: 4px; font-size: 10px; letter-spacing: .16em; color: var(--muted); }
        .side-link { display: flex; gap: 11px; align-items: center; margin-bottom: 5px; border-radius: 11px; padding: 13px; font-size: 13px; color: #546A59; font-weight: 700; }
        .side-link:hover { background: #EFF3ED; }
        .side-link.active { background: var(--forest); color: white; }
        .main { width: 100%; max-width: 1200px; min-width: 0; margin: 0 auto; padding: 40px 44px 80px; }
        .top { display: flex; align-items: start; justify-content: space-between; gap: 18px; flex-wrap: wrap; }
        .eyebrow { font-size: 11px; color: #52715D; font-weight: 800; letter-spacing: .15em; text-transform: uppercase; }
        h1 { font-size: clamp(27px, 3vw, 41px); letter-spacing: -.055em; margin: 10px 0; }
        h2 { font-size: 19px; margin: 0 0 6px; }
        .muted { font-size: 13px; line-height: 1.7; color: var(--muted); }
        .pill-link { display: inline-flex; align-items: center; gap: 8px; border: 1px solid #CEDBD0; padding: 11px 15px; border-radius: 11px; background: white; font-size: 12px; font-weight: 800; }
        .tabs { display: flex; flex-wrap: wrap; gap: 8px; margin: 28px 0; }
        .tab { display: block; background: white; border: 1px solid var(--border); border-radius: 30px; padding: 11px 17px; color: var(--forest); font-size: 12px; font-weight: 800; }
        .tab.active { background: var(--forest); color: white; border-color: var(--forest); }
        .panel { background: white; border: 1px solid var(--border); border-radius: 19px; padding: 26px; margin-bottom: 22px; }
        .panel-head { display: flex; align-items: start; justify-content: space-between; gap: 12px; margin-bottom: 23px; }
        .count { text-align: right; color: var(--forest); font-size: 30px; font-weight: 800; }
        .count small { display: block; font-size: 10px; font-weight: 700; color: var(--muted); }
        label { display: block; color: #384F3F; font-size: 12px; font-weight: 800; margin-bottom: 8px; }
        .fields { display: grid; grid-template-columns: repeat(2, minmax(0, 1fr)); gap: 19px; }
        .field.wide { grid-column: 1 / -1; }
        input, select, textarea { width: 100%; border: 1px solid #D6E2D6; border-radius: 11px; padding: 13px 14px; background: #F9FAF7; color: #213E29; font-size: 13px; }
        textarea { resize: vertical; min-height: 70px; }
        input:focus, select:focus, textarea:focus { outline: 2px solid #8BB49A; outline-offset: 1px; }
        input[type='checkbox'] { width: 17px; height: 17px; accent-color: var(--forest); }
        .checkbox-label { display: flex; align-items: center; gap: 10px; margin: 0; }
        .actions { display: flex; align-items: center; gap: 12px; flex-wrap: wrap; margin-top: 24px; }
        .btn { border-radius: 11px; border: 1px solid #C8D7C9; background: white; color: var(--forest); padding: 12px 18px; font-size: 12px; font-weight: 800; }
        .btn.primary { background: var(--forest); color: white; border-color: var(--forest); }
        .btn.delete { color: #A63E3E; border-color: #E7C9C9; }
        .entry { border: 1px solid var(--border); padding: 17px 20px; border-radius: 14px; margin-top: 11px; }
        .entry summary { cursor: pointer; list-style: none; display: flex; gap: 10px; align-items: center; justify-content: space-between; }
        .entry summary::-webkit-details-marker { display: none; }
        .entry strong { display: block; color: var(--forest); font-size: 14px; }
        .entry .sub { margin-top: 5px; color: var(--muted); font-size: 12px; }
        .entry-body { padding-top: 21px; border-top: 1px solid var(--border); margin-top: 19px; }
        .notice { padding: 16px 19px; border-radius: 11px; margin: 18px 0; border: 1px solid #BBD2C0; background: #EAF3EA; font-size: 13px; }
        .notice.error { color: #8C2B2B; background: #FFF0F0; border-color: #E8C3C3; }
        .empty { padding: 32px; text-align: center; color: var(--muted); font-size: 13px; }
        @media (max-width: 900px) { .layout { grid-template-columns: 1fr; } .side { border-right: 0; border-bottom: 1px solid var(--border); padding: 18px; } .side nav { display: flex; overflow-x: auto; } .side-link { white-space: nowrap; } .main { padding: 25px 16px 60px; } }
        @media (max-width: 560px) { .fields { grid-template-columns: 1fr; } .panel { padding: 19px; } }
    </style>
</head>
<body>
    <div class="layout">
        <aside class="side">
            <a class="brand" href="{{ route('admin.dashboard') }}">
                NU LESMANA
                <small>PANEL PENGURUS</small>
            </a>
            <nav aria-label="Menu pengurus">
                <a class="side-link" href="{{ route('admin.dashboard') }}"><i class="ph ph-squares-four"></i> Dashboard</a>
                <a class="side-link" href="{{ route('admin.members.index') }}"><i class="ph ph-users-three"></i> Kelola Anggota</a>
                <a class="side-link active" href="{{ route('admin.struktur.index') }}" aria-current="page"><i class="ph ph-tree-structure"></i> Struktur Organisasi</a>
                <a class="side-link" href="{{ route('admin.news.index') }}"><i class="ph ph-newspaper"></i> Berita</a>
                <a class="side-link" href="{{ route('admin.infaq.index') }}"><i class="ph ph-wallet"></i> Infaq / Kas</a>
                <a class="side-link" href="{{ route('home') }}"><i class="ph ph-arrow-up-right"></i> Website Utama</a>
            </nav>
        </aside>

        <main class="main">
            <div class="top">
                <div>
                    <p class="eyebrow">Panel Admin / Struktur Organisasi</p>
                    <h1>Kelola Struktur Organisasi</h1>
                    <p class="muted">Atur jabatan tiap Banom. Statistik anggota dihitung otomatis setelah ACC.</p>
                </div>
                <a class="pill-link" href="{{ route('struktur.banom') }}" target="_blank" rel="noopener noreferrer">
                    Lihat di publik <i class="ph ph-arrow-up-right"></i>
                </a>
            </div>

            @if (session('success'))
                <div class="notice" role="status">{{ session('success') }}</div>
            @endif

            @if ($errors->any())
                <div class="notice error" role="alert">
                    <strong>Periksa data yang diisi.</strong>
                    <ul style="margin: 8px 0 0; padding-left: 22px;">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <nav class="tabs" aria-label="Pilih Banom">
                @foreach ($banomLabels as $key => $label)
                    <a href="{{ route('admin.struktur.index', ['banom' => $key]) }}"
                       class="tab {{ $selected === $key ? 'active' : '' }}"
                       @if ($selected === $key) aria-current="page" @endif>
                        {{ $label }} ({{ $counts[$key] }})
                    </a>
                @endforeach
            </nav>

            <section class="panel">
                <div class="panel-head">
                    <div>
                        <h2>Tambah Jabatan</h2>
                        <p class="muted">Pilih akun anggota yang sudah ACC, atau isi nama pengurus manual.</p>
                    </div>
                    <div class="count">{{ $counts[$selected] }}<small>Anggota ACC</small></div>
                </div>

                <form method="POST" action="{{ route('admin.struktur.store') }}">
                    @csrf
                    <input type="hidden" name="banom" value="{{ $selected }}">
                    <div class="fields">
                        <div class="field">
                            <label for="new-role">Jabatan</label>
                            <input id="new-role" name="role" value="{{ old('role') }}" placeholder="Contoh: Ketua Ranting" required maxlength="100">
                        </div>
                        <div class="field">
                            <label for="new-member">Pilih Anggota Terverifikasi (opsional)</label>
                            <select id="new-member" name="member_id">
                                <option value="">Nama ditulis manual</option>
                                @foreach ($members as $member)
                                    <option value="{{ $member->id }}" @selected(old('member_id') == $member->id)>
                                        {{ $member->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="field">
                            <label for="new-name">Nama pengurus manual</label>
                            <input id="new-name" name="person_name" value="{{ old('person_name') }}" placeholder="Isi jika tidak memilih akun anggota" maxlength="120">
                        </div>
                        <div class="field">
                            <label for="new-desc">Keterangan singkat (opsional)</label>
                            <input id="new-desc" name="description" value="{{ old('description') }}" placeholder="Contoh: Pimpinan Ranting" maxlength="180">
                        </div>
                        <div class="field">
                            <label for="new-level">Tingkat struktur</label>
                            <select id="new-level" name="level">
                                <option value="1">1 - Pimpinan / Ketua</option>
                                <option value="2" selected>2 - Sekretaris / Bendahara</option>
                                <option value="3">3 - Divisi / Bidang</option>
                            </select>
                        </div>
                        <div class="field">
                            <label for="new-order">Urutan tampil</label>
                            <input id="new-order" type="number" name="sort_order" value="{{ old('sort_order', 0) }}" min="0" max="999" required>
                        </div>
                        <div class="field wide">
                            <input type="hidden" name="is_visible" value="0">
                            <label class="checkbox-label">
                                <input type="checkbox" name="is_visible" value="1" checked>
                                Tampilkan jabatan di halaman publik
                            </label>
                        </div>
                    </div>
                    <div class="actions">
                        <button class="btn primary" type="submit">+ Tambah Jabatan</button>
                    </div>
                </form>
            </section>

            <section class="panel">
                <h2>Susunan Pengurus</h2>
                <p class="muted">Klik baris untuk mengubah jabatan, anggota pengurus, level, atau urutan.</p>

                @forelse ($positions as $position)
                    <details class="entry">
                        <summary>
                            <span>
                                <strong>{{ $position->role }}</strong>
                                <span class="sub">
                                    {{ $position->member_name ?: $position->person_name }} · Tingkat {{ $position->level }}
                                    @if (!$position->is_visible) · Disembunyikan @endif
                                </span>
                            </span>
                            <i class="ph ph-pencil-simple text-xl" aria-hidden="true"></i>
                        </summary>

                        <div class="entry-body">
                            <form method="POST" action="{{ route('admin.struktur.update', $position->id) }}">
                                @csrf
                                @method('PUT')
                                <input type="hidden" name="banom" value="{{ $selected }}">
                                <div class="fields">
                                    <div class="field">
                                        <label for="role-{{ $position->id }}">Jabatan</label>
                                        <input id="role-{{ $position->id }}" name="role" value="{{ $position->role }}" required maxlength="100">
                                    </div>
                                    <div class="field">
                                        <label for="member-{{ $position->id }}">Pilih Anggota ACC</label>
                                        <select id="member-{{ $position->id }}" name="member_id">
                                            <option value="">Nama manual</option>
                                            @foreach ($members as $member)
                                                <option value="{{ $member->id }}" @selected($position->member_id == $member->id)>
                                                    {{ $member->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="field">
                                        <label for="person-{{ $position->id }}">Nama manual (jika bukan anggota ACC)</label>
                                        <input id="person-{{ $position->id }}" name="person_name" value="{{ $position->person_name }}" maxlength="120">
                                    </div>
                                    <div class="field">
                                        <label for="desc-{{ $position->id }}">Keterangan</label>
                                        <input id="desc-{{ $position->id }}" name="description" value="{{ $position->description }}" maxlength="180">
                                    </div>
                                    <div class="field">
                                        <label for="level-{{ $position->id }}">Tingkat struktur</label>
                                        <select id="level-{{ $position->id }}" name="level">
                                            @foreach ([1 => '1 - Pimpinan', 2 => '2 - Sekretaris / Bendahara', 3 => '3 - Divisi'] as $level => $label)
                                                <option value="{{ $level }}" @selected($position->level == $level)>{{ $label }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="field">
                                        <label for="order-{{ $position->id }}">Urutan</label>
                                        <input id="order-{{ $position->id }}" type="number" name="sort_order" value="{{ $position->sort_order }}" min="0" max="999" required>
                                    </div>
                                    <div class="field wide">
                                        <input type="hidden" name="is_visible" value="0">
                                        <label class="checkbox-label">
                                            <input type="checkbox" name="is_visible" value="1" @checked($position->is_visible)>
                                            Tampilkan di publik
                                        </label>
                                    </div>
                                </div>
                                <div class="actions">
                                    <button class="btn primary" type="submit">Simpan Perubahan</button>
                                </div>
                            </form>
                            <form method="POST" action="{{ route('admin.struktur.destroy', $position->id) }}"
                                  onsubmit="return confirm('Hapus jabatan ini dari struktur organisasi? Data anggota tetap aman.')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn delete" style="margin-top: 12px;">Hapus Jabatan</button>
                            </form>
                        </div>
                    </details>
                @empty
                    <div class="empty">Belum ada susunan pengurus. Tambahkan jabatan menggunakan form di atas.</div>
                @endforelse
            </section>
        </main>
    </div>
</body>
</html>
