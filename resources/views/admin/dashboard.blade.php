
@extends('layouts.admin')

@section('title', 'Dashboard Pengurus')
@section('heading', 'Dashboard Admin')
@section('subtitle', 'Pantau anggota, infaq, berita, dan ulasan dalam satu panel pengurus.')

@section('content')

@php
    $totalPending = \Illuminate\Support\Facades\Schema::hasTable('members')
        ? \App\Models\Member::query()
            ->where('status', 'pending')
            ->count()
        : 0;

    $totalReviews = \Illuminate\Support\Facades\Schema::hasTable('reviews')
        ? \App\Models\Review::query()->count()
        : 0;

    $approvedCount = (int) ($totalApprovedMembers ?? 0);
    $newsCount = (int) ($totalNews ?? 0);
    $cashBalance = (float) ($totalInfaq ?? 0);
@endphp

<style>
    .nu-dashboard {
        font-family: 'DM Sans', sans-serif;
        color: #183C2F;
    }

    /* ======================================
       STATISTIK
    ====================================== */

    .nu-dashboard-stats {
        display: grid;
        grid-template-columns: repeat(4, minmax(0, 1fr));
        gap: 15px;
        margin-bottom: 25px;
    }

    .nu-stat-card {
        min-width: 0;
        min-height: 194px;
        background: #FFFFFF;
        border: 1px solid #E2E8DF;
        border-radius: 20px;
        padding: 23px;
        display: flex;
        flex-direction: column;
        justify-content: space-between;
        transition:
            transform .2s ease,
            box-shadow .2s ease;
    }

    .nu-stat-card:hover {
        transform: translateY(-3px);
        box-shadow: 0 10px 24px rgba(24, 60, 47, .06);
    }

    .nu-stat-card.primary {
        background: #183C2F;
        border-color: #183C2F;
        color: #FFFFFF;
    }

    .nu-stat-card-top {
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
        gap: 12px;
    }

    .nu-stat-label {
        font-size: 12px;
        font-weight: 800;
        line-height: 1.5;
    }

    .nu-stat-icon {
        width: 37px;
        height: 37px;
        flex-shrink: 0;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 12px;
        background: #EAF0E9;
        font-size: 19px;
        color: #183C2F;
    }

    .nu-stat-card.primary .nu-stat-icon {
        background: rgba(255, 255, 255, .13);
        color: #FFFFFF;
    }

    .nu-stat-value {
        font-size: clamp(30px, 3vw, 43px);
        font-weight: 800;
        letter-spacing: -.06em;
        line-height: 1.1;
        margin-top: 15px;
        font-variant-numeric: tabular-nums;
    }

    .nu-stat-value.currency {
        font-size: clamp(22px, 2.1vw, 31px);
        overflow-wrap: anywhere;
    }

    .nu-stat-desc {
        font-size: 11px;
        margin-top: 8px;
        color: #788A7B;
        line-height: 1.6;
    }

    .nu-stat-card.primary .nu-stat-desc {
        color: #C6E0CE;
    }

    .nu-stat-footer {
        display: flex;
        justify-content: space-between;
        gap: 10px;
        align-items: flex-end;
        margin-top: 18px;
    }

    .nu-stat-link {
        font-size: 11px;
        font-weight: 800;
        color: #183C2F;
        display: inline-flex;
        align-items: center;
        gap: 5px;
    }

    .nu-stat-card.primary .nu-stat-link {
        color: #FFFFFF;
    }

    .nu-stat-link:hover {
        text-decoration: underline;
    }

    .nu-pending-badge {
        display: inline-block;
        border-radius: 100px;
        background: rgba(255, 255, 255, .13);
        padding: 7px 10px;
        font-size: 10px;
        font-weight: 800;
        color: #FFFFFF;
        margin-top: 12px;
    }

    /* ======================================
       KONTEN DASHBOARD
    ====================================== */

    .nu-dashboard-content {
        display: grid;
        grid-template-columns: minmax(0, 1.65fr) minmax(270px, .85fr);
        gap: 18px;
        align-items: start;
    }

    .nu-panel {
        min-width: 0;
        background: white;
        border: 1px solid #E2E8DF;
        border-radius: 21px;
        overflow: hidden;
    }

    .nu-panel-head {
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
        flex-wrap: wrap;
        gap: 15px;
        padding: 24px;
        border-bottom: 1px solid #E9EEE7;
    }

    .nu-panel-title {
        font-size: 17px;
        font-weight: 800;
        letter-spacing: -.03em;
    }

    .nu-panel-subtitle {
        font-size: 12px;
        line-height: 1.6;
        color: #78877B;
        margin-top: 6px;
    }

    .nu-panel-link {
        font-size: 11px;
        font-weight: 800;
        color: #183C2F;
        white-space: nowrap;
    }

    .nu-panel-link:hover {
        text-decoration: underline;
    }

    /* ======================================
       DAFTAR PENDAFTAR
    ====================================== */

    .nu-member-list {
        padding: 0 24px;
    }

    .nu-member-row {
        display: flex;
        align-items: center;
        gap: 13px;
        padding: 18px 0;
        border-bottom: 1px solid #EDF0EB;
    }

    .nu-member-row:last-child {
        border-bottom: none;
    }

    .nu-member-avatar {
        width: 43px;
        height: 43px;
        flex-shrink: 0;
        background: #EAF0E9;
        color: #183C2F;
        border-radius: 13px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: 800;
        font-size: 16px;
        overflow: hidden;
    }

    .nu-member-avatar img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    .nu-member-info {
        min-width: 0;
        flex: 1;
    }

    .nu-member-name {
        font-size: 13px;
        font-weight: 800;
        overflow-wrap: anywhere;
    }

    .nu-member-meta {
        font-size: 11px;
        color: #839185;
        margin-top: 4px;
    }

    .nu-member-status {
        display: inline-block;
        background: #FFF1DC;
        color: #94662A;
        padding: 4px 8px;
        border-radius: 100px;
        font-size: 10px;
        font-weight: 800;
        margin-top: 6px;
    }

    .nu-member-actions {
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .nu-member-actions form {
        margin: 0;
    }

    .nu-action-btn {
        padding: 10px 13px;
        border-radius: 10px;
        font-size: 11px;
        font-weight: 800;
        border: 1px solid #E1E7DF;
        cursor: pointer;
        background: white;
    }

    .nu-action-btn.approve {
        background: #183C2F;
        color: white;
        border-color: #183C2F;
    }

    .nu-action-btn.reject {
        color: #A74242;
    }

    .nu-action-btn:hover {
        filter: brightness(.95);
    }

    .nu-empty-state {
        padding: 48px 20px;
        text-align: center;
        color: #79887D;
        font-size: 13px;
        line-height: 1.7;
    }

    .nu-empty-state i {
        display: block;
        font-size: 34px;
        margin-bottom: 12px;
        color: #183C2F;
    }

    /* ======================================
       AKSES CEPAT
    ====================================== */

    .nu-quick-list {
        padding: 8px 24px 18px;
    }

    .nu-quick-link {
        display: flex;
        align-items: center;
        gap: 12px;
        border-bottom: 1px solid #E8EEE5;
        padding: 16px 0;
        color: #183C2F;
        font-size: 12px;
        font-weight: 800;
    }

    .nu-quick-link:last-child {
        border-bottom: none;
    }

    .nu-quick-link:hover {
        color: #427356;
    }

    .nu-quick-icon {
        width: 33px;
        height: 33px;
        background: #EFF3EC;
        border-radius: 10px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 18px;
    }

    .nu-quick-arrow {
        margin-left: auto;
        font-size: 16px;
    }

    /* ======================================
       FINANCE WIDGET
    ====================================== */

    .nu-finance {
        margin: 0 20px 20px;
        padding: 23px;
        border-radius: 17px;
        background: #183C2F;
        color: white;
    }

    .nu-finance-label {
        font-size: 10px;
        font-weight: 800;
        letter-spacing: .16em;
        text-transform: uppercase;
        color: #C2D9C9;
    }

    .nu-finance-balance {
        font-size: clamp(24px, 2.5vw, 36px);
        font-weight: 800;
        letter-spacing: -.05em;
        margin: 14px 0 8px;
        overflow-wrap: anywhere;
    }

    .nu-finance-desc {
        font-size: 11px;
        line-height: 1.7;
        color: #C3DCCB;
    }

    .nu-finance-button {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        background: #F5F4F0;
        color: #183C2F;
        border-radius: 10px;
        padding: 11px 14px;
        margin-top: 18px;
        font-size: 11px;
        font-weight: 800;
    }

    .nu-finance-button:hover {
        background: #E6EEE4;
    }

    /* ======================================
       RESPONSIVE
    ====================================== */

    @media (max-width: 1200px) {
        .nu-dashboard-stats {
            grid-template-columns: repeat(2, minmax(0, 1fr));
        }
    }

    @media (max-width: 1050px) {
        .nu-dashboard-content {
            grid-template-columns: 1fr;
        }
    }

    @media (max-width: 580px) {
        .nu-dashboard-stats {
            grid-template-columns: 1fr;
            gap: 12px;
        }

        .nu-stat-card {
            min-height: 165px;
        }

        .nu-member-row {
            flex-wrap: wrap;
            align-items: flex-start;
        }

        .nu-member-info {
            flex-basis: calc(100% - 60px);
        }

        .nu-member-actions {
            padding-left: 56px;
        }

        .nu-panel-head {
            padding: 19px;
        }

        .nu-member-list {
            padding: 0 19px;
        }

        .nu-quick-list {
            padding: 8px 19px 18px;
        }
    }
</style>

<div class="nu-dashboard">

    <!-- ======================================
         4 KARTU STATISTIK
    ====================================== -->
    <section class="nu-dashboard-stats">

        <!-- ANGGOTA DAN PENDAFTARAN DIGABUNG -->
        <article class="nu-stat-card primary">

            <div>
                <div class="nu-stat-card-top">

                    <span class="nu-stat-label">
                        Kelola Anggota
                    </span>

                    <span class="nu-stat-icon">
                        <i class="ph ph-users-three"></i>
                    </span>

                </div>

                <p class="nu-stat-value">
                    {{ number_format($approvedCount, 0, ',', '.') }}
                </p>

                <p class="nu-stat-desc">
                    Anggota resmi terverifikasi
                </p>

                <span class="nu-pending-badge">
                    {{ $totalPending }} menunggu ACC
                </span>
            </div>

            <div class="nu-stat-footer">

                <a
                    href="{{ route('admin.members.index') }}"
                    class="nu-stat-link"
                >
                    Kelola & verifikasi anggota
                    <i class="ph ph-arrow-up-right"></i>
                </a>

            </div>
        </article>

        <!-- INFAQ -->
        <article class="nu-stat-card">

            <div>
                <div class="nu-stat-card-top">

                    <span class="nu-stat-label">
                        Saldo Infaq / Kas
                    </span>

                    <span class="nu-stat-icon">
                        <i class="ph ph-wallet"></i>
                    </span>

                </div>

                <p class="nu-stat-value currency">
                    Rp {{ number_format($cashBalance, 0, ',', '.') }}
                </p>

                <p class="nu-stat-desc">
                    Saldo bersih berdasarkan transaksi kas
                </p>
            </div>

            <div class="nu-stat-footer">

                <a
                    href="{{ route('admin.infaq.index') }}"
                    class="nu-stat-link"
                >
                    Lihat grafik & kas
                    <i class="ph ph-arrow-up-right"></i>
                </a>

            </div>
        </article>

        <!-- BERITA -->
        <article class="nu-stat-card">

            <div>
                <div class="nu-stat-card-top">

                    <span class="nu-stat-label">
                        Berita Terpublikasi
                    </span>

                    <span class="nu-stat-icon">
                        <i class="ph ph-newspaper"></i>
                    </span>

                </div>

                <p class="nu-stat-value">
                    {{ number_format($newsCount, 0, ',', '.') }}
                </p>

                <p class="nu-stat-desc">
                    Berita dan agenda yang tersimpan
                </p>
            </div>

            <div class="nu-stat-footer">

                <a
                    href="{{ route('admin.news.index') }}"
                    class="nu-stat-link"
                >
                    Kelola berita
                    <i class="ph ph-arrow-up-right"></i>
                </a>

            </div>
        </article>

        <!-- ULASAN WARGA -->
        <article class="nu-stat-card">

            <div>
                <div class="nu-stat-card-top">

                    <span class="nu-stat-label">
                        Ulasan Warga
                    </span>

                    <span class="nu-stat-icon">
                        <i class="ph ph-chat-circle-text"></i>
                    </span>

                </div>

                <p class="nu-stat-value">
                    {{ number_format($totalReviews, 0, ',', '.') }}
                </p>

                <p class="nu-stat-desc">
                    Penilaian dan aspirasi warga
                </p>
            </div>

            <div class="nu-stat-footer">

                @if(\Illuminate\Support\Facades\Route::has('admin.reviews.index'))

                    <a
                        href="{{ route('admin.reviews.index') }}"
                        class="nu-stat-link"
                    >
                        Moderasi ulasan
                        <i class="ph ph-arrow-up-right"></i>
                    </a>

                @else

                    <span class="nu-stat-desc">
                        Fitur moderasi belum tersedia
                    </span>

                @endif

            </div>
        </article>

    </section>

    <!-- ======================================
         KONTEN UTAMA
    ====================================== -->
    <div class="nu-dashboard-content">

        <!-- ANGGOTA DAN VERIFIKASI -->
        <section class="nu-panel">

            <div class="nu-panel-head">

                <div>
                    <h2 class="nu-panel-title">
                        Kelola Anggota & Verifikasi
                    </h2>

                    <p class="nu-panel-subtitle">
                        Data pendaftaran, antrean ACC,
                        dan pengelolaan KIA berada dalam satu modul.
                    </p>
                </div>

                <a
                    href="{{ route('admin.members.index') }}"
                    class="nu-panel-link"
                >
                    Lihat semua
                    <i class="ph ph-arrow-up-right"></i>
                </a>

            </div>

            <div class="nu-member-list">

                @forelse(($pendingMembers ?? collect()) as $member)

                    <article class="nu-member-row">

                        <!-- FOTO / AVATAR -->
                        <div class="nu-member-avatar">

                            @if(!empty($member->photo))

                                <img
                                    src="{{ \Illuminate\Support\Facades\Storage::disk('public')->url($member->photo) }}"
                                    alt="Foto {{ $member->name }}"
                                    loading="lazy"
                                >

                            @else

                                {{ mb_strtoupper(mb_substr($member->name ?: 'A', 0, 1)) }}

                            @endif

                        </div>

                        <!-- IDENTITAS -->
                        <div class="nu-member-info">

                            <h3 class="nu-member-name">
                                {{ $member->name }}
                            </h3>

                            <p class="nu-member-meta">
                                {{ $member->banom ?? 'Belum memilih Banom' }}
                            </p>

                            <span class="nu-member-status">
                                Menunggu verifikasi
                            </span>

                        </div>

                        <!-- TOMBOL ACC / TOLAK -->
                        <div class="nu-member-actions">

                            <form
                                action="{{ route('admin.members.approve', $member->id) }}"
                                method="POST"
                            >
                                @csrf
                                @method('PATCH')

                                <button
                                    type="submit"
                                    class="nu-action-btn approve"
                                >
                                    ACC
                                </button>
                            </form>

                            <form
                                action="{{ route('admin.members.reject', $member->id) }}"
                                method="POST"
                                onsubmit="return confirm('Yakin menolak pendaftaran anggota ini?')"
                            >
                                @csrf
                                @method('DELETE')

                                <button
                                    type="submit"
                                    class="nu-action-btn reject"
                                >
                                    Tolak
                                </button>
                            </form>

                        </div>

                    </article>

                @empty

                    <div class="nu-empty-state">

                        <i class="ph ph-check-circle"></i>

                        <p class="font-bold text-[#183C2F]">
                            Semua pendaftaran sudah diperiksa
                        </p>

                        <p>
                            Tidak ada anggota yang menunggu ACC.
                        </p>

                    </div>

                @endforelse

            </div>

        </section>

        <!-- AKSES CEPAT -->
        <aside class="nu-panel">

            <div class="nu-panel-head">

                <div>
                    <h2 class="nu-panel-title">
                        Akses Cepat
                    </h2>

                    <p class="nu-panel-subtitle">
                        Buka modul pengelolaan Nulesmana.
                    </p>
                </div>

            </div>

            <div class="nu-quick-list">

                <!-- ANGGOTA -->
                <a
                    href="{{ route('admin.members.index') }}"
                    class="nu-quick-link"
                >
                    <span class="nu-quick-icon">
                        <i class="ph ph-users-three"></i>
                    </span>

                    Kelola Anggota

                    <i class="ph ph-arrow-up-right nu-quick-arrow"></i>
                </a>

                <!-- INFAQ -->
                <a
                    href="{{ route('admin.infaq.index') }}"
                    class="nu-quick-link"
                >
                    <span class="nu-quick-icon">
                        <i class="ph ph-chart-line-up"></i>
                    </span>

                    Grafik Infaq / Kas

                    <i class="ph ph-arrow-up-right nu-quick-arrow"></i>
                </a>

                <!-- BERITA -->
                <a
                    href="{{ route('admin.news.index') }}"
                    class="nu-quick-link"
                >
                    <span class="nu-quick-icon">
                        <i class="ph ph-newspaper"></i>
                    </span>

                    Kelola Berita

                    <i class="ph ph-arrow-up-right nu-quick-arrow"></i>
                </a>

                <!-- STRUKTUR -->
                @if(\Illuminate\Support\Facades\Route::has('admin.struktur.index'))

                    <a
                        href="{{ route('admin.struktur.index') }}"
                        class="nu-quick-link"
                    >
                        <span class="nu-quick-icon">
                            <i class="ph ph-tree-structure"></i>
                        </span>

                        Kelola Struktur

                        <i class="ph ph-arrow-up-right nu-quick-arrow"></i>
                    </a>

                @endif

                <!-- ULASAN -->
                @if(\Illuminate\Support\Facades\Route::has('admin.reviews.index'))

                    <a
                        href="{{ route('admin.reviews.index') }}"
                        class="nu-quick-link"
                    >
                        <span class="nu-quick-icon">
                            <i class="ph ph-chat-circle-text"></i>
                        </span>

                        Kelola Ulasan

                        <i class="ph ph-arrow-up-right nu-quick-arrow"></i>
                    </a>

                @endif

            </div>

            <!-- RINGKASAN FINANCE -->
            <div class="nu-finance">

                <p class="nu-finance-label">
                    Finance Overview / NU Lesmana
                </p>

                <p class="nu-finance-balance">
                    Rp {{ number_format($cashBalance, 0, ',', '.') }}
                </p>

                <p class="nu-finance-desc">
                    Total saldo dari transaksi pemasukan
                    dan pengeluaran yang dicatat pengurus.
                </p>

                <a
                    href="{{ route('admin.infaq.index') }}"
                    class="nu-finance-button"
                >
                    Buka analisis infaq

                    <i class="ph ph-arrow-up-right"></i>
                </a>

            </div>

        </aside>

    </div>

</div>

@endsection
