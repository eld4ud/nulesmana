{{-- STRUKTUR_THEME_REVIEWS_20261105: sidebar, typography, and navigation inherited from layouts.admin --}}
@extends('layouts.admin')

@section('title', 'Kelola Struktur Organisasi')
@section('heading', 'Kelola Struktur')
@section('subtitle', 'Atur struktur dan pengurus badan otonom NU Lesmana')

@push('styles')
<style>

/* Gunakan layout admin asli Nulesmana, sama seperti halaman Kelola Ulasan. */
.admin-main > .admin-topbar, .admin-main > .admin-alert { display: none !important; }
.struktur-page,.org-modal {
  --forest:#183C2F; --forest2:#265642; --ivory:#F5F4F0; --ink:#18291F;
  --muted:#758377; --line:#E3E8E0; --gold:#BD8732;
  font-family:'DM Sans', sans-serif;
  color:var(--forest);
}
.struktur-page, .struktur-page *,.org-modal,.org-modal * {box-sizing:border-box}
.struktur-page button,.struktur-page input,.struktur-page select,.struktur-page textarea,
.org-modal button,.org-modal input,.org-modal select,.org-modal textarea {font:inherit}
.struktur-page button,.org-modal button{cursor:pointer}
.struktur-page a{color:inherit;text-decoration:none}
.struktur-page a:focus-visible,.struktur-page button:focus-visible,.struktur-page input:focus-visible,
.struktur-page select:focus-visible,.struktur-page textarea:focus-visible,
.org-modal button:focus-visible,.org-modal input:focus-visible,.org-modal select:focus-visible {outline:2px solid #6B9F7E;outline-offset:3px}
.struktur-page [hidden],.org-modal [hidden]{display:none!important}
body.dialog-open{overflow:hidden}
.struktur-page{min-width:0}
.struktur-page .heading{display:flex;align-items:flex-end;justify-content:space-between;flex-wrap:wrap;gap:18px;margin-bottom:27px}
.struktur-page .kicker{font-size:11px;font-weight:800;text-transform:uppercase;letter-spacing:.17em;color:#7A8C7C;margin:0}
.struktur-page .title{font-size:clamp(29px,4vw,46px);line-height:1.08;letter-spacing:-.05em;font-weight:800;margin:8px 0 0;color:#183C2F}
.struktur-page .subtitle{font-size:13px;color:#6D7D70;margin:10px 0 0;line-height:1.7;max-width:700px}
.struktur-page .link-public{display:inline-flex;align-items:center;justify-content:center;gap:8px;background:#183C2F;border:1px solid #183C2F;color:#fff;border-radius:12px;padding:13px 19px;font-size:12px;font-weight:800;white-space:nowrap;transition:background .2s}
.struktur-page .link-public:hover{background:#2B5542;color:#fff}
.struktur-page .str-stats{display:grid;grid-template-columns:repeat(4,minmax(0,1fr));gap:14px;margin-bottom:25px}
.struktur-page .str-stat{min-height:150px;min-width:0;background:#fff;border:1px solid var(--line);border-radius:21px;padding:22px;display:flex;flex-direction:column;justify-content:space-between;gap:20px}
.struktur-page .str-stat.is-primary{background:var(--forest);border-color:var(--forest);color:#fff}
.struktur-page .str-stat-label{font-size:11px;line-height:1.5;text-transform:uppercase;font-weight:800;letter-spacing:.10em;opacity:.75}
.struktur-page .str-stat-value{font-size:clamp(30px,3vw,42px);line-height:1;font-weight:800;letter-spacing:-.05em;font-variant-numeric:tabular-nums}
.struktur-page .str-stat-note{font-size:11px;line-height:1.4;margin-top:8px;opacity:.7}
.struktur-page .sheet-top .kicker{font-size:10px;margin:0 0 9px}
        .notice{padding:14px 17px;border-radius:12px;margin-bottom:22px;background:#EDF5EB;border:1px solid #BDDAC1;color:#2F6940;font-size:13px;line-height:1.65}
        .notice.error{background:#FFF4ED;border-color:#E9CBB7;color:#8B452E}
        .notice ul{margin:8px 0 0;padding-left:22px}
        .tabs{display:flex;gap:8px;overflow-x:auto;scrollbar-width:thin;padding:0 0 15px;margin-bottom:23px}
        .tab{flex-shrink:0;border:1px solid #D6E1D4;border-radius:10px;background:#F5F4F0;color:#647568;padding:12px 17px;font-size:12px;font-weight:800}
        .tab:hover{background:#EEF4EB}.tab.active{background:var(--forest);border-color:var(--forest);color:#fff}
        .sheet{background:#fff;border:1px solid var(--line);border-radius:20px;padding:clamp(21px,3vw,34px)}
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
        .avatar img{width:100%;height:100%;display:block;object-fit:cover;object-position:var(--photo-x,50%) var(--photo-y,25%);transform:scale(var(--photo-scale,1));transform-origin:var(--photo-x,50%) var(--photo-y,25%)}
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
        .primary{display:inline-flex;align-items:center;justify-content:center;gap:8px;background:var(--forest);color:#FFFFFF;border:0;border-radius:12px;padding:13px 19px;font-size:12px;font-weight:850;transition:background .2s}
        .primary:hover{background:var(--forest2)}
        .secondary{display:inline-flex;align-items:center;gap:8px;background:#fff;color:var(--forest);border:1px solid #C9DACB;border-radius:12px;padding:12px 17px;font-size:12px;font-weight:800}
        .secondary:hover{background:#F0F5EF}
        .danger{display:inline-flex;align-items:center;gap:8px;color:#AF453B;background:#FFF6F4;border:1px solid #F0D2CD;border-radius:11px;padding:11px 15px;font-size:12px;font-weight:800}
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

/* Perubahan posisi foto: preview sama persis dengan avatar publik. */
.photo-adjust{grid-column:1/-1;display:grid;grid-template-columns:158px minmax(0,1fr);align-items:center;gap:22px;padding:18px;border:1px solid #D6E4D7;border-radius:16px;background:#F4F8F3;margin:18px 0 8px}
.photo-adjust-preview{display:flex;flex-direction:column;align-items:center;text-align:center;gap:9px;min-width:0}
.photo-adjust-preview .avatar{width:138px;height:138px;font-size:48px;border-width:4px;box-shadow:0 8px 20px #183C2F14}
.photo-adjust-preview span{font-size:11px;line-height:1.5;color:var(--muted)}
.photo-adjust-controls{min-width:0}
.photo-adjust-controls h3{font-size:14px;letter-spacing:-.025em;color:var(--forest);margin:0 0 4px}
.photo-adjust-controls p{font-size:11px;line-height:1.6;color:var(--muted);margin:0 0 15px}
.adjust-line{display:block;margin:12px 0}
.adjust-line .adjust-head{display:flex;align-items:center;justify-content:space-between;gap:12px;font-size:12px;color:#345741;font-weight:750;margin-bottom:6px}
.adjust-head output{font-size:11px;color:#63856D;font-variant-numeric:tabular-nums}
.adjust-line input[type=range]{display:block;width:100%;padding:0;margin:0;accent-color:var(--forest);cursor:pointer}
.adjust-reset{padding:6px 11px;border:1px solid #CFDCCF;background:white;color:var(--forest);border-radius:8px;font-size:11px;font-weight:800}
.adjust-reset:hover{background:#EBF2E9}
.adjust-hint{font-size:11px;color:var(--muted);margin:8px 0 0;line-height:1.6}
@media(max-width:560px){.photo-adjust{grid-template-columns:1fr;gap:15px}.photo-adjust-preview .avatar{width:122px;height:122px}.photo-adjust-controls{width:100%}}
/* Responsif, selaras dengan grid dan sidebar dari layouts.admin */
@media (max-width:1100px){
 .struktur-page .tier-2 .person{flex-basis:calc((100% - 15px)/2)}
 .struktur-page .tier-3 .person{flex-basis:calc((100% - 30px)/3)}
 .struktur-page .str-stats{grid-template-columns:repeat(2,minmax(0,1fr))}
}
@media (max-width:760px){
 .struktur-page .heading{align-items:flex-start}
 .struktur-page .sheet{padding:20px 14px;border-radius:18px}
 .struktur-page .sheet-top{gap:12px}
 .struktur-page .sheet-count strong{font-size:27px}
 .struktur-page .tier-2 .person,.struktur-page .tier-3 .person{flex-basis:calc((100% - 15px)/2);min-width:0}
 .struktur-page .tabs{margin-bottom:14px}
 .org-modal{max-height:92vh}
}
@media (max-width:520px){
 .struktur-page .heading{flex-direction:column;align-items:flex-start;gap:14px}
 .struktur-page .title{font-size:31px}
 .struktur-page .str-stats{gap:9px}
 .struktur-page .str-stat{padding:17px;min-height:130px}
 .struktur-page .sheet-top{flex-direction:column}
 .struktur-page .sheet-count{flex-direction:row;align-items:center;gap:8px}
 .struktur-page .sheet-count span{margin:0}
 .struktur-page .tier-grid{gap:10px}
 .struktur-page .tier-1 .person{width:min(100%,330px)}
 .struktur-page .tier-2 .person,.struktur-page .tier-3 .person{flex-basis:100%}
 .struktur-page .person{padding:18px 12px}
 .struktur-page .avatar{width:73px;height:73px}
 .struktur-page .tier-1 .avatar{width:95px;height:95px}
 .struktur-page .form-grid,.org-modal .form-grid{grid-template-columns:1fr}
 .struktur-page .field.wide,.org-modal .field.wide{grid-column:auto}
 .struktur-page .add-panel>summary{padding:17px}
 .struktur-page .add-content{padding:18px}
 .org-modal .modal-head{padding:19px}
 .org-modal .modal-body{padding:19px}
 .org-modal .modal-head h2{font-size:20px}
}
@media (prefers-reduced-motion:reduce){.struktur-page *, .org-modal *{scroll-behavior:auto!important;transition:none!important;animation:none!important}}

</style>
@endpush

@section('content')
<div class="struktur-page">
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

        <section class="str-stats" aria-label="Ringkasan struktur {{ $banomLabels[$selected] }}">
            <article class="str-stat is-primary">
                <span class="str-stat-label">Total Jabatan</span>
                <div><div class="str-stat-value">{{ $positions->count() }}</div><p class="str-stat-note">Tersimpan di {{ $banomLabels[$selected] }}</p></div>
            </article>
            <article class="str-stat">
                <span class="str-stat-label">Tampil di Publik</span>
                <div><div class="str-stat-value">{{ $positions->where('is_visible', true)->count() }}</div><p class="str-stat-note">Terlihat oleh pengunjung</p></div>
            </article>
            <article class="str-stat">
                <span class="str-stat-label">Disembunyikan</span>
                <div><div class="str-stat-value">{{ $positions->where('is_visible', false)->count() }}</div><p class="str-stat-note">Tidak tampil di website</p></div>
            </article>
            <article class="str-stat">
                <span class="str-stat-label">Anggota ACC</span>
                <div><div class="str-stat-value">{{ $counts[$selected] }}</div><p class="str-stat-note">Anggota terverifikasi</p></div>
            </article>
        </section>
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
                                            data-photo-x="{{ $position->photo_adjust['x'] }}"
                                            data-photo-y="{{ $position->photo_adjust['y'] }}"
                                            data-photo-zoom="{{ $position->photo_adjust['zoom'] }}"
                                            data-display-name="{{ $position->display_name }}">
                                            <span class="avatar" style="--photo-x:{{ $position->photo_adjust['x'] }}%;--photo-y:{{ $position->photo_adjust['y'] }}%;--photo-scale:{{ $position->photo_adjust['zoom'] / 100 }}">
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
<div class="photo-adjust" data-adjust-panel="add">
    <div class="photo-adjust-preview">
        <div class="avatar" id="add-avatar" aria-label="Pratinjau pemotongan foto"><span aria-hidden="true">N</span></div>
        <span id="add-photo-label">Pilih foto untuk melihat hasilnya.</span>
    </div>
    <div class="photo-adjust-controls">
        <h3><i class="ph ph-crop" aria-hidden="true"></i> Atur Posisi Foto</h3>
        <p>Geser fokus foto dan zoom. Pratinjau ini sama dengan tampilan lingkaran di halaman publik.</p>
        <label class="adjust-line" for="add-photo-x"><span class="adjust-head">Horizontal (kiri · kanan) <output id="add-photo-x-value">{{ old('photo_x', 50) }}%</output></span>
            <input id="add-photo-x" name="photo_x" type="range" min="0" max="100" step="1" value="{{ old('photo_x', 50) }}"></label>
        <label class="adjust-line" for="add-photo-y"><span class="adjust-head">Vertikal (atas · bawah) <output id="add-photo-y-value">{{ old('photo_y', 25) }}%</output></span>
            <input id="add-photo-y" name="photo_y" type="range" min="0" max="100" step="1" value="{{ old('photo_y', 25) }}"></label>
        <label class="adjust-line" for="add-photo-zoom"><span class="adjust-head">Zoom <output id="add-photo-zoom-value">{{ old('photo_zoom', 100) }}%</output></span>
            <input id="add-photo-zoom" name="photo_zoom" type="range" min="100" max="200" step="5" value="{{ old('photo_zoom', 100) }}"></label>
        <button type="button" class="adjust-reset" id="add-photo-reset"><i class="ph ph-arrow-counter-clockwise" aria-hidden="true"></i> Reset posisi</button>
        <p class="adjust-hint">Pengaturan hanya memengaruhi tampilan, file foto asli tidak dipotong.</p>
    </div>
</div>
                        <div class="field wide"><input type="hidden" name="is_visible" value="0"><label class="check"><input type="checkbox" name="is_visible" value="1" @checked((int)old('is_visible',1) === 1)> Tampilkan pada halaman publik</label></div>
                    </div>
                    <div class="form-actions end"><button class="primary" type="submit"><i class="ph ph-floppy-disk" aria-hidden="true"></i> Simpan Pengurus</button></div>
                </form>
            </div>
        </details>
        <p class="status-note" style="margin-top:17px">Foto dan pengaturan fokus/zoom tersimpan di storage publik berdasarkan ID jabatan, tanpa kolom database baru. Data contoh bisa diubah langsung melalui kartu piramida, selama sudah tercatat di tabel organisasi.</p>
</div>
<dialog id="edit-dialog" class="org-modal" aria-labelledby="edit-title">
    <div class="modal-head">
        <div><h2 id="edit-title">Edit Pengurus</h2><p id="edit-subtitle">Ubah data jabatan yang dipilih.</p></div>
        <button type="button" class="close" id="edit-close" aria-label="Tutup formulir"><i class="ph ph-x" aria-hidden="true"></i></button>
    </div>
    <div class="modal-body">
        <form id="edit-form" action="#" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <input type="hidden" name="_edit_id" id="edit-id">
            <input type="hidden" name="banom" value="{{ $selected }}">
<div class="photo-adjust" data-adjust-panel="edit">
    <div class="photo-adjust-preview">
        <div class="avatar" id="edit-avatar" aria-label="Pratinjau pemotongan foto"><span aria-hidden="true">N</span></div>
        <span id="edit-photo-label">Foto yang terlihat di website.</span>
    </div>
    <div class="photo-adjust-controls">
        <h3><i class="ph ph-crop" aria-hidden="true"></i> Atur Posisi Foto</h3>
        <p>Geser fokus foto dan zoom. Pratinjau ini sama dengan tampilan lingkaran di halaman publik.</p>
        <label class="adjust-line" for="edit-photo-x"><span class="adjust-head">Horizontal (kiri · kanan) <output id="edit-photo-x-value">50%</output></span>
            <input id="edit-photo-x" name="photo_x" type="range" min="0" max="100" step="1" value="50"></label>
        <label class="adjust-line" for="edit-photo-y"><span class="adjust-head">Vertikal (atas · bawah) <output id="edit-photo-y-value">25%</output></span>
            <input id="edit-photo-y" name="photo_y" type="range" min="0" max="100" step="1" value="25"></label>
        <label class="adjust-line" for="edit-photo-zoom"><span class="adjust-head">Zoom <output id="edit-photo-zoom-value">100%</output></span>
            <input id="edit-photo-zoom" name="photo_zoom" type="range" min="100" max="200" step="5" value="100"></label>
        <button type="button" class="adjust-reset" id="edit-photo-reset"><i class="ph ph-arrow-counter-clockwise" aria-hidden="true"></i> Reset posisi</button>
        <p class="adjust-hint">Pengaturan hanya memengaruhi tampilan, file foto asli tidak dipotong.</p>
    </div>
</div>
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
@endsection

@push('scripts')
<script>
(function () {
    'use strict';
    const modal = document.getElementById('edit-dialog');
    const form = document.getElementById('edit-form');
    const deleteForm = document.getElementById('delete-form');
    const cards = Array.from(document.querySelectorAll('[data-edit-card]'));
    const addPanel = document.getElementById('add-panel');
    const editPhoto = document.getElementById('edit-photo');
    const addPhoto = document.getElementById('add-photo');
    const photoLabel = document.getElementById('edit-photo-label');
    const removePhoto = document.getElementById('edit-remove-photo');
    const previews = {add: null, edit: null};
    const defaults = {x: 50, y: 25, zoom: 100};
    if (!modal || !form) return;

    function clamp(value, min, max, fallback) {
        const number = Number(value);
        return Number.isFinite(number) ? Math.max(min, Math.min(max, number)) : fallback;
    }
    function updateAdjustment(kind) {
        const avatar = document.getElementById(kind + '-avatar');
        const x = clamp(document.getElementById(kind + '-photo-x').value, 0, 100, 50);
        const y = clamp(document.getElementById(kind + '-photo-y').value, 0, 100, 25);
        const zoom = clamp(document.getElementById(kind + '-photo-zoom').value, 100, 200, 100);
        avatar.style.setProperty('--photo-x', x + '%');
        avatar.style.setProperty('--photo-y', y + '%');
        avatar.style.setProperty('--photo-scale', String(zoom / 100));
        document.getElementById(kind + '-photo-x-value').textContent = x + '%';
        document.getElementById(kind + '-photo-y-value').textContent = y + '%';
        document.getElementById(kind + '-photo-zoom-value').textContent = zoom + '%';
    }
    function setAdjustment(kind, values) {
        document.getElementById(kind + '-photo-x').value = clamp(values.x, 0, 100, 50);
        document.getElementById(kind + '-photo-y').value = clamp(values.y, 0, 100, 25);
        document.getElementById(kind + '-photo-zoom').value = clamp(values.zoom, 100, 200, 100);
        updateAdjustment(kind);
    }
    ['add', 'edit'].forEach(function (kind) {
        ['x', 'y', 'zoom'].forEach(function (field) {
            document.getElementById(kind + '-photo-' + field).addEventListener('input', function () {
                updateAdjustment(kind);
            });
        });
        document.getElementById(kind + '-photo-reset').addEventListener('click', function () {
            setAdjustment(kind, defaults);
        });
        updateAdjustment(kind);
    });
    function clearPreview(kind) {
        if (previews[kind]) {
            URL.revokeObjectURL(previews[kind]);
            previews[kind] = null;
        }
        document.getElementById(kind + '-avatar').replaceChildren();
    }
    function showPhoto(kind, src, name, useObjectUrl) {
        clearPreview(kind);
        const avatar = document.getElementById(kind + '-avatar');
        if (!src) {
            const letter = document.createElement('span');
            letter.textContent = (name || 'N').trim().charAt(0).toUpperCase() || 'N';
            avatar.appendChild(letter);
            return;
        }
        if (useObjectUrl) previews[kind] = src;
        const img = document.createElement('img');
        img.src = src;
        img.alt = 'Pratinjau foto ' + (name || 'pengurus');
        img.addEventListener('error', function () {
            if (img.parentNode) {
                img.remove();
                const letter = document.createElement('span');
                letter.textContent = (name || 'N').trim().charAt(0).toUpperCase() || 'N';
                avatar.appendChild(letter);
            }
        }, {once: true});
        avatar.appendChild(img);
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
        removePhoto.checked = false;
        document.getElementById('remove-photo-row').hidden = !d.photoUrl;
        setAdjustment('edit', {
            x: d.photoX ?? defaults.x,
            y: d.photoY ?? defaults.y,
            zoom: d.photoZoom ?? defaults.zoom
        });
        photoLabel.textContent = d.photoUrl ? 'Foto aktif. Geser slider untuk mengatur posisinya.' : 'Belum ada foto. Tambahkan jika tersedia.';
        showPhoto('edit', d.photoUrl, d.displayName || 'N', false);
        if (typeof modal.showModal === 'function') {
            modal.showModal();
            document.body.classList.add('dialog-open');
        }
    }
    cards.forEach(function (card) { card.addEventListener('click', function () { openEditor(card); }); });
    document.getElementById('edit-close').addEventListener('click', function () { modal.close(); });
    modal.addEventListener('close', function () { document.body.classList.remove('dialog-open'); clearPreview('edit'); });
    modal.addEventListener('click', function (event) { if (event.target === modal) modal.close(); });

    editPhoto.addEventListener('change', function () {
        const file = editPhoto.files && editPhoto.files[0];
        const d = cards.find(function (card) { return card.dataset.positionId === document.getElementById('edit-id').value; });
        if (!file) {
            showPhoto('edit', d ? d.dataset.photoUrl : '', d ? d.dataset.displayName : 'N', false);
            photoLabel.textContent = 'Foto lama tetap digunakan.';
            return;
        }
        if (!['image/jpeg', 'image/png', 'image/webp'].includes(file.type)) {
            photoLabel.textContent = 'Format harus JPG, PNG, atau WEBP.';
            return;
        }
        const url = URL.createObjectURL(file);
        showPhoto('edit', url, file.name, true);
        removePhoto.checked = false;
        photoLabel.textContent = 'Pratinjau foto baru: ' + file.name;
    });
    removePhoto.addEventListener('change', function () {
        if (removePhoto.checked) {
            editPhoto.value = '';
            showPhoto('edit', '', document.getElementById('edit-name').value || 'N', false);
            photoLabel.textContent = 'Foto akan dihapus setelah disimpan.';
        } else {
            const d = cards.find(function (card) { return card.dataset.positionId === document.getElementById('edit-id').value; });
            showPhoto('edit', d ? d.dataset.photoUrl : '', d ? d.dataset.displayName : 'N', false);
            photoLabel.textContent = 'Foto lama dipertahankan.';
        }
    });
    addPhoto.addEventListener('change', function () {
        const file = addPhoto.files && addPhoto.files[0];
        if (!file) {
            showPhoto('add', '', 'N', false);
            document.getElementById('add-photo-label').textContent = 'Pilih foto untuk melihat hasilnya.';
            return;
        }
        if (!['image/jpeg', 'image/png', 'image/webp'].includes(file.type)) {
            document.getElementById('add-photo-label').textContent = 'Format harus JPG, PNG, atau WEBP.';
            return;
        }
        showPhoto('add', URL.createObjectURL(file), file.name, true);
        document.getElementById('add-photo-label').textContent = 'Pratinjau: ' + file.name;
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
            setAdjustment('edit', {
                x: @json(old('photo_x')) ?? card.dataset.photoX,
                y: @json(old('photo_y')) ?? card.dataset.photoY,
                zoom: @json(old('photo_zoom')) ?? card.dataset.photoZoom
            });
        }
    }
})();
</script>
@endpush
