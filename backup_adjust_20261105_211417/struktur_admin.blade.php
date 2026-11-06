<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Kelola Struktur | NU Lesmana</title>
    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">
    <script src="https://unpkg.com/@phosphor-icons/web"></script>
    <style>
        :root{--forest:#183C2F;--forest2:#285440;--ivory:#F6F7F3;--ink:#1D392B;--muted:#718376;--line:#DFE5DC;--gold:#B79A60}
        *,*::before,*::after{box-sizing:border-box}
        html{scroll-behavior:smooth}
        body{margin:0;background:var(--ivory);color:var(--ink);font-family:'DM Sans',Arial,sans-serif;-webkit-font-smoothing:antialiased}
        body.dialog-open{overflow:hidden}
        button,input,select,textarea{font:inherit}
        button{cursor:pointer}
        a{color:inherit;text-decoration:none}
        a:focus-visible,button:focus-visible,input:focus-visible,select:focus-visible,textarea:focus-visible,summary:focus-visible{outline:3px solid #91BB9C;outline-offset:3px}
        [hidden]{display:none!important}
        .layout{display:grid;grid-template-columns:253px minmax(0,1fr);min-height:100vh}
        .sidebar{border-right:1px solid var(--line);background:#FFFFFF;padding:27px 21px;position:sticky;top:0;align-self:start;min-height:100vh}
        .brand{display:flex;align-items:center;gap:12px;margin:0 8px 56px}
        .brand-mark{width:44px;height:44px;flex-shrink:0;display:grid;place-items:center;border-radius:12px;background:var(--forest);color:#FFFFFF;font-size:13px;font-weight:900;letter-spacing:-.04em}
        .brand-name{display:block;font-size:13px;font-weight:900;letter-spacing:-.045em;color:#143628}
        .brand-sub{display:block;font-size:9px;font-weight:800;letter-spacing:.11em;color:#91A295;margin-top:5px}
        .sidebar-label{padding:0 12px;margin:0 0 16px;font-size:10px;font-weight:850;letter-spacing:.19em;color:#9CAC9E}
        .nav{display:flex;flex-direction:column;gap:5px}
        .nav-link{display:flex;align-items:center;gap:11px;min-height:45px;padding:12px 14px;border-radius:11px;color:#4F6657;font-size:12px;font-weight:750;transition:background .2s,color .2s}
        .nav-link i{font-size:19px;flex-shrink:0}
        .nav-link:hover{background:#F1F4EF}.nav-link.active{background:var(--forest);color:#fff}
        .main{width:100%;min-width:0;max-width:1500px;margin-inline:auto;padding:40px clamp(24px,3.3vw,58px) 100px}
        .kicker{font-size:10px;letter-spacing:.17em;font-weight:850;text-transform:uppercase;color:#748E7C;margin:0 0 10px}
        .heading{display:flex;justify-content:space-between;align-items:end;gap:26px;margin-bottom:29px}
        .title{font-size:clamp(36px,4.25vw,58px);font-weight:850;line-height:1.06;letter-spacing:-.065em;color:#143829;margin:0 0 13px}
        .subtitle{color:var(--muted);font-size:13px;line-height:1.8;margin:0;max-width:690px}
        .link-public{display:inline-flex;align-items:center;justify-content:center;gap:9px;border-radius:999px;border:1px solid #C8D9CA;padding:12px 18px;font-size:12px;font-weight:800;white-space:nowrap;transition:background .2s}
        .link-public:hover{background:#E8EFE7}
        .notice{padding:14px 17px;border-radius:12px;margin-bottom:22px;background:#EDF5EB;border:1px solid #BDDAC1;color:#2F6940;font-size:13px;line-height:1.65}
        .notice.error{background:#FFF4ED;border-color:#E9CBB7;color:#8B452E}
        .notice ul{margin:8px 0 0;padding-left:22px}
        .tabs{display:flex;gap:8px;overflow-x:auto;scrollbar-width:thin;padding:0 0 15px;margin-bottom:23px}
        .tab{flex-shrink:0;border:1px solid #D6E1D4;border-radius:999px;background:#fff;color:#315441;padding:12px 17px;font-size:12px;font-weight:800}
        .tab:hover{background:#EEF4EB}.tab.active{background:var(--forest);border-color:var(--forest);color:#fff}
        .sheet{background:#fff;border:1px solid var(--line);border-radius:22px;padding:clamp(21px,3vw,38px)}
        .sheet-top{display:flex;align-items:start;justify-content:space-between;gap:20px;padding-bottom:24px;border-bottom:1px solid var(--line)}
        .sheet-title{font-size:clamp(23px,2.6vw,32px);font-weight:800;line-height:1.2;letter-spacing:-.045em;color:var(--forest);margin:0 0 9px}
        .sheet-sub{margin:0;font-size:12px;line-height:1.75;color:var(--muted)}
        .sheet-count{display:flex;flex-direction:column;align-items:flex-end;min-width:75px}
        .sheet-count strong{font-size:32px;font-weight:850;letter-spacing:-.07em;line-height:1;color:var(--forest)}
        .sheet-count span{color:#78907C;font-size:9px;text-transform:uppercase;letter-spacing:.12em;font-weight:850;margin-top:7px;white-space:nowrap}
        .pyramid{padding:29px 0 14px;max-width:1120px;margin:auto}
        .tier{position:relative;margin:0 auto 30px}
        .tier:last-child{margin-bottom:0}
        .tier:not(:first-child)::before{content:"";display:block;margin:-7px auto 13px;width:2px;height:30px;background:#ACC4B1}
        .tier-label{color:#819987;letter-spacing:.17em;font-size:10px;font-weight:850;text-transform:uppercase;margin:0 0 18px;display:flex;align-items:center;gap:13px}
        .tier-label::after{content:"";flex:1;height:1px;background:var(--line)}
        .tier-grid{display:flex;flex-wrap:wrap;gap:15px;justify-content:center}
        .tier-1 .tier-grid{max-width:350px;margin:auto}
        .tier-2 .tier-grid{max-width:830px;margin:auto}
        .tier-3 .tier-grid{max-width:1080px;margin:auto}
        .person{position:relative;display:flex;align-items:center;flex-direction:column;text-align:center;gap:8px;border:1px solid #DDE7DC;background:#FAFBF9;color:var(--forest);border-radius:17px;padding:23px 15px 18px;min-width:0;transition:transform .2s,border-color .2s,box-shadow .2s;cursor:pointer}
        .person:hover{transform:translateY(-3px);border-color:#89A994;box-shadow:0 13px 24px #153D2D16}
        .person:focus-visible{outline-offset:4px}
        .tier-1 .person{width:100%;background:var(--forest);color:#FFFFFF;border-color:var(--forest);box-shadow:0 12px 25px #173F2E21;padding:27px 16px 24px}
        .tier-2 .person{flex:0 1 calc((100% - 30px)/3);min-width:193px}
        .tier-3 .person{flex:0 1 calc((100% - 45px)/4);min-width:175px}
        .avatar{display:grid;place-items:center;flex-shrink:0;width:77px;height:77px;overflow:hidden;border:3px solid #D9E6D9;border-radius:50%;background:#D7E6DA;color:#426950;font-size:27px;font-weight:850}
        .avatar img{width:100%;height:100%;display:block;object-fit:cover;object-position:center 25%}
        .tier-1 .avatar{width:100px;height:100px;border-color:#A2BDAD}
        .person-role{font-size:10px;letter-spacing:.11em;font-weight:850;color:#78907D;text-transform:uppercase;margin-top:7px;overflow-wrap:anywhere}
        .tier-1 .person-role{color:#D0E1D4}
        .person-name{font-size:15px;font-weight:850;letter-spacing:-.035em;line-height:1.34;overflow-wrap:anywhere}
        .tier-1 .person-name{font-size:19px}
        .person-note{font-size:11px;line-height:1.5;color:#7B8F7E;overflow-wrap:anywhere;max-width:98%}
        .tier-1 .person-note{color:#CFDECE}
        .person-edit{display:inline-flex;align-items:center;gap:6px;margin-top:5px;font-size:10px;font-weight:850;letter-spacing:.02em;opacity:.9}
        .person-edit i{font-size:14px}
        .person-state{font-size:10px;padding:4px 8px;border-radius:999px;background:#E9F2E7;color:#4E7558;margin-top:3px;font-weight:850}
        .person-state.hidden{display:inline-flex!important;background:#FFF1E5;color:#A45D35}
        .tier-1 .person-state{background:#2F5C44;color:#D9E8DB}
        .tier-1 .person-state.hidden{background:#77573D;color:#FFFFFF}
        .pyramid-empty{margin:50px auto;padding:26px;text-align:center;color:#758777;font-size:13px;line-height:1.6}
        .pyramid-empty i{display:block;color:#71997C;font-size:38px;margin-bottom:11px}
        .sheet-footer{border-top:1px solid var(--line);margin-top:20px;padding-top:19px;display:flex;justify-content:space-between;align-items:center;gap:12px;flex-wrap:wrap}
        .sheet-footer span{font-size:11px;line-height:1.6;color:var(--muted)}
        .primary{display:inline-flex;align-items:center;justify-content:center;gap:8px;background:var(--forest);color:#FFFFFF;border:0;border-radius:999px;padding:13px 19px;font-size:12px;font-weight:850;transition:background .2s}
        .primary:hover{background:var(--forest2)}
        .secondary{display:inline-flex;align-items:center;gap:8px;background:#fff;color:var(--forest);border:1px solid #C9DACB;border-radius:999px;padding:12px 17px;font-size:12px;font-weight:800}
        .secondary:hover{background:#F0F5EF}
        .danger{display:inline-flex;align-items:center;gap:8px;color:#AF453B;background:#FFF6F4;border:1px solid #F0D2CD;border-radius:999px;padding:11px 15px;font-size:12px;font-weight:800}
        .danger:hover{background:#FCE6E1}
        .add-panel{border:1px solid var(--line);background:#fff;border-radius:20px;margin-top:24px;overflow:hidden}
        .add-panel>summary{display:flex;align-items:center;justify-content:space-between;gap:20px;list-style:none;padding:22px 26px;cursor:pointer}
        .add-panel>summary::-webkit-details-marker{display:none}
        .add-panel>summary strong{display:block;font-size:16px;font-weight:850;color:var(--forest)}
        .add-panel>summary small{display:block;color:var(--muted);font-size:12px;margin-top:5px;line-height:1.5}
        .add-panel>summary i{font-size:24px;transition:transform .2s;color:var(--forest)}
        .add-panel[open]>summary i{transform:rotate(45deg)}
        .add-content{padding:20px 26px 27px;border-top:1px solid var(--line)}
        .form-grid{display:grid;grid-template-columns:repeat(2,minmax(0,1fr));gap:19px}
        .field{display:flex;flex-direction:column;min-width:0;gap:7px}
        .field.wide{grid-column:1/-1}
        .field label{font-size:12px;color:#2F553D;font-weight:850}
        .field input:not([type=checkbox]),.field select,.field textarea{width:100%;min-width:0;border:1px solid #D6E0D4;border-radius:11px;background:#F8FAF7;color:#1B3B2A;padding:12px 13px;font-size:13px;line-height:1.5}
        .field input[type=file]{background:#fff}
        .field small{font-size:11px;line-height:1.65;color:#819287}
        .check{display:flex;align-items:center;gap:9px;cursor:pointer;font-size:12px;color:#435F48;font-weight:750}
        .check input{width:17px;height:17px;accent-color:var(--forest)}
        .form-actions{display:flex;align-items:center;justify-content:space-between;flex-wrap:wrap;gap:12px;margin-top:24px}
        .form-actions.end{justify-content:flex-end}
        .org-modal{width:min(680px,calc(100vw - 30px));max-height:min(89vh,850px);overflow-y:auto;border:1px solid var(--line);border-radius:22px;background:#FFFFFF;color:var(--ink);box-shadow:0 28px 110px #0F251C48;padding:0}
        .org-modal::backdrop{background:rgba(13,32,23,.68);backdrop-filter:blur(3px)}
        .modal-head{position:sticky;top:0;z-index:2;display:flex;align-items:start;justify-content:space-between;gap:16px;padding:23px 27px;background:#FFFFFF;border-bottom:1px solid var(--line)}
        .modal-head h2{font-size:24px;letter-spacing:-.05em;margin:0;color:var(--forest)}
        .modal-head p{font-size:12px;color:var(--muted);margin:7px 0 0;line-height:1.6}
        .close{border:1px solid #E1E7DF;background:#F6F8F5;border-radius:50%;width:36px;height:36px;display:grid;place-items:center;flex-shrink:0;color:var(--forest)}
        .modal-body{padding:25px 27px 27px}
        .current-photo{display:flex;align-items:center;gap:16px;padding:13px;border:1px solid var(--line);border-radius:13px;background:#F6F9F4;margin-bottom:21px}
        .current-photo .avatar{width:64px;height:64px;font-size:22px}
        .current-photo strong{display:block;font-size:12px;color:var(--forest)}
        .current-photo p{margin:5px 0 0;font-size:11px;line-height:1.5;color:var(--muted)}
        .modal-bottom{display:flex;justify-content:space-between;flex-wrap:wrap;gap:10px;align-items:center;border-top:1px solid var(--line);padding-top:22px;margin-top:23px}
        .status-note{color:var(--muted);font-size:11px;line-height:1.6}
        @media(max-width:1100px){.layout{grid-template-columns:215px minmax(0,1fr)}.main{padding-inline:25px}.tier-2 .person{flex-basis:calc((100% - 15px)/2)}.tier-3 .person{flex-basis:calc((100% - 30px)/3)}.sidebar{padding:24px 13px}}
        @media(max-width:760px){.layout{display:block}.sidebar{min-height:0;position:relative;border-right:0;border-bottom:1px solid var(--line);padding:15px 16px}.brand{margin:0 0 13px}.sidebar-label{display:none}.nav{display:flex;flex-direction:row;gap:6px;overflow-x:auto;scrollbar-width:thin;padding-bottom:5px}.nav-link{white-space:nowrap;min-height:40px;padding:10px 12px}.main{padding:27px 16px 68px}.heading{align-items:flex-start}.title{font-size:clamp(31px,7vw,44px)}.link-public{font-size:11px}.sheet{padding:20px 14px;border-radius:18px}.sheet-top{gap:12px}.sheet-count strong{font-size:27px}.tier-2 .person,.tier-3 .person{flex-basis:calc((100% - 15px)/2);min-width:0}.tabs{margin-bottom:14px}.org-modal{max-height:92vh}}
        @media(max-width:520px){.heading{flex-direction:column;align-items:flex-start;gap:14px}.sheet-top{flex-direction:column}.sheet-count{flex-direction:row;align-items:center;gap:8px}.sheet-count span{margin:0}.tier-grid{gap:10px}.tier-1 .person{width:min(100%,330px)}.tier-2 .person,.tier-3 .person{flex-basis:100%}.person{padding:18px 12px}.avatar{width:73px;height:73px}.tier-1 .avatar{width:95px;height:95px}.form-grid{grid-template-columns:1fr}.field.wide{grid-column:auto}.add-panel>summary{padding:17px}.add-content{padding:18px}.modal-head{padding:19px}.modal-body{padding:19px}.modal-head h2{font-size:20px}}
        @media(prefers-reduced-motion:reduce){*,*::before,*::after{scroll-behavior:auto!important;transition:none!important;animation:none!important}}
    </style>
</head>
<body>
<div class="layout">
    <aside class="sidebar" aria-label="Menu dashboard admin">
        <a href="{{ route('admin.dashboard') }}" class="brand"><span class="brand-mark">NU</span><span><span class="brand-name">NULESMANA</span><span class="brand-sub">PANEL PENGURUS</span></span></a>
        <p class="sidebar-label">NAVIGASI</p>
        <nav class="nav" aria-label="Navigasi admin">
            <a href="{{ route('admin.dashboard') }}" class="nav-link"><i class="ph ph-squares-four" aria-hidden="true"></i> Dashboard</a>
            @if(\Illuminate\Support\Facades\Route::has('admin.members.index'))
                <a href="{{ route('admin.members.index') }}" class="nav-link"><i class="ph ph-users-three" aria-hidden="true"></i> Kelola Anggota</a>
            @endif
            @if(\Illuminate\Support\Facades\Route::has('admin.news.index'))
                <a href="{{ route('admin.news.index') }}" class="nav-link"><i class="ph ph-newspaper" aria-hidden="true"></i> Kelola Berita</a>
            @endif
            @if(\Illuminate\Support\Facades\Route::has('admin.infaq.index'))
                <a href="{{ route('admin.infaq.index') }}" class="nav-link"><i class="ph ph-wallet" aria-hidden="true"></i> Infaq / Kas</a>
            @endif
            <a href="{{ route('admin.struktur.index', ['banom' => $selected]) }}" class="nav-link active" aria-current="page"><i class="ph ph-tree-structure" aria-hidden="true"></i> Kelola Struktur</a>
            @if(\Illuminate\Support\Facades\Route::has('admin.reviews.index'))
                <a href="{{ route('admin.reviews.index') }}" class="nav-link"><i class="ph ph-chat-circle-text" aria-hidden="true"></i> Kelola Ulasan</a>
            @endif
        </nav>
    </aside>
    <main class="main">
        <header class="heading">
            <div>
                <p class="kicker">Admin Panel / Manajemen Pengurus</p>
                <h1 class="title">KELOLA STRUKTUR.</h1>
                <p class="subtitle">Klik pengurus pada bagan untuk mengubah nama, jabatan, foto, atau posisi. Perubahan yang dipublikasikan langsung terlihat di halaman warga.</p>
            </div>
            <a class="link-public" href="{{ route('struktur.banom') }}" target="_blank" rel="noopener noreferrer"><i class="ph ph-arrow-square-out" aria-hidden="true"></i> Lihat Halaman Publik</a>
        </header>
        @if(session('success'))
            <div class="notice" role="status"><i class="ph ph-check-circle" aria-hidden="true"></i> {{ session('success') }}</div>
        @endif
        @if($errors->any())
            <div class="notice error" role="alert"><strong>Data belum tersimpan.</strong><ul>@foreach($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul></div>
        @endif
        <nav class="tabs" aria-label="Pilih badan otonom">
            @foreach($banomLabels as $key => $label)
                <a href="{{ route('admin.struktur.index', ['banom' => $key]) }}" class="tab {{ $selected === $key ? 'active' : '' }}" @if($selected === $key) aria-current="page" @endif>{{ $label }}</a>
            @endforeach
        </nav>
        @php
            $levels = [
                1 => $positions->filter(fn ($p) => (int) $p->level === 1),
                2 => $positions->filter(fn ($p) => (int) $p->level === 2),
                3 => $positions->filter(fn ($p) => (int) $p->level === 3),
            ];
        @endphp
        <section class="sheet" aria-labelledby="sheet-title">
            <div class="sheet-top">
                <div>
                    <p class="kicker">Susunan Pengurus / {{ $selected }}</p>
                    <h2 id="sheet-title" class="sheet-title">{{ $banomLabels[$selected] }}</h2>
                    <p class="sheet-sub">Bagan yang sama dengan halaman publik. Klik kartu mana pun untuk mengedit data, termasuk data contoh.</p>
                </div>
                <div class="sheet-count"><strong>{{ $counts[$selected] }}</strong><span>Anggota ACC</span></div>
            </div>
            @if($positions->isNotEmpty())
                <div class="pyramid">
                    @foreach([1 => 'Pimpinan', 2 => 'Pengurus Inti', 3 => 'Bidang & Program'] as $level => $label)
                        @if($levels[$level]->isNotEmpty())
                            <div class="tier tier-{{ $level }}">
                                <div class="tier-label">{{ $label }}</div>
                                <div class="tier-grid">
                                    @foreach($levels[$level] as $position)
                                        <button type="button" class="person" aria-label="Edit {{ $position->role }}: {{ $position->display_name }}"
                                            data-edit-card data-position-id="{{ $position->id }}"
                                            data-update-url="{{ route('admin.struktur.update', $position->id) }}"
                                            data-destroy-url="{{ route('admin.struktur.destroy', $position->id) }}"
                                            data-role="{{ $position->role }}"
                                            data-name="{{ $position->person_name }}"
                                            data-member-id="{{ $position->member_id }}"
                                            data-description="{{ $position->description }}"
                                            data-level="{{ $position->level }}"
                                            data-order="{{ $position->sort_order }}"
                                            data-visible="{{ (int) $position->is_visible }}"
                                            data-photo-url="{{ $position->photo_url }}"
                                            data-display-name="{{ $position->display_name }}">
                                            <span class="avatar">
                                                @if($position->photo_url)<img src="{{ $position->photo_url }}" alt="Foto {{ $position->display_name }}" loading="lazy">
                                                @else<span aria-hidden="true">{{ mb_strtoupper(mb_substr($position->display_name, 0, 1)) }}</span>@endif
                                            </span>
                                            <span class="person-role">{{ $position->role }}</span>
                                            <span class="person-name">{{ $position->display_name }}</span>
                                            @if($position->description)<span class="person-note">{{ $position->description }}</span>@endif
                                            <span class="person-state {{ $position->is_visible ? '' : 'hidden' }}">{{ $position->is_visible ? 'Tampil di publik' : 'Disembunyikan' }}</span>
                                            <span class="person-edit"><i class="ph ph-pencil-simple-line" aria-hidden="true"></i> Klik untuk edit</span>
                                        </button>
                                    @endforeach
                                </div>
                            </div>
                        @endif
                    @endforeach
                </div>
            @else
                <div class="pyramid-empty"><i class="ph ph-users-three" aria-hidden="true"></i>Belum ada jabatan yang dibuat untuk {{ $banomLabels[$selected] }}.<br>Tambahkan jabatan pertama melalui formulir di bawah.</div>
            @endif
            <div class="sheet-footer">
                <span>{{ $positions->count() }} jabatan tersimpan · {{ $positions->where('is_visible', true)->count() }} ditampilkan di publik</span>
                <button type="button" class="primary" id="open-add"><i class="ph ph-plus" aria-hidden="true"></i> Tambah Jabatan</button>
            </div>
        </section>
        <details class="add-panel" id="add-panel" @if($errors->any() && !old('_edit_id')) open @endif>
            <summary><span><strong>Tambah Pengurus Baru</strong><small>Isi jabatan, pilih anggota atau nama manual, dan unggah foto bila ada.</small></span><i class="ph ph-plus-circle" aria-hidden="true"></i></summary>
            <div class="add-content">
                <form action="{{ route('admin.struktur.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="banom" value="{{ $selected }}">
                    <div class="form-grid">
                        <div class="field"><label for="add-role">Jabatan *</label><input id="add-role" name="role" value="{{ old('role', '') }}" maxlength="100" placeholder="Contoh: Ketua" required></div>
                        <div class="field"><label for="add-member">Ambil dari anggota ACC (opsional)</label><select id="add-member" name="member_id"><option value="">Gunakan nama manual</option>@foreach($members as $member)<option value="{{ $member->id }}" @selected((string) old('member_id') === (string) $member->id)>{{ $member->name }}</option>@endforeach</select></div>
                        <div class="field"><label for="add-name">Nama pengurus *</label><input id="add-name" name="person_name" maxlength="120" value="{{ old('person_name','') }}" placeholder="Isi jika tidak memilih anggota ACC"><small>Jika memilih anggota ACC, nama otomatis diambil dari data anggota.</small></div>
                        <div class="field"><label for="add-desc">Keterangan (opsional)</label><input id="add-desc" name="description" maxlength="180" value="{{ old('description','') }}" placeholder="Contoh: Koordinasi kegiatan"></div>
                        <div class="field"><label for="add-level">Tingkat piramida</label><select id="add-level" name="level" required><option value="1" @selected((int) old('level',2) === 1)>01 · Pimpinan</option><option value="2" @selected((int) old('level',2) === 2)>02 · Pengurus Inti</option><option value="3" @selected((int) old('level',2) === 3)>03 · Bidang & Program</option></select></div>
                        <div class="field"><label for="add-order">Urutan di tingkat</label><input id="add-order" name="sort_order" type="number" min="0" max="999" value="{{ old('sort_order', 0) }}" required><small>Urutan terkecil tampil lebih dulu.</small></div>
                        <div class="field wide"><label for="add-photo">Foto pengurus</label><input id="add-photo" type="file" name="photo" accept="image/jpeg,image/png,image/webp"><small>JPG, PNG, WEBP · maksimal 2 MB. Gunakan foto dengan izin pemiliknya.</small></div>
                        <div class="field wide"><input type="hidden" name="is_visible" value="0"><label class="check"><input type="checkbox" name="is_visible" value="1" @checked((int)old('is_visible',1) === 1)> Tampilkan pada halaman publik</label></div>
                    </div>
                    <div class="form-actions end"><button class="primary" type="submit"><i class="ph ph-floppy-disk" aria-hidden="true"></i> Simpan Pengurus</button></div>
                </form>
            </div>
        </details>
        <p class="status-note" style="margin-top:17px">Foto tersimpan di storage publik berdasarkan ID jabatan, tanpa kolom database baru. Data contoh bisa diubah langsung melalui kartu piramida, selama sudah tercatat di tabel organisasi.</p>
    </main>
</div>
<dialog id="edit-dialog" class="org-modal" aria-labelledby="edit-title">
    <div class="modal-head">
        <div><h2 id="edit-title">Edit Pengurus</h2><p id="edit-subtitle">Ubah data jabatan yang dipilih.</p></div>
        <button type="button" class="close" id="edit-close" aria-label="Tutup formulir"><i class="ph ph-x" aria-hidden="true"></i></button>
    </div>
    <div class="modal-body">
        <div class="current-photo"><div class="avatar" id="edit-avatar"><span id="edit-avatar-letter">N</span></div><div><strong>Foto pengurus</strong><p id="edit-photo-label">Unggah foto baru jika ingin mengganti.</p></div></div>
        <form id="edit-form" action="#" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <input type="hidden" name="_edit_id" id="edit-id">
            <input type="hidden" name="banom" value="{{ $selected }}">
            <div class="form-grid">
                <div class="field"><label for="edit-role">Jabatan *</label><input id="edit-role" name="role" required maxlength="100"></div>
                <div class="field"><label for="edit-member">Anggota ACC (opsional)</label><select id="edit-member" name="member_id"><option value="">Gunakan nama manual</option>@foreach($members as $member)<option value="{{ $member->id }}">{{ $member->name }}</option>@endforeach</select></div>
                <div class="field"><label for="edit-name">Nama manual *</label><input id="edit-name" name="person_name" maxlength="120"><small>Untuk data contoh, ubah nama di sini jika tidak memilih anggota ACC.</small></div>
                <div class="field"><label for="edit-desc">Keterangan</label><input id="edit-desc" name="description" maxlength="180"></div>
                <div class="field"><label for="edit-level">Tingkat piramida</label><select id="edit-level" name="level" required><option value="1">01 · Pimpinan</option><option value="2">02 · Pengurus Inti</option><option value="3">03 · Bidang & Program</option></select></div>
                <div class="field"><label for="edit-order">Urutan</label><input id="edit-order" name="sort_order" type="number" min="0" max="999" required></div>
                <div class="field wide"><label for="edit-photo">Ganti / tambah foto</label><input id="edit-photo" type="file" name="photo" accept="image/jpeg,image/png,image/webp"><small>Biarkan kosong untuk mempertahankan foto lama.</small></div>
                <div class="field wide" id="remove-photo-row"><label class="check"><input id="edit-remove-photo" type="checkbox" name="remove_photo" value="1"> Hapus foto saat ini</label></div>
                <div class="field wide"><input type="hidden" name="is_visible" value="0"><label class="check"><input id="edit-visible" type="checkbox" name="is_visible" value="1"> Tampilkan jabatan di halaman publik</label></div>
            </div>
            <div class="form-actions end"><button type="submit" class="primary"><i class="ph ph-floppy-disk" aria-hidden="true"></i> Simpan Perubahan</button></div>
        </form>
        <div class="modal-bottom"><form id="delete-form" action="#" method="POST" onsubmit="return confirm('Yakin ingin menghapus jabatan ini? Data anggota tidak ikut dihapus.');">@csrf @method('DELETE')<button type="submit" class="danger"><i class="ph ph-trash" aria-hidden="true"></i> Hapus Jabatan</button></form><span class="status-note">Pembaruan publik berlaku setelah disimpan.</span></div>
    </div>
</dialog>
<script>
(function () {
    'use strict';
    const modal = document.getElementById('edit-dialog');
    const form = document.getElementById('edit-form');
    const deleteForm = document.getElementById('delete-form');
    const cards = Array.from(document.querySelectorAll('[data-edit-card]'));
    const avatar = document.getElementById('edit-avatar');
    const photoLabel = document.getElementById('edit-photo-label');
    const addPanel = document.getElementById('add-panel');
    const editPhoto = document.getElementById('edit-photo');
    let previewUrl = null;
    if (!modal || !form) return;
    function resetPhotoPreview() {
        if (previewUrl) {
            window['URL'].revokeObjectURL(previewUrl);
            previewUrl = null;
        }
        avatar.replaceChildren();
    }
    function showPhoto(path, name) {
        resetPhotoPreview();
        if (path) {
            const img = document.createElement('img');
            img.src = path;
            img.alt = 'Foto ' + name;
            img.addEventListener('error', function () {
                if (img.parentNode) { img.remove(); avatar.textContent = name.charAt(0).toUpperCase(); }
            }, { once: true });
            avatar.appendChild(img);
        } else {
            avatar.textContent = name.charAt(0).toUpperCase() || 'N';
        }
    }
    function openEditor(button) {
        form.reset();
        const d = button.dataset;
        form.action = d.updateUrl;
        deleteForm.action = d.destroyUrl;
        document.getElementById('edit-id').value = d.positionId;
        document.getElementById('edit-title').textContent = 'Edit ' + d.role;
        document.getElementById('edit-subtitle').textContent = 'Ubah data ' + d.displayName + ' di dalam bagan kepengurusan.';
        document.getElementById('edit-role').value = d.role || '';
        document.getElementById('edit-member').value = d.memberId || '';
        document.getElementById('edit-name').value = d.name || '';
        document.getElementById('edit-desc').value = d.description || '';
        document.getElementById('edit-level').value = d.level || '2';
        document.getElementById('edit-order').value = d.order || '0';
        document.getElementById('edit-visible').checked = d.visible === '1';
        document.getElementById('edit-remove-photo').checked = false;
        document.getElementById('remove-photo-row').hidden = !d.photoUrl;
        photoLabel.textContent = d.photoUrl ? 'Foto aktif. Pilih file untuk mengganti, atau centang hapus foto.' : 'Belum ada foto. Tambahkan jika tersedia.';
        showPhoto(d.photoUrl, d.displayName || 'N');
        if (typeof modal.showModal === 'function') {
            modal.showModal();
            document.body.classList.add('dialog-open');
        }
    }
    cards.forEach(function (card) { card.addEventListener('click', function () { openEditor(card); }); });
    document.getElementById('edit-close').addEventListener('click', function () { modal.close(); });
    modal.addEventListener('close', function () { document.body.classList.remove('dialog-open'); resetPhotoPreview(); });
    modal.addEventListener('click', function (event) { if (event.target === modal) modal.close(); });
    editPhoto.addEventListener('change', function () {
        const file = editPhoto.files && editPhoto.files[0];
        if (!file) return;
        if (!file.type.startsWith('image/')) { photoLabel.textContent = 'Pilih foto JPG, PNG, atau WEBP.'; return; }
        resetPhotoPreview();
        previewUrl = window['URL'].createObjectURL(file);
        const img = document.createElement('img');
        img.src = previewUrl;
        img.alt = 'Pratinjau foto baru';
        avatar.appendChild(img);
        photoLabel.textContent = 'Foto baru siap diunggah: ' + file.name;
    });
    document.getElementById('open-add').addEventListener('click', function () {
        addPanel.open = true;
        addPanel.scrollIntoView({ behavior: window.matchMedia('(prefers-reduced-motion: reduce)').matches ? 'auto' : 'smooth', block: 'start' });
        document.getElementById('add-role').focus({ preventScroll: true });
    });
    const oldEditId = @json(old('_edit_id'));
    if (oldEditId) {
        const card = cards.find(function (element) { return element.dataset.positionId === String(oldEditId); });
        if (card) {
            openEditor(card);
            document.getElementById('edit-role').value = @json(old('role')) || '';
            document.getElementById('edit-member').value = @json(old('member_id')) || '';
            document.getElementById('edit-name').value = @json(old('person_name')) || '';
            document.getElementById('edit-desc').value = @json(old('description')) || '';
            document.getElementById('edit-level').value = String(@json(old('level')) || '2');
            document.getElementById('edit-order').value = String(@json(old('sort_order')) || '0');
            document.getElementById('edit-visible').checked = String(@json(old('is_visible')) || '0') === '1';
        }
    }
})();
</script>
</body>
</html>
