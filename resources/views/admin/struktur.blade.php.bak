
@extends('layouts.admin')

@section('title', 'Kelola Struktur Organisasi')
@section('heading', 'Kelola Struktur Organisasi')
@section('subtitle', 'Atur jabatan, susunan pengurus, dan data Badan Otonom NU Lesmana.')

@section('content')

<style>
    .struktur-page {
        --forest: #183C2F;
        --ivory: #F5F4F0;
        --line: #DDE5DB;
        --muted: #69796D;
        color: var(--forest);
        font-family: 'DM Sans', sans-serif;
    }

    .struktur-page *,
    .struktur-page *::before,
    .struktur-page *::after {
        box-sizing: border-box;
    }

    .struktur-page button,
    .struktur-page input,
    .struktur-page select {
        font: inherit;
    }

    .struktur-page button {
        cursor: pointer;
    }

    .struktur-actions {
        display: flex;
        justify-content: flex-end;
        flex-wrap: wrap;
        gap: 9px;
        margin-bottom: 24px;
    }

    .struktur-outline-btn {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
        border: 1px solid #CAD9CC;
        padding: 11px 16px;
        border-radius: 100px;
        background: #FFFFFF;
        color: var(--forest);
        font-size: 11px !important;
        font-weight: 800 !important;
        text-decoration: none;
        white-space: nowrap;
        transition: background .2s;
    }

    .struktur-outline-btn:hover {
        background: #EDF3ED;
    }

    .struktur-outline-btn.primary {
        background: var(--forest);
        border-color: var(--forest);
        color: white;
    }

    .struktur-outline-btn.primary:hover {
        background: #275742;
    }

    .struktur-notice {
        padding: 14px 17px;
        margin-bottom: 20px;
        border-radius: 12px;
        background: #E6EFE6;
        border: 1px solid #BAD5C2;
        color: var(--forest);
        font-size: 12px;
        line-height: 1.7;
    }

    .struktur-notice.error {
        background: #FFF0EF;
        border-color: #EBC2BD;
        color: #973C31;
    }

    .struktur-notice ul {
        padding-left: 20px;
        margin-top: 8px;
        list-style: disc;
    }

    /* PILIHAN BANOM */

    .struktur-tabs {
        display: flex;
        gap: 8px;
        overflow-x: auto;
        padding-bottom: 10px;
        margin-bottom: 23px;
        scrollbar-width: thin;
    }

    .struktur-tab {
        display: inline-flex;
        align-items: center;
        gap: 9px;
        flex-shrink: 0;
        border-radius: 100px;
        padding: 12px 17px;
        border: 1px solid #DAE4D9;
        background: white;
        color: #607266;
        font-size: 11px;
        font-weight: 800;
        text-decoration: none;
    }

    .struktur-tab:hover {
        background: #EBF1E9;
    }

    .struktur-tab.active {
        color: white;
        background: var(--forest);
        border-color: var(--forest);
    }

    .struktur-tab-count {
        display: inline-grid;
        place-items: center;
        min-width: 23px;
        height: 23px;
        padding: 0 6px;
        background: rgba(0, 0, 0, .06);
        border-radius: 100px;
        font-size: 10px;
    }

    .struktur-tab.active .struktur-tab-count {
        background: rgba(255, 255, 255, .18);
    }

    /* STATISTIK STRUKTUR */

    .struktur-summary {
        display: grid;
        grid-template-columns: repeat(3, minmax(0, 1fr));
        margin-bottom: 23px;
        background: white;
        border: 1px solid var(--line);
        border-radius: 18px;
        overflow: hidden;
    }

    .struktur-summary-item {
        padding: 24px;
        border-right: 1px solid var(--line);
    }

    .struktur-summary-item:last-child {
        border-right: 0;
    }

    .struktur-summary-item strong {
        display: block;
        font-size: 39px;
        font-weight: 800;
        letter-spacing: -.06em;
        line-height: 1.1;
        color: var(--forest);
    }

    .struktur-summary-item span {
        display: block;
        margin-top: 7px;
        color: var(--muted);
        font-size: 11px;
        font-weight: 600;
        line-height: 1.6;
    }

    .struktur-demo-note {
        margin-bottom: 23px;
        padding: 15px 17px;
        background: #EAF0E9;
        color: #465B4C;
        border-left: 3px solid var(--forest);
        border-radius: 0 11px 11px 0;
        font-size: 11px;
        line-height: 1.8;
    }

    /* KONTEN FORM DAN DAFTAR */

    .struktur-columns {
        display: grid;
        grid-template-columns: minmax(0, 1fr) minmax(0, 1fr);
        gap: 18px;
        align-items: start;
    }

    .struktur-panel {
        min-width: 0;
        background: white;
        border: 1px solid var(--line);
        border-radius: 20px;
        padding: 25px;
    }

    .struktur-panel-head {
        padding-bottom: 19px;
        margin-bottom: 22px;
        border-bottom: 1px solid #E8EDE7;
    }

    .struktur-panel-head h2 {
        margin: 0 0 7px;
        color: var(--forest);
        font-size: 19px;
        font-weight: 800;
        letter-spacing: -.04em;
    }

    .struktur-panel-head p {
        margin: 0;
        color: var(--muted);
        font-size: 11px;
        line-height: 1.7;
    }

    .struktur-fields {
        display: grid;
        grid-template-columns: repeat(2, minmax(0, 1fr));
        gap: 15px;
    }

    .struktur-field {
        min-width: 0;
    }

    .struktur-field.wide {
        grid-column: 1 / -1;
    }

    .struktur-field > label {
        display: block;
        margin-bottom: 7px;
        font-size: 11px;
        font-weight: 800;
        color: #3C5746;
    }

    .struktur-field input:not([type="checkbox"]),
    .struktur-field select {
        display: block;
        width: 100%;
        min-width: 0;
        padding: 12px 13px;
        background: #FBFCFA;
        color: #17251F;
        border: 1px solid #DCE5DB;
        border-radius: 10px;
        outline: none;
        font-size: 12px;
        font-weight: 600;
    }

    .struktur-field input:focus,
    .struktur-field select:focus {
        border-color: var(--forest);
        box-shadow: 0 0 0 3px rgba(24, 60, 47, .09);
    }

    .struktur-hint {
        margin-top: 7px;
        color: #7A897F;
        font-size: 10px;
        line-height: 1.7;
    }

    .struktur-check {
        display: flex;
        gap: 10px;
        align-items: flex-start;
        color: #46604F;
        font-size: 11px;
        font-weight: 700;
        line-height: 1.6;
    }

    .struktur-check input {
        margin-top: 3px;
        accent-color: var(--forest);
    }

    .struktur-form-actions {
        display: flex;
        flex-wrap: wrap;
        gap: 9px;
        margin-top: 20px;
    }

    .struktur-btn {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
        border-radius: 10px;
        padding: 12px 17px;
        border: 1px solid transparent;
        font-size: 11px !important;
        font-weight: 800 !important;
    }

    .struktur-btn.primary {
        background: var(--forest);
        color: white;
    }

    .struktur-btn.primary:hover {
        background: #275741;
    }

    .struktur-btn.danger {
        background: #FFF7F6;
        color: #983D36;
        border-color: #E8CDC9;
    }

    .struktur-btn.danger:hover {
        background: #FFF0EF;
    }

    /* DAFTAR JABATAN */

    .struktur-entry-list {
        display: grid;
        gap: 10px;
    }

    .struktur-entry {
        background: #FBFCFA;
        border: 1px solid #E3E9E1;
        border-radius: 12px;
        overflow: hidden;
    }

    .struktur-entry[open] {
        background: white;
        border-color: #C7D6C8;
    }

    .struktur-entry summary {
        display: flex;
        align-items: center;
        gap: 12px;
        padding: 16px;
        list-style: none;
        cursor: pointer;
    }

    .struktur-entry summary::-webkit-details-marker {
        display: none;
    }

    .struktur-entry-number {
        display: grid;
        place-items: center;
        width: 37px;
        height: 37px;
        flex-shrink: 0;
        border-radius: 10px;
        background: #EAF0E8;
        color: var(--forest);
        font-size: 14px;
        font-weight: 800;
    }

    .struktur-entry-summary {
        flex: 1;
        min-width: 0;
    }

    .struktur-entry-summary strong {
        display: block;
        font-size: 12px;
        font-weight: 800;
        color: #20392A;
        overflow-wrap: anywhere;
    }

    .struktur-entry-summary small {
        display: block;
        font-size: 10px;
        color: var(--muted);
        line-height: 1.6;
        margin-top: 4px;
        overflow-wrap: anywhere;
    }

    .struktur-entry-content {
        padding: 19px;
        border-top: 1px solid #E4EAE2;
    }

    .struktur-edit-icon {
        font-size: 18px;
        color: #758477;
    }

    .struktur-empty {
        padding: 25px 5px;
        font-size: 12px;
        color: var(--muted);
        line-height: 1.8;
    }

    .struktur-info {
        margin-top: 19px;
        font-size: 11px;
        color: var(--muted);
        line-height: 1.8;
    }

    .struktur-copy-feedback {
        font-size: 11px;
        color: #46604F;
        text-align: right;
        margin: -13px 0 18px;
        min-height: 18px;
    }

    /* LEMBAR CETAK */
    .struktur-print-only {
        display: none;
    }

    @media (max-width: 1150px) {
        .struktur-columns {
            grid-template-columns: 1fr;
        }
    }

    @media (max-width: 650px) {
        .struktur-summary-item {
            padding: 15px 11px;
        }

        .struktur-summary-item strong {
            font-size: 29px;
        }

        .struktur-summary-item span {
            font-size: 9px;
        }

        .struktur-actions {
            justify-content: flex-start;
        }

        .struktur-panel {
            padding: 18px;
        }
    }

    @media (max-width: 430px) {
        .struktur-fields {
            grid-template-columns: 1fr;
        }

        .struktur-field.wide {
            grid-column: auto;
        }
    }

    /* CETAK STRUKTUR TANPA SIDEBAR */
    @media print {
        @page {
            size: A4 portrait;
            margin: 16mm;
        }

        body {
            background: white !important;
        }

        .admin-shell {
            display: block !important;
        }

        .admin-sidebar,
        .admin-topbar,
        .admin-alert,
        .struktur-screen {
            display: none !important;
        }

        .admin-main {
            margin: 0 !important;
            padding: 0 !important;
            width: 100% !important;
        }

        .struktur-page {
            color: #183C2F !important;
        }

        .struktur-print-only {
            display: block !important;
            font-family: 'DM Sans', Arial, sans-serif;
            color: #183C2F;
        }

        .struktur-print-header {
            border-bottom: 2px solid #183C2F;
            padding-bottom: 17px;
            margin-bottom: 22px;
        }

        .struktur-print-header h1 {
            font-size: 26px;
            font-weight: 800;
            letter-spacing: -.04em;
            margin: 5px 0;
        }

        .struktur-print-header p {
            font-size: 12px;
            color: #47614D;
        }

        .struktur-print-table {
            width: 100%;
            border-collapse: collapse;
            table-layout: fixed;
        }

        .struktur-print-table th {
            text-align: left;
            padding: 10px;
            font-size: 11px;
            background: #EAF0EA !important;
            border: 1px solid #AABBAF;
        }

        .struktur-print-table td {
            padding: 10px;
            border: 1px solid #BCCAC0;
            font-size: 12px;
            vertical-align: top;
            overflow-wrap: anywhere;
        }

        .struktur-print-table tr {
            break-inside: avoid;
        }

        .struktur-print-note {
            margin-top: 22px;
            font-size: 11px;
            color: #56695A;
        }
    }
</style>

<div class="struktur-page">

    <!-- TAMPILAN ADMIN -->
    <div class="struktur-screen">

        <!-- TOMBOL SALIN, CETAK, LIHAT PUBLIK -->
        <div class="struktur-actions">

            <button
                id="struktur-copy-button"
                type="button"
                class="struktur-outline-btn"
            >
                <i class="ph ph-copy"></i>
                SALIN STRUKTUR
            </button>

            <button
                type="button"
                onclick="window.print()"
                class="struktur-outline-btn"
            >
                <i class="ph ph-printer"></i>
                CETAK A4
            </button>

            <a
                href="{{ route('struktur.banom') }}"
                target="_blank"
                rel="noopener noreferrer"
                class="struktur-outline-btn primary"
            >
                <i class="ph ph-arrow-square-out"></i>
                LIHAT PUBLIK
            </a>

        </div>

        <p
            id="struktur-copy-feedback"
            class="struktur-copy-feedback"
            role="status"
            aria-live="polite"
        ></p>

        <!-- ERROR KHUSUS STRUKTUR -->
        @if(session('error'))
            <div class="struktur-notice error" role="alert">
                {{ session('error') }}
            </div>
        @endif

        @if($errors->any())
            <div class="struktur-notice error" role="alert">
                <strong>Periksa data berikut:</strong>

                <ul>
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <!-- PILIH BADAN OTONOM -->
        <nav class="struktur-tabs" aria-label="Pilih Badan Otonom">

            @foreach($banomLabels as $key => $label)

                <a
                    href="{{ route('admin.struktur.index', ['banom' => $key]) }}"
                    class="struktur-tab {{ $selected === $key ? 'active' : '' }}"
                    @if($selected === $key) aria-current="page" @endif
                >
                    {{ $label }}

                    <span class="struktur-tab-count">
                        {{ $counts[$key] ?? 0 }}
                    </span>
                </a>

            @endforeach

        </nav>

        <!-- RINGKASAN BANOM -->
        <section class="struktur-summary">

            <div class="struktur-summary-item">
                <strong>
                    {{ $positions->count() }}
                </strong>

                <span>Total jabatan</span>
            </div>

            <div class="struktur-summary-item">
                <strong>
                    {{ $positions->where('is_visible', 1)->count() }}
                </strong>

                <span>Jabatan tampil di publik</span>
            </div>

            <div class="struktur-summary-item">
                <strong>
                    {{ $counts[$selected] ?? 0 }}
                </strong>

                <span>Anggota terverifikasi</span>
            </div>

        </section>

        <!-- CATATAN DATA CONTOH -->
        <div class="struktur-demo-note">
            <strong>Catatan:</strong>
            Nama yang diawali "Contoh" merupakan data sementara.
            Ganti dengan pengurus sebenarnya melalui form edit.
            Mengubah struktur tidak mengubah NIA ataupun status keanggotaan.
        </div>

        <div class="struktur-columns">

            <!-- =====================================
                 FORM TAMBAH JABATAN
            ====================================== -->
            <section class="struktur-panel">

                <div class="struktur-panel-head">
                    <h2>Tambah Jabatan</h2>

                    <p>
                        Tambahkan posisi pengurus baru
                        pada Banom yang sedang dipilih.
                    </p>
                </div>

                <form
                    method="POST"
                    action="{{ route('admin.struktur.store') }}"
                >
                    @csrf

                    <input
                        type="hidden"
                        name="banom"
                        value="{{ $selected }}"
                    >

                    <div class="struktur-fields">

                        <div class="struktur-field wide">
                            <label for="new-role">
                                Nama Jabatan *
                            </label>

                            <input
                                id="new-role"
                                type="text"
                                name="role"
                                value="{{ old('role') }}"
                                placeholder="Contoh: Ketua"
                                maxlength="100"
                                required
                            >
                        </div>

                        <div class="struktur-field wide">
                            <label for="new-member">
                                Pilih Anggota yang Sudah ACC
                            </label>

                            <select
                                id="new-member"
                                name="member_id"
                            >
                                <option value="">
                                    Tidak memilih anggota (nama manual)
                                </option>

                                @foreach($members as $member)
                                    <option
                                        value="{{ $member->id }}"
                                        @selected(
                                            (string) old('member_id') ===
                                            (string) $member->id
                                        )
                                    >
                                        {{ $member->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="struktur-field wide">
                            <label for="new-person">
                                Nama Manual
                            </label>

                            <input
                                id="new-person"
                                type="text"
                                name="person_name"
                                value="{{ old('person_name') }}"
                                maxlength="120"
                                placeholder="Isi jika tidak memilih akun anggota"
                            >

                            <p class="struktur-hint">
                                Wajib jika tidak memilih anggota ACC.
                                Tidak membuat akun atau NIA baru.
                            </p>
                        </div>

                        <div class="struktur-field wide">
                            <label for="new-description">
                                Keterangan
                            </label>

                            <input
                                id="new-description"
                                type="text"
                                name="description"
                                value="{{ old('description') }}"
                                maxlength="180"
                                placeholder="Contoh: Masa khidmat 2026–2028"
                            >
                        </div>

                        <div class="struktur-field">
                            <label for="new-level">
                                Tingkat
                            </label>

                            <select id="new-level" name="level">
                                <option
                                    value="1"
                                    @selected(old('level', '2') == '1')
                                >
                                    1 — Pimpinan
                                </option>

                                <option
                                    value="2"
                                    @selected(old('level', '2') == '2')
                                >
                                    2 — Pengurus Harian
                                </option>

                                <option
                                    value="3"
                                    @selected(old('level', '2') == '3')
                                >
                                    3 — Bidang
                                </option>
                            </select>
                        </div>

                        <div class="struktur-field">
                            <label for="new-order">
                                Urutan
                            </label>

                            <input
                                id="new-order"
                                type="number"
                                name="sort_order"
                                value="{{ old('sort_order', 1) }}"
                                min="0"
                                max="999"
                                required
                            >
                        </div>

                        <div class="struktur-field wide">

                            <input
                                type="hidden"
                                name="is_visible"
                                value="0"
                            >

                            <label class="struktur-check">
                                <input
                                    type="checkbox"
                                    name="is_visible"
                                    value="1"
                                    @checked(old('is_visible', '1') == '1')
                                >

                                Tampilkan posisi di halaman publik
                            </label>

                        </div>

                    </div>

                    <div class="struktur-form-actions">
                        <button
                            type="submit"
                            class="struktur-btn primary"
                        >
                            <i class="ph ph-plus"></i>
                            TAMBAH JABATAN
                        </button>
                    </div>

                </form>

            </section>

            <!-- =====================================
                 DAFTAR DAN EDIT JABATAN
            ====================================== -->
            <section class="struktur-panel">

                <div class="struktur-panel-head">
                    <h2>Susunan Pengurus</h2>

                    <p>
                        Klik salah satu jabatan untuk
                        mengubah data atau menghapus posisi.
                    </p>
                </div>

                <div class="struktur-entry-list">

                    @forelse($positions as $position)

                        <details
                            class="struktur-entry"
                            data-struktur-item
                            data-role="{{ $position->role }}"
                            data-name="{{ $position->member_name ?: $position->person_name ?: 'Belum diisi' }}"
                        >

                            <!-- RINGKASAN JABATAN -->
                            <summary>

                                <span class="struktur-entry-number">
                                    {{ str_pad((string) $loop->iteration, 2, '0', STR_PAD_LEFT) }}
                                </span>

                                <span class="struktur-entry-summary">

                                    <strong>
                                        {{ $position->role }}
                                    </strong>

                                    <small>
                                        {{ $position->member_name ?: $position->person_name ?: 'Belum diisi' }}
                                        · Tingkat {{ $position->level }}

                                        @unless($position->is_visible)
                                            · Disembunyikan
                                        @endunless
                                    </small>

                                </span>

                                <i class="ph ph-pencil-simple struktur-edit-icon"></i>

                            </summary>

                            <!-- FORM EDIT -->
                            <div class="struktur-entry-content">

                                <form
                                    method="POST"
                                    action="{{ route('admin.struktur.update', $position->id) }}"
                                >
                                    @csrf
                                    @method('PUT')

                                    <input
                                        type="hidden"
                                        name="banom"
                                        value="{{ $selected }}"
                                    >

                                    <div class="struktur-fields">

                                        <div class="struktur-field wide">
                                            <label for="role-{{ $position->id }}">
                                                Nama Jabatan
                                            </label>

                                            <input
                                                id="role-{{ $position->id }}"
                                                type="text"
                                                name="role"
                                                value="{{ $position->role }}"
                                                maxlength="100"
                                                required
                                            >
                                        </div>

                                        <div class="struktur-field wide">
                                            <label for="member-{{ $position->id }}">
                                                Anggota ACC
                                            </label>

                                            <select
                                                id="member-{{ $position->id }}"
                                                name="member_id"
                                            >
                                                <option value="">
                                                    Gunakan Nama Manual
                                                </option>

                                                @foreach($members as $member)

                                                    <option
                                                        value="{{ $member->id }}"
                                                        @selected(
                                                            (string) $position->member_id ===
                                                            (string) $member->id
                                                        )
                                                    >
                                                        {{ $member->name }}
                                                    </option>

                                                @endforeach
                                            </select>
                                        </div>

                                        <div class="struktur-field wide">
                                            <label for="person-{{ $position->id }}">
                                                Nama Manual
                                            </label>

                                            <input
                                                id="person-{{ $position->id }}"
                                                type="text"
                                                name="person_name"
                                                value="{{ $position->person_name }}"
                                                maxlength="120"
                                                placeholder="Isi jika tidak memilih anggota ACC"
                                            >
                                        </div>

                                        <div class="struktur-field wide">
                                            <label for="description-{{ $position->id }}">
                                                Keterangan
                                            </label>

                                            <input
                                                id="description-{{ $position->id }}"
                                                type="text"
                                                name="description"
                                                value="{{ $position->description }}"
                                                maxlength="180"
                                            >
                                        </div>

                                        <div class="struktur-field">
                                            <label for="level-{{ $position->id }}">
                                                Tingkat
                                            </label>

                                            <select
                                                id="level-{{ $position->id }}"
                                                name="level"
                                            >
                                                <option
                                                    value="1"
                                                    @selected((int) $position->level === 1)
                                                >
                                                    1 — Pimpinan
                                                </option>

                                                <option
                                                    value="2"
                                                    @selected((int) $position->level === 2)
                                                >
                                                    2 — Pengurus Harian
                                                </option>

                                                <option
                                                    value="3"
                                                    @selected((int) $position->level === 3)
                                                >
                                                    3 — Bidang
                                                </option>
                                            </select>
                                        </div>

                                        <div class="struktur-field">
                                            <label for="order-{{ $position->id }}">
                                                Urutan
                                            </label>

                                            <input
                                                id="order-{{ $position->id }}"
                                                type="number"
                                                name="sort_order"
                                                value="{{ $position->sort_order }}"
                                                min="0"
                                                max="999"
                                                required
                                            >
                                        </div>

                                        <div class="struktur-field wide">

                                            <input
                                                type="hidden"
                                                name="is_visible"
                                                value="0"
                                            >

                                            <label class="struktur-check">
                                                <input
                                                    type="checkbox"
                                                    name="is_visible"
                                                    value="1"
                                                    @checked((bool) $position->is_visible)
                                                >

                                                Tampilkan di Halaman Publik
                                            </label>

                                        </div>

                                    </div>

                                    <div class="struktur-form-actions">
                                        <button
                                            type="submit"
                                            class="struktur-btn primary"
                                        >
                                            <i class="ph ph-floppy-disk"></i>
                                            SIMPAN PERUBAHAN
                                        </button>
                                    </div>

                                </form>

                                <!-- HAPUS JABATAN -->
                                <form
                                    method="POST"
                                    action="{{ route('admin.struktur.destroy', $position->id) }}"
                                    onsubmit="return confirm('Yakin hapus jabatan ini? Data anggota tidak akan dihapus.')"
                                >
                                    @csrf
                                    @method('DELETE')

                                    <div class="struktur-form-actions">

                                        <button
                                            type="submit"
                                            class="struktur-btn danger"
                                        >
                                            <i class="ph ph-trash"></i>
                                            HAPUS JABATAN
                                        </button>

                                    </div>

                                </form>

                            </div>

                        </details>

                    @empty

                        <div class="struktur-empty">
                            Belum ada jabatan untuk Banom ini.
                            Tambahkan melalui formulir di sebelah.
                        </div>

                    @endforelse

                </div>

                <p class="struktur-info">
                    Setelah menyimpan, gunakan tombol
                    "Lihat Publik" untuk memastikan susunan
                    pengurus sudah sesuai.
                </p>

            </section>

        </div>

    </div>

    <!-- =====================================
         HALAMAN KHUSUS PRINT A4
    ====================================== -->
    <section
        class="struktur-print-only"
        aria-label="Lembar cetak struktur organisasi"
    >

        <header class="struktur-print-header">

            <p style="font-size:10px;font-weight:800;letter-spacing:.15em">
                PENGURUS RANTING NAHDLATUL ULAMA LESMANA
            </p>

            <h1>STRUKTUR ORGANISASI</h1>

            <p>
                {{ $banomLabels[$selected] ?? $selected }}
                · Dicetak {{ now()->format('d/m/Y') }}
            </p>

        </header>

        <table class="struktur-print-table">

            <thead>
                <tr>
                    <th style="width:9%">No.</th>
                    <th style="width:36%">Jabatan</th>
                    <th>Nama Pengurus</th>
                </tr>
            </thead>

            <tbody>
                @forelse($positions as $position)

                    <tr>
                        <td>{{ $loop->iteration }}</td>

                        <td>{{ $position->role }}</td>

                        <td>
                            {{ $position->member_name ?: $position->person_name ?: 'Belum diisi' }}
                        </td>
                    </tr>

                @empty

                    <tr>
                        <td colspan="3">
                            Belum ada jabatan untuk Banom ini.
                        </td>
                    </tr>

                @endforelse
            </tbody>

        </table>

        <p class="struktur-print-note">
            Sumber: Data Struktur Organisasi Dashboard Admin
            NU Lesmana.
        </p>

    </section>

</div>

@endsection

@push('scripts')
<script>
(function () {
    'use strict';

    const copyButton = document.getElementById(
        'struktur-copy-button'
    );

    const feedback = document.getElementById(
        'struktur-copy-feedback'
    );

    if (!copyButton || !feedback) {
        return;
    }

    const originalText = copyButton.innerHTML;

    copyButton.addEventListener('click', async function () {

        const organization = @json(
            $banomLabels[$selected] ?? $selected
        );

        const items = Array.from(
            document.querySelectorAll('[data-struktur-item]')
        );

        const lines = [
            'STRUKTUR ORGANISASI NU LESMANA',
            'Banom: ' + organization,
            ''
        ];

        if (items.length === 0) {
            lines.push('Belum ada pengurus.');
        } else {
            items.forEach(function (item, index) {
                const role = item.dataset.role || '-';
                const name = item.dataset.name || 'Belum diisi';

                lines.push(
                    (index + 1) + '. ' + role + ' — ' + name
                );
            });
        }

        const output = lines.join('\n');
        let copied = false;

        try {
            if (
                navigator.clipboard &&
                window.isSecureContext
            ) {
                await navigator.clipboard.writeText(output);
                copied = true;
            } else {
                const temporary = document.createElement('textarea');

                temporary.value = output;
                temporary.style.position = 'fixed';
                temporary.style.opacity = '0';

                document.body.appendChild(temporary);

                temporary.select();
                copied = document.execCommand('copy');

                temporary.remove();
            }
        } catch (error) {
            copied = false;
        }

        if (copied) {
            feedback.textContent =
                'Struktur berhasil disalin ke clipboard.';

            copyButton.textContent = 'BERHASIL DISALIN';
        } else {
            feedback.textContent =
                'Gagal menyalin. Periksa izin clipboard browser.';

            copyButton.textContent = 'GAGAL MENYALIN';
        }

        window.setTimeout(function () {
            copyButton.innerHTML = originalText;
        }, 2000);

    });

})();
</script>
@endpush
