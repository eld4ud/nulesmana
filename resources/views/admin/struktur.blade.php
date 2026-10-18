<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kelola Struktur | Admin NU Lesmana</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Bebas+Neue&family=DM+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <script src="https://unpkg.com/@phosphor-icons/web"></script>
    <style>
        :root { --forest:#183C2F; --deep:#122E24; --ivory:#F5F4F0; --ink:#17251F; --muted:#69796D; --line:#DDE5DB; }
        *, *::before, *::after { box-sizing:border-box; }
        body { margin:0; background:var(--ivory); color:var(--ink); font:14px/1.6 'DM Sans',sans-serif; }
        a { color:inherit; text-decoration:none; }
        button, input, select, textarea { font:inherit; }
        button { cursor:pointer; }
        .layout { display:grid; grid-template-columns:238px minmax(0,1fr); min-height:100vh; }
        .sidebar { padding:30px 17px; background:#FFFFFF; border-right:1px solid var(--line); }
        .brand { display:flex; align-items:center; gap:12px; padding:0 11px 29px; border-bottom:1px solid var(--line); margin-bottom:25px; }
        .brand-mark { display:grid; place-items:center; width:39px; height:39px; flex:none; border-radius:10px; background:var(--forest); color:#FFF; font:27px 'Bebas Neue',sans-serif; }
        .brand strong { display:block; font-size:13px; color:var(--forest); letter-spacing:-.03em; }
        .brand small { display:block; font-size:10px; color:var(--muted); letter-spacing:.12em; font-weight:800; }
        .nav-label { font-size:10px; font-weight:800; color:#9AA89E; letter-spacing:.18em; margin:0 12px 12px; }
        .side-links { display:grid; gap:5px; }
        .side-link { display:flex; align-items:center; gap:11px; padding:12px 13px; border-radius:9px; color:#526257; font-size:12px; font-weight:700; }
        .side-link i { font-size:18px; }
        .side-link:hover { background:#F1F5EF; color:var(--forest); }
        .side-link.active { background:var(--forest); color:white; }
        .sidebar-foot { margin-top:30px; padding:22px 12px 0; border-top:1px solid var(--line); color:var(--muted); font-size:11px; line-height:1.7; }
        .content { min-width:0; width:min(1320px,100%); padding:44px clamp(20px,4vw,64px) 90px; margin:0 auto; }
        .topbar { display:flex; align-items:flex-start; justify-content:space-between; gap:20px; margin-bottom:36px; }
        .eyebrow { font-size:10px; font-weight:800; letter-spacing:.18em; color:#607666; text-transform:uppercase; }
        h1,h2,h3,p { margin-top:0; }
        h1 { margin:9px 0 8px; font:400 clamp(49px,6vw,76px)/.94 'Bebas Neue',sans-serif; letter-spacing:.01em; color:var(--forest); }
        .intro { max-width:620px; font-size:12px; color:var(--muted); line-height:1.85; margin:0; }
        .outline-btn { display:inline-flex; align-items:center; gap:8px; white-space:nowrap; border:1px solid #CAD9CC; padding:10px 15px; border-radius:100px; background:#FFF; font-size:11px; font-weight:800; color:var(--forest); }
        .outline-btn:hover { background:#EDF3ED; }
        .notice { padding:14px 17px; margin:0 0 20px; border-radius:10px; background:#E6EFE6; border:1px solid #BAD5C2; color:var(--forest); font-size:12px; }
        .notice.error { background:#FFF0EF; border-color:#EBC2BD; color:#973C31; }
        .notice ul { margin:8px 0 0; padding-left:20px; }
        .tabs { display:flex; gap:8px; overflow-x:auto; margin-bottom:25px; padding-bottom:9px; scrollbar-width:thin; }
        .tab { display:inline-flex; align-items:center; gap:8px; flex:none; padding:11px 16px; border-radius:100px; background:white; border:1px solid #DAE4D9; font-size:11px; font-weight:800; color:#607266; }
        .tab.active { color:white; background:var(--forest); border-color:var(--forest); }
        .tab-count { display:inline-grid; place-items:center; min-width:21px; height:21px; padding-inline:5px; border-radius:100px; background:rgba(0,0,0,.05); font-size:10px; }
        .tab.active .tab-count { background:rgba(255,255,255,.18); }
        .summary { display:grid; grid-template-columns:repeat(3,minmax(0,1fr)); border:1px solid var(--line); border-radius:15px; overflow:hidden; background:#FFF; margin-bottom:26px; }
        .summary-item { padding:23px 26px; border-right:1px solid var(--line); }
        .summary-item:last-child { border-right:0; }
        .summary-item strong { display:block; font:400 42px/1 'Bebas Neue',sans-serif; color:var(--forest); }
        .summary-item span { display:block; font-size:11px; color:var(--muted); margin-top:4px; }
        .columns { display:grid; grid-template-columns:minmax(0,1.04fr) minmax(0,.96fr); gap:20px; align-items:start; }
        .panel { background:white; border:1px solid var(--line); border-radius:16px; padding:26px; min-width:0; }
        .panel-head { border-bottom:1px solid #E8EDE7; padding-bottom:19px; margin-bottom:23px; }
        .panel-head h2 { color:var(--forest); margin:0 0 6px; font-size:19px; letter-spacing:-.045em; }
        .panel-head p { font-size:11px; color:var(--muted); line-height:1.7; margin:0; }
        .fields { display:grid; grid-template-columns:repeat(2,minmax(0,1fr)); gap:15px; }
        .field { min-width:0; }
        .wide { grid-column:1/-1; }
        .field label { display:block; margin-bottom:7px; font-size:11px; font-weight:800; color:#3C5746; }
        .field input, .field select, .field textarea { display:block; width:100%; min-width:0; border:1px solid #DCE5DB; border-radius:9px; padding:11px 12px; background:#FBFCFA; font-size:12px; color:var(--ink); outline:none; }
        .field input:focus, .field select:focus, .field textarea:focus { border-color:var(--forest); box-shadow:0 0 0 3px rgba(24,60,47,.09); }
        .hint { color:#7A897F; margin:7px 0 0; font-size:10px; line-height:1.65; }
        .check-row { display:flex; gap:9px; align-items:flex-start; font-size:11px; font-weight:700; color:#46604F; }
        .check-row input { margin:3px 0 0; accent-color:var(--forest); }
        .btn { display:inline-flex; align-items:center; justify-content:center; gap:8px; border-radius:9px; padding:11px 16px; font-size:11px; font-weight:800; border:1px solid transparent; }
        .btn.primary { background:var(--forest); color:#FFF; }
        .btn.primary:hover { background:#255741; }
        .btn.ghost { background:#FFF; color:#6C3D36; border-color:#E8CDC9; }
        .btn.ghost:hover { background:#FFF4F2; }
        .actions { margin-top:20px; display:flex; flex-wrap:wrap; gap:9px; }
        .entry-list { display:grid; gap:9px; }
        .entry { background:#FBFCFA; border:1px solid #E3E9E1; border-radius:11px; }
        .entry[open] { background:#FFF; border-color:#C7D6C8; }
        .entry summary { list-style:none; cursor:pointer; display:flex; align-items:center; gap:13px; padding:16px; }
        .entry summary::-webkit-details-marker { display:none; }
        .entry-marker { display:grid; place-items:center; flex:none; width:35px; height:35px; border-radius:8px; background:#EAF0E8; color:var(--forest); font:400 20px 'Bebas Neue',sans-serif; }
        .entry-summary { flex:1; min-width:0; }
        .entry-summary strong { display:block; font-size:12px; color:#20392A; overflow-wrap:anywhere; }
        .entry-summary small { display:block; font-size:10px; color:var(--muted); margin-top:3px; line-height:1.6; overflow-wrap:anywhere; }
        .edit-icon { font-size:18px; color:#758477; }
        .entry-content { padding:19px; border-top:1px solid #E4EAE2; }
        .empty { font-size:12px; color:var(--muted); line-height:1.8; padding:26px 0; }
        .info-note { font-size:10px; color:var(--muted); line-height:1.8; margin:17px 0 0; }
        .demo-note { margin:0 0 20px; padding:14px 16px; border-left:3px solid var(--forest); background:#EAEFE8; color:#465B4C; font-size:11px; line-height:1.75; }
        @media (max-width:1080px) { .layout{ grid-template-columns:190px minmax(0,1fr); } .columns{ grid-template-columns:1fr; } }
        @media (max-width:760px) {
            .layout{ display:block; }
            .sidebar{ padding:15px; border-right:0; border-bottom:1px solid var(--line); }
            .brand{ padding:0; border:0; margin:0 0 12px; }
            .nav-label,.sidebar-foot{ display:none; }
            .side-links{ display:flex; overflow-x:auto; gap:7px; }
            .side-link{ white-space:nowrap; padding:9px 12px; }
            .side-link span{ display:none; }
            .content{ padding:29px 16px 70px; }
            .topbar{ flex-direction:column; }
            .summary-item{ padding:15px 13px; }
            .summary-item strong{ font-size:33px; }
            .summary-item span{ font-size:9px; }
        }
        @media (max-width:470px) { .fields{ grid-template-columns:1fr; } .panel{ padding:18px; } }
    </style>
</head>
<body>
<div class="layout">
    <aside class="sidebar" aria-label="Navigasi admin">
        <a class="brand" href="{{ route('admin.dashboard') }}">
            <span class="brand-mark">NU</span>
            <span><strong>NU LESMANA</strong><small>ADMIN PANEL</small></span>
        </a>
        <div class="nav-label">MENU PENGELOLAAN</div>
        <nav class="side-links">
            <a class="side-link" href="{{ route('admin.dashboard') }}"><i class="ph ph-squares-four" aria-hidden="true"></i><span>Dashboard</span></a>
            <a class="side-link" href="{{ route('admin.members.index') }}"><i class="ph ph-users-three" aria-hidden="true"></i><span>Anggota</span></a>
            <a class="side-link active" href="{{ route('admin.struktur.index') }}" aria-current="page"><i class="ph ph-tree-structure" aria-hidden="true"></i><span>Struktur Organisasi</span></a>
            <a class="side-link" href="{{ route('admin.news.index') }}"><i class="ph ph-newspaper" aria-hidden="true"></i><span>Berita</span></a>
            <a class="side-link" href="{{ route('admin.infaq.index') }}"><i class="ph ph-wallet" aria-hidden="true"></i><span>Infaq / Kas</span></a>
            <a class="side-link" href="{{ route('home') }}"><i class="ph ph-arrow-up-right" aria-hidden="true"></i><span>Website Publik</span></a>
        </nav>
        <p class="sidebar-foot">Perubahan struktur tersimpan di database dan langsung dipakai halaman publik.</p>
    </aside>

    <main class="content">
        <header class="topbar">
            <div>
                <div class="eyebrow">PANEL ADMIN <span aria-hidden="true">/</span> ORGANISASI</div>
                <h1>KELOLA STRUKTUR.</h1>
                <p class="intro">Ubah data contoh menjadi nama pengurus yang sebenarnya, atur jabatan, atau tambahkan posisi baru. Seluruh perubahan terlihat di halaman publik.</p>
            </div>
            <a class="outline-btn" href="{{ route('struktur.banom') }}" target="_blank" rel="noopener noreferrer">
                <i class="ph ph-arrow-square-out" aria-hidden="true"></i> LIHAT PUBLIK
            </a>
        </header>

        @if (session('success'))
            <div class="notice" role="status">{{ session('success') }}</div>
        @endif
        @if (session('error'))
            <div class="notice error" role="alert">{{ session('error') }}</div>
        @endif
        @if ($errors->any())
            <div class="notice error" role="alert">
                <strong>Periksa data berikut:</strong>
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <nav class="tabs" aria-label="Pilih Badan Otonom">
            @foreach ($banomLabels as $key => $label)
                <a href="{{ route('admin.struktur.index', ['banom' => $key]) }}"
                   class="tab {{ $selected === $key ? 'active' : '' }}"
                   @if ($selected === $key) aria-current="page" @endif>
                    {{ $label }} <span class="tab-count">{{ $counts[$key] }}</span>
                </a>
            @endforeach
        </nav>

        <section class="summary" aria-label="Ringkasan Banom terpilih">
            <div class="summary-item"><strong>{{ $positions->count() }}</strong><span>Total jabatan</span></div>
            <div class="summary-item"><strong>{{ $positions->where('is_visible', 1)->count() }}</strong><span>Jabatan tampil di publik</span></div>
            <div class="summary-item"><strong>{{ $counts[$selected] }}</strong><span>Anggota terverifikasi</span></div>
        </section>

        <p class="demo-note">
            <strong>Catatan data contoh:</strong> nama berawalan “Contoh” adalah placeholder.
            Untuk menetapkan pengurus asli, buka jabatannya dan ganti nama manual atau pilih anggota ACC.
            Data struktur tidak mengubah NIA atau jumlah anggota.
        </p>

        <div class="columns">
            <section class="panel" aria-labelledby="tambah-heading">
                <div class="panel-head">
                    <h2 id="tambah-heading">Tambah jabatan</h2>
                    <p>Gunakan untuk posisi yang belum tersedia. Jika jabatan sudah ada, edit lewat daftar sebelah.</p>
                </div>
                <form method="POST" action="{{ route('admin.struktur.store') }}">
                    @csrf
                    <input type="hidden" name="banom" value="{{ $selected }}">
                    <div class="fields">
                        <div class="field wide">
                            <label for="new-role">Nama jabatan *</label>
                            <input id="new-role" type="text" name="role" value="{{ old('role') }}" placeholder="Contoh: Ketua" maxlength="100" required>
                        </div>
                        <div class="field wide">
                            <label for="new-member">Pilih akun anggota yang sudah ACC</label>
                            <select id="new-member" name="member_id">
                                <option value="">Tidak memilih anggota (gunakan nama manual)</option>
                                @foreach ($members as $member)
                                    <option value="{{ $member->id }}" @selected((string) old('member_id') === (string) $member->id)>{{ $member->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="field wide">
                            <label for="new-person">Nama manual *</label>
                            <input id="new-person" type="text" name="person_name" value="{{ old('person_name') }}" maxlength="120" placeholder="Isi jika tidak memilih akun anggota">
                            <p class="hint">Wajib jika tidak memilih anggota ACC. Tidak membuat akun atau NIA baru.</p>
                        </div>
                        <div class="field wide">
                            <label for="new-description">Keterangan (opsional)</label>
                            <input id="new-description" type="text" name="description" value="{{ old('description') }}" maxlength="180" placeholder="Misalnya: Masa khidmat 2026–2028">
                        </div>
                        <div class="field">
                            <label for="new-level">Tingkat</label>
                            <select id="new-level" name="level">
                                <option value="1" @selected(old('level', '2') == '1')>1 — Pimpinan</option>
                                <option value="2" @selected(old('level', '2') == '2')>2 — Pengurus harian</option>
                                <option value="3" @selected(old('level', '2') == '3')>3 — Bidang</option>
                            </select>
                        </div>
                        <div class="field">
                            <label for="new-order">Urutan</label>
                            <input id="new-order" type="number" name="sort_order" value="{{ old('sort_order', 1) }}" min="0" max="999" required>
                        </div>
                        <div class="field wide">
                            <input type="hidden" name="is_visible" value="0">
                            <label class="check-row"><input type="checkbox" name="is_visible" value="1" @checked(old('is_visible', '1') == '1')> Tampilkan posisi di halaman publik</label>
                        </div>
                    </div>
                    <div class="actions">
                        <button type="submit" class="btn primary"><i class="ph ph-plus" aria-hidden="true"></i> TAMBAH JABATAN</button>
                    </div>
                </form>
            </section>

            <section class="panel" aria-labelledby="daftar-heading">
                <div class="panel-head">
                    <h2 id="daftar-heading">Susunan pengurus</h2>
                    <p>Klik jabatan untuk mengganti nama, anggota, tingkatan, atau visibilitas.</p>
                </div>

                <div class="entry-list">
                    @forelse ($positions as $position)
                        <details class="entry">
                            <summary>
                                <span class="entry-marker">{{ str_pad((string) $loop->iteration, 2, '0', STR_PAD_LEFT) }}</span>
                                <span class="entry-summary">
                                    <strong>{{ $position->role }}</strong>
                                    <small>{{ $position->member_name ?: $position->person_name }} · Tingkat {{ $position->level }} @if (!$position->is_visible) · Disembunyikan @endif</small>
                                </span>
                                <i class="ph ph-pencil-simple edit-icon" aria-hidden="true"></i>
                            </summary>
                            <div class="entry-content">
                                <form method="POST" action="{{ route('admin.struktur.update', $position->id) }}">
                                    @csrf
                                    @method('PUT')
                                    <input type="hidden" name="banom" value="{{ $selected }}">
                                    <div class="fields">
                                        <div class="field wide">
                                            <label for="role-{{ $position->id }}">Jabatan</label>
                                            <input id="role-{{ $position->id }}" name="role" type="text" value="{{ $position->role }}" maxlength="100" required>
                                        </div>
                                        <div class="field wide">
                                            <label for="member-{{ $position->id }}">Anggota ACC (opsional)</label>
                                            <select id="member-{{ $position->id }}" name="member_id">
                                                <option value="">Pakai nama manual</option>
                                                @foreach ($members as $member)
                                                    <option value="{{ $member->id }}" @selected((string) $position->member_id === (string) $member->id)>{{ $member->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="field wide">
                                            <label for="person-{{ $position->id }}">Nama manual</label>
                                            <input id="person-{{ $position->id }}" name="person_name" type="text" value="{{ $position->person_name }}" maxlength="120" placeholder="Wajib kalau tidak memilih anggota ACC">
                                        </div>
                                        <div class="field wide">
                                            <label for="description-{{ $position->id }}">Keterangan</label>
                                            <input id="description-{{ $position->id }}" name="description" type="text" value="{{ $position->description }}" maxlength="180">
                                        </div>
                                        <div class="field">
                                            <label for="level-{{ $position->id }}">Tingkat</label>
                                            <select id="level-{{ $position->id }}" name="level">
                                                <option value="1" @selected((int) $position->level === 1)>1 — Pimpinan</option>
                                                <option value="2" @selected((int) $position->level === 2)>2 — Pengurus harian</option>
                                                <option value="3" @selected((int) $position->level === 3)>3 — Bidang</option>
                                            </select>
                                        </div>
                                        <div class="field">
                                            <label for="order-{{ $position->id }}">Urutan</label>
                                            <input id="order-{{ $position->id }}" name="sort_order" type="number" value="{{ $position->sort_order }}" min="0" max="999" required>
                                        </div>
                                        <div class="field wide">
                                            <input type="hidden" name="is_visible" value="0">
                                            <label class="check-row"><input type="checkbox" name="is_visible" value="1" @checked((bool) $position->is_visible)> Tampilkan di publik</label>
                                        </div>
                                    </div>
                                    <div class="actions"><button class="btn primary" type="submit">SIMPAN PERUBAHAN</button></div>
                                </form>
                                <form method="POST" action="{{ route('admin.struktur.destroy', $position->id) }}" onsubmit="return confirm('Hapus jabatan ini? Data anggota tidak akan dihapus.')">
                                    @csrf
                                    @method('DELETE')
                                    <div class="actions"><button type="submit" class="btn ghost">HAPUS JABATAN</button></div>
                                </form>
                            </div>
                        </details>
                    @empty
                        <p class="empty">Belum ada jabatan untuk Banom ini. Tambahkan lewat formulir di sebelah kiri, atau jalankan seeder awal satu kali.</p>
                    @endforelse
                </div>
                <p class="info-note">Setelah klik Simpan, buka “Lihat Publik” untuk memastikan nama dan urutannya sudah sesuai.</p>
            </section>
        </div>
    </main>
</div>
</body>
</html>
