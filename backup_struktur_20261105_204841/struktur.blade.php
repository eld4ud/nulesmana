<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kelola Struktur Organisasi | NU Lesmana</title>
    <link href="https://fonts.googleapis.com/css2?family=Bebas+Neue&family=DM+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <script src="https://unpkg.com/@phosphor-icons/web"></script>
    <style>
        :root{--green:#183C2F;--ivory:#F5F4F0;--muted:#718275;--line:#DDE6DA;--gold:#B69B68}
        *,*::before,*::after{box-sizing:border-box}body{margin:0;font-family:'DM Sans',Arial,sans-serif;color:#20372A;background:var(--ivory)}
        a{color:inherit;text-decoration:none}button,input,select,textarea{font:inherit}button{cursor:pointer}
        .ad-layout{display:grid;grid-template-columns:250px minmax(0,1fr);min-height:100vh}
        .ad-sidebar{background:white;border-right:1px solid var(--line);padding:32px 18px}
        .ad-brand{display:block;padding:4px 12px 25px;font:400 32px/1 'Bebas Neue',Impact,sans-serif;color:var(--green)}
        .ad-brand span{display:block;margin-top:7px;font:800 9px 'DM Sans',sans-serif;letter-spacing:.17em;color:var(--muted)}
        .ad-menu{display:flex;flex-direction:column;gap:4px}
        .ad-link{display:flex;align-items:center;gap:11px;padding:13px;border-radius:11px;font-size:12px;font-weight:750;color:#4B6353;white-space:nowrap}
        .ad-link:hover{background:#F1F5EF}.ad-link.is-active{background:var(--green);color:white}
        .ad-link i{font-size:19px}.ad-main{max-width:1330px;width:100%;min-width:0;margin:auto;padding:42px 50px 80px}
        .ad-kicker{margin:0;color:#73907A;font-size:10px;font-weight:800;letter-spacing:.17em;text-transform:uppercase}
        .ad-header{display:flex;align-items:end;justify-content:space-between;gap:25px;margin-bottom:29px}
        .ad-title{font:400 clamp(46px,5vw,68px)/.93 'Bebas Neue',Impact,sans-serif;margin:12px 0 13px;letter-spacing:.012em;color:var(--green)}
        .ad-desc{font-size:13px;line-height:1.75;color:var(--muted);max-width:580px;margin:0}
        .ad-outline{display:inline-flex;gap:9px;align-items:center;border:1px solid #C8D8CB;border-radius:999px;padding:12px 19px;font-size:12px;font-weight:800;white-space:nowrap}
        .ad-outline:hover{background:#E9F0E8}
        .ad-tabs{display:flex;gap:8px;overflow-x:auto;padding-bottom:14px;scrollbar-width:thin;margin-bottom:22px}
        .ad-tab{flex-shrink:0;padding:12px 17px;border:1px solid #D4DFD3;border-radius:999px;font-size:12px;font-weight:750;background:white;color:var(--green)}
        .ad-tab.is-active{color:white;background:var(--green);border-color:var(--green)}
        .ad-panel{background:white;border:1px solid var(--line);border-radius:21px;padding:27px;margin-bottom:25px}
        .ad-panel-top{display:flex;align-items:start;justify-content:space-between;gap:15px;padding-bottom:20px;border-bottom:1px solid var(--line);margin-bottom:23px}
        .ad-panel h2{font-size:20px;letter-spacing:-.035em;color:var(--green);margin:0 0 8px}
        .ad-panel-note{font-size:12px;color:var(--muted);line-height:1.7;margin:0}
        .ad-number{font:400 42px/.9 'Bebas Neue',Impact,sans-serif;color:var(--green);text-align:right;min-width:55px}
        .ad-number small{display:block;font:800 10px 'DM Sans',Arial,sans-serif;text-transform:uppercase;color:var(--muted);margin-top:6px;white-space:nowrap}
        .ad-fields{display:grid;grid-template-columns:repeat(2,minmax(0,1fr));gap:19px}
        .ad-field.wide{grid-column:1/-1}
        .ad-field label{display:block;font-size:12px;font-weight:800;margin-bottom:8px;color:#375944}
        .ad-field input,.ad-field select,.ad-field textarea{width:100%;background:#F8FAF7;border:1px solid #D7E1D5;border-radius:11px;color:#21412E;padding:12px 14px;font-size:13px;line-height:1.5}
        .ad-field input:focus,.ad-field select:focus,.ad-field textarea:focus{outline:2px solid #92B8A0;outline-offset:1px}
        .ad-field input[type=file]{padding:10px;background:white}
        .ad-field small{display:block;color:var(--muted);font-size:11px;line-height:1.6;margin-top:6px}
        .ad-check{display:flex!important;gap:11px;align-items:center;font-size:12px;font-weight:750}
        .ad-check input{width:18px!important;height:18px;accent-color:var(--green);flex-shrink:0}
        .ad-actions{display:flex;flex-wrap:wrap;align-items:center;gap:12px;margin-top:21px}
        .ad-btn{display:inline-flex;align-items:center;justify-content:center;gap:8px;border-radius:999px;padding:12px 20px;font-weight:800;font-size:12px;border:1px solid #D2DED1;background:#fff;color:var(--green)}
        .ad-btn.primary{background:var(--green);color:white;border-color:var(--green)}
        .ad-btn.primary:hover{background:#2C5943}.ad-btn.danger{color:#A43B36;border-color:#E4CECC}
        .ad-notice{padding:15px 19px;border:1px solid #BBD3BF;background:#ECF6EB;border-radius:13px;margin-bottom:19px;font-size:13px;line-height:1.6}
        .ad-notice.error{background:#FFF1F0;color:#9C3F35;border-color:#F0C9C5}
        .ad-list{display:grid;gap:12px}
        .ad-entry{border:1px solid var(--line);border-radius:14px;overflow:hidden;background:#FCFDFC}
        .ad-entry[open]{border-color:#BDCFBE}
        .ad-entry summary{display:flex;align-items:center;gap:15px;padding:16px 18px;cursor:pointer;list-style:none}
        .ad-entry summary::-webkit-details-marker{display:none}
        .ad-avatar{width:62px;height:62px;display:grid;place-items:center;border:1px solid #D8E4D7;border-radius:13px;background:#E4EFE5;flex-shrink:0;overflow:hidden;color:#38694B;font:400 30px 'Bebas Neue',Impact,sans-serif}
        .ad-avatar img{display:block;width:100%;height:100%;object-fit:cover}
        .ad-entry-summary{min-width:0;flex:1}
        .ad-entry-title{font-size:14px;font-weight:800;color:var(--green);overflow-wrap:anywhere}
        .ad-entry-sub{font-size:12px;color:var(--muted);line-height:1.55;margin-top:4px}
        .ad-badge{font-size:10px;border:1px solid #C9D9CA;border-radius:999px;color:#55745D;padding:6px 10px;white-space:nowrap}
        .ad-badge.hidden{background:#FFF0E8;color:#A96437;border-color:#F1D9C8}
        .ad-entry-content{border-top:1px solid var(--line);padding:24px 19px}
        .ad-photo-current{display:flex;align-items:center;gap:14px;background:#F4F8F2;border:1px solid #E3EAE1;border-radius:12px;padding:11px 14px;margin-bottom:18px}
        .ad-photo-current p{font-size:12px;color:var(--muted);line-height:1.6;margin:0}
        .ad-photo-current strong{color:var(--green)}
        .ad-empty{padding:39px 12px;text-align:center;color:var(--muted);font-size:13px;line-height:1.7}
        .ad-warning{font-size:11px;color:#7A897D;line-height:1.65;margin-top:21px}
        @media(max-width:930px){.ad-layout{grid-template-columns:1fr}.ad-sidebar{padding:18px;border-right:0;border-bottom:1px solid var(--line)}.ad-brand{padding:0 5px 14px}.ad-menu{flex-direction:row;overflow-x:auto}.ad-main{padding:30px 20px 60px}}
        @media(max-width:610px){.ad-header{flex-direction:column;align-items:start}.ad-title{font-size:54px}.ad-fields{grid-template-columns:1fr}.ad-panel{padding:20px 16px}.ad-entry summary{gap:10px;padding:12px}.ad-avatar{width:50px;height:50px}.ad-badge{display:none}.ad-photo-current{align-items:start}}
    </style>
</head>
<body>
<div class="ad-layout">
    <aside class="ad-sidebar">
        <a href="{{ route('admin.dashboard') }}" class="ad-brand">NU LESMANA<span>PANEL PENGURUS</span></a>
        <nav class="ad-menu" aria-label="Navigasi admin">
            <a href="{{ route('admin.dashboard') }}" class="ad-link"><i class="ph ph-squares-four"></i> Dashboard</a>
            @if(\Illuminate\Support\Facades\Route::has('admin.members.index'))
                <a href="{{ route('admin.members.index') }}" class="ad-link"><i class="ph ph-users-three"></i> Kelola Anggota</a>
            @endif
            <a href="{{ route('admin.struktur.index') }}" class="ad-link is-active"><i class="ph ph-tree-structure"></i> Struktur Organisasi</a>
            @if(\Illuminate\Support\Facades\Route::has('admin.news.index'))
                <a href="{{ route('admin.news.index') }}" class="ad-link"><i class="ph ph-newspaper"></i> Kelola Berita</a>
            @endif
            <a href="{{ route('home') }}" class="ad-link"><i class="ph ph-arrow-up-right"></i> Website Utama</a>
        </nav>
    </aside>
    <main class="ad-main">
        <header class="ad-header">
            <div>
                <p class="ad-kicker">Admin / Manajemen Pengurus</p>
                <h1 class="ad-title">KELOLA STRUKTUR ORGANISASI.</h1>
                <p class="ad-desc">Atur jabatan, nama, foto pengurus, tingkat piramida, dan urutan tampilan untuk setiap badan otonom.</p>
            </div>
            <a class="ad-outline" href="{{ route('struktur.banom') }}" target="_blank" rel="noopener noreferrer">Lihat Halaman Publik <i class="ph ph-arrow-up-right"></i></a>
        </header>
        @if(session('success'))<div class="ad-notice" role="status">{{ session('success') }}</div>@endif
        @if($errors->any())
            <div class="ad-notice error" role="alert"><strong>Periksa kembali formulir:</strong>
                <ul style="margin:8px 0 0;padding-left:21px">@foreach($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul>
            </div>
        @endif
        <nav class="ad-tabs" aria-label="Pilih Banom">
            @foreach($banomLabels as $key => $label)
                <a href="{{ route('admin.struktur.index', ['banom' => $key]) }}"
                    class="ad-tab {{ $selected === $key ? 'is-active' : '' }}" @if($selected === $key) aria-current="page" @endif>
                    {{ $label }}
                </a>
            @endforeach
        </nav>
        <section class="ad-panel" aria-labelledby="ad-add-title">
            <div class="ad-panel-top">
                <div>
                    <h2 id="ad-add-title">Tambah Pengurus · {{ $banomLabels[$selected] }}</h2>
                    <p class="ad-panel-note">Pilih anggota yang sudah ACC atau masukkan nama manual. Foto boleh kosong.</p>
                </div>
                <div class="ad-number">{{ $counts[$selected] }}<small>Anggota ACC</small></div>
            </div>
            <form action="{{ route('admin.struktur.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="banom" value="{{ $selected }}">
                <div class="ad-fields">
                    <div class="ad-field"><label for="add-role">Jabatan</label><input id="add-role" name="role" maxlength="100" value="{{ old('role') }}" placeholder="Contoh: Ketua" required></div>
                    <div class="ad-field"><label for="add-member">Ambil dari Anggota ACC (opsional)</label>
                        <select id="add-member" name="member_id"><option value="">Gunakan nama manual</option>
                            @foreach($members as $member)<option value="{{ $member->id }}" @selected(old('member_id') == $member->id)>{{ $member->name }}</option>@endforeach
                        </select>
                    </div>
                    <div class="ad-field"><label for="add-name">Nama Manual</label><input id="add-name" name="person_name" maxlength="120" value="{{ old('person_name') }}" placeholder="Isi bila tidak memilih anggota"><small>Nama ini dipublikasikan sesuai jabatan. Jika memilih anggota ACC, sistem menggunakan nama anggotanya.</small></div>
                    <div class="ad-field"><label for="add-desc">Keterangan (opsional)</label><input id="add-desc" name="description" maxlength="180" value="{{ old('description') }}" placeholder="Contoh: Administrasi & koordinasi"></div>
                    <div class="ad-field"><label for="add-level">Tingkat Piramida</label>
                        <select id="add-level" name="level" required>
                            @foreach([1 => '01 · Pimpinan (atas)', 2 => '02 · Pengurus Inti (tengah)', 3 => '03 · Bidang & Program (bawah)'] as $level => $label)
                                <option value="{{ $level }}" @selected((int)old('level', 2) === $level)>{{ $label }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="ad-field"><label for="add-order">Urutan dalam Tingkat</label><input id="add-order" type="number" name="sort_order" min="0" max="999" value="{{ old('sort_order', 0) }}" required><small>Angka kecil ditampilkan terlebih dahulu.</small></div>
                    <div class="ad-field wide"><label for="add-photo">Foto Pengurus (opsional)</label><input id="add-photo" type="file" name="photo" accept=".jpg,.jpeg,.png,.webp,image/jpeg,image/png,image/webp"><small>JPG / PNG / WEBP, maksimal 2 MB. Gunakan foto dengan izin pemiliknya.</small></div>
                    <div class="ad-field wide"><input type="hidden" name="is_visible" value="0"><label class="ad-check"><input type="checkbox" name="is_visible" value="1" @checked((int)old('is_visible', 1) === 1)>Tampilkan jabatan pada halaman publik</label></div>
                </div>
                <div class="ad-actions"><button class="ad-btn primary" type="submit"><i class="ph ph-plus"></i> Tambah Pengurus</button></div>
            </form>
        </section>
        <section class="ad-panel" aria-labelledby="ad-edit-title">
            <div class="ad-panel-top">
                <div><h2 id="ad-edit-title">Daftar Pengurus</h2><p class="ad-panel-note">Klik salah satu jabatan untuk mengedit nama, foto, level, urutan, atau status tampil.</p></div>
                <div class="ad-number">{{ $positions->count() }}<small>Jabatan</small></div>
            </div>
            <div class="ad-list">
                @forelse($positions as $position)
                    <details class="ad-entry">
                        <summary>
                            <div class="ad-avatar">
                                @if($position->photo_url)<img src="{{ $position->photo_url }}" alt="Foto pengurus">@else{{ mb_strtoupper(mb_substr($position->display_name,0,1)) }}@endif
                            </div>
                            <div class="ad-entry-summary">
                                <div class="ad-entry-title">{{ $position->role }} · {{ $position->display_name }}</div>
                                <div class="ad-entry-sub">Tingkat {{ $position->level }} · Urutan {{ $position->sort_order }} · {{ $position->photo_url ? 'Foto terpasang' : 'Belum ada foto' }}</div>
                            </div>
                            <span class="ad-badge {{ !$position->is_visible ? 'hidden' : '' }}">{{ $position->is_visible ? 'Publik' : 'Tersembunyi' }}</span>
                            <i class="ph ph-caret-down" aria-hidden="true"></i>
                        </summary>
                        <div class="ad-entry-content">
                            <div class="ad-photo-current">
                                <div class="ad-avatar">
                                    @if($position->photo_url)<img src="{{ $position->photo_url }}" alt="Foto tersimpan">@else{{ mb_strtoupper(mb_substr($position->display_name,0,1)) }}@endif
                                </div>
                                <p><strong>Foto yang sedang aktif</strong><br>{{ $position->photo_url ? 'Unggah foto baru di bawah untuk menggantinya.' : 'Belum ada foto untuk jabatan ini.' }}</p>
                            </div>
                            <form action="{{ route('admin.struktur.update', $position->id) }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                @method('PUT')
                                <input type="hidden" name="banom" value="{{ $selected }}">
                                <div class="ad-fields">
                                    <div class="ad-field"><label for="role-{{ $position->id }}">Jabatan</label><input id="role-{{ $position->id }}" name="role" maxlength="100" required value="{{ $position->role }}"></div>
                                    <div class="ad-field"><label for="member-{{ $position->id }}">Anggota ACC</label>
                                        <select id="member-{{ $position->id }}" name="member_id"><option value="">Gunakan nama manual</option>
                                            @foreach($members as $member)<option value="{{ $member->id }}" @selected((int)$position->member_id === (int)$member->id)>{{ $member->name }}</option>@endforeach
                                        </select>
                                    </div>
                                    <div class="ad-field"><label for="name-{{ $position->id }}">Nama Manual</label><input id="name-{{ $position->id }}" name="person_name" value="{{ $position->person_name }}" maxlength="120" placeholder="Isi bila tidak memilih anggota"></div>
                                    <div class="ad-field"><label for="desc-{{ $position->id }}">Keterangan</label><input id="desc-{{ $position->id }}" name="description" value="{{ $position->description }}" maxlength="180"></div>
                                    <div class="ad-field"><label for="level-{{ $position->id }}">Tingkat Piramida</label>
                                        <select id="level-{{ $position->id }}" name="level" required>
                                            @foreach([1 => '01 · Pimpinan', 2 => '02 · Pengurus Inti', 3 => '03 · Bidang & Program'] as $level => $label)
                                                <option value="{{ $level }}" @selected((int)$position->level === $level)>{{ $label }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="ad-field"><label for="order-{{ $position->id }}">Urutan</label><input id="order-{{ $position->id }}" type="number" name="sort_order" value="{{ $position->sort_order }}" min="0" max="999" required></div>
                                    <div class="ad-field wide"><label for="photo-{{ $position->id }}">Ganti / Tambah Foto</label><input id="photo-{{ $position->id }}" type="file" name="photo" accept=".jpg,.jpeg,.png,.webp,image/jpeg,image/png,image/webp"><small>Maksimal 2 MB. Kosongkan bila ingin mempertahankan foto saat ini.</small></div>
                                    @if($position->photo_url)
                                        <div class="ad-field wide"><label class="ad-check"><input type="checkbox" name="remove_photo" value="1">Hapus foto yang terpasang (tanpa menghapus jabatan)</label></div>
                                    @endif
                                    <div class="ad-field wide"><input type="hidden" name="is_visible" value="0"><label class="ad-check"><input type="checkbox" name="is_visible" value="1" @checked((bool)$position->is_visible)>Tampilkan pada halaman publik</label></div>
                                </div>
                                <div class="ad-actions"><button type="submit" class="ad-btn primary"><i class="ph ph-floppy-disk"></i> Simpan Perubahan</button></div>
                            </form>
                            <form method="POST" action="{{ route('admin.struktur.destroy', $position->id) }}" onsubmit="return confirm('Hapus jabatan dan fotonya? Data anggota tidak akan terhapus.');">
                                @csrf
                                @method('DELETE')
                                <div class="ad-actions"><button type="submit" class="ad-btn danger"><i class="ph ph-trash"></i> Hapus Jabatan</button></div>
                            </form>
                        </div>
                    </details>
                @empty
                    <div class="ad-empty">Belum ada jabatan pada Banom ini. Isi formulir Tambah Pengurus untuk membuat bagan pertama.</div>
                @endforelse
            </div>
            <p class="ad-warning">Catatan: tabel organisasi tidak diubah. Foto disimpan pada disk public Laravel menggunakan ID jabatan, bukan di kolom foto database. Publikasikan foto hanya dengan persetujuan orang yang bersangkutan.</p>
        </section>
    </main>
</div>
</body>
</html>
