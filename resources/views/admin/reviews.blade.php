
@extends('layouts.admin')

@section('title', 'Kelola Ulasan Warga')
@section('heading', 'Kelola Ulasan Warga')
@section('subtitle', 'Pantau penilaian, moderasi ulasan, dan kelola aspirasi warga NU Lesmana')

@section('content')

<style>
    .reviews-page {
        --forest: #183C2F;
        --ivory: #F5F4F0;
        --line: #E3E8E0;
        --muted: #758377;
        --gold: #BD8732;

        font-family: 'DM Sans', sans-serif;
        color: var(--forest);
    }

    .reviews-header {
        display: flex;
        align-items: flex-end;
        justify-content: space-between;
        flex-wrap: wrap;
        gap: 18px;
        margin-bottom: 27px;
    }

    .reviews-eyebrow {
        font-size: 11px;
        font-weight: 800;
        text-transform: uppercase;
        letter-spacing: .17em;
        color: #7A8C7C;
    }

    .reviews-title {
        font-size: clamp(29px, 4vw, 46px);
        line-height: 1.08;
        letter-spacing: -.05em;
        font-weight: 800;
        margin-top: 8px;
    }

    .reviews-description {
        font-size: 13px;
        color: #6D7D70;
        margin-top: 10px;
        line-height: 1.7;
    }

    .reviews-website {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
        background: var(--forest);
        color: #fff;
        border-radius: 12px;
        padding: 13px 19px;
        font-size: 12px;
        font-weight: 800;
        text-decoration: none;
        transition: background .2s;
    }

    .reviews-website:hover {
        background: #2B5542;
        color: white;
    }

    .reviews-stats {
        display: grid;
        grid-template-columns: repeat(4, minmax(0, 1fr));
        gap: 14px;
        margin-bottom: 25px;
    }

    .reviews-stat {
        min-height: 150px;
        background: white;
        border: 1px solid var(--line);
        border-radius: 21px;
        padding: 22px;
        display: flex;
        flex-direction: column;
        justify-content: space-between;
        gap: 20px;
    }

    .reviews-stat.primary {
        background: var(--forest);
        color: white;
        border-color: var(--forest);
    }

    .reviews-stat-label {
        font-size: 11px;
        text-transform: uppercase;
        font-weight: 800;
        letter-spacing: .10em;
        opacity: .75;
    }

    .reviews-stat-number {
        font-size: clamp(30px, 3vw, 42px);
        line-height: 1;
        font-weight: 800;
        letter-spacing: -.05em;
        font-variant-numeric: tabular-nums;
    }

    .reviews-stat-note {
        font-size: 11px;
        margin-top: 8px;
        opacity: .7;
    }

    .reviews-filter-panel {
        background: white;
        border: 1px solid var(--line);
        border-radius: 20px;
        padding: 20px;
        margin-bottom: 22px;
    }

    .reviews-filters {
        display: flex;
        align-items: center;
        justify-content: space-between;
        flex-wrap: wrap;
        gap: 15px;
    }

    .reviews-tabs {
        display: flex;
        flex-wrap: wrap;
        gap: 7px;
    }

    .reviews-tab {
        display: inline-flex;
        align-items: center;
        padding: 10px 14px;
        border-radius: 10px;
        background: var(--ivory);
        color: #647568;
        font-size: 12px;
        font-weight: 800;
        text-decoration: none;
    }

    .reviews-tab.active {
        background: var(--forest);
        color: white;
    }

    .reviews-tab:hover {
        opacity: .85;
    }

    .reviews-search {
        display: flex;
        align-items: center;
        gap: 8px;
        flex: 1;
        max-width: 390px;
    }

    .reviews-search input {
        width: 100%;
        min-width: 0;
        padding: 11px 13px;
        border: 1px solid #DDE4DA;
        border-radius: 11px;
        background: #F8F9F6;
        font-size: 12px;
        color: var(--forest);
        outline: none;
    }

    .reviews-search input:focus {
        border-color: var(--forest);
        box-shadow: 0 0 0 3px rgba(24, 60, 47, .08);
    }

    .reviews-search button {
        padding: 11px 15px;
        border-radius: 11px;
        background: var(--forest);
        color: white;
        font-size: 12px;
        font-weight: 800;
        border: none;
        cursor: pointer;
    }

    .reviews-list-title {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 10px;
        margin-bottom: 15px;
    }

    .reviews-list-title h2 {
        font-size: 18px;
        font-weight: 800;
    }

    .reviews-list-title p {
        font-size: 12px;
        color: var(--muted);
    }

    .reviews-list {
        display: grid;
        grid-template-columns: repeat(2, minmax(0, 1fr));
        gap: 15px;
    }

    .review-item {
        min-width: 0;
        display: flex;
        flex-direction: column;
        background: white;
        border: 1px solid var(--line);
        border-radius: 21px;
        padding: 23px;
        transition: border-color .2s, box-shadow .2s;
    }

    .review-item:hover {
        border-color: #C3D4C4;
        box-shadow: 0 8px 25px rgba(24, 60, 47, .04);
    }

    .review-item.is-hidden {
        background: #F7F8F5;
    }

    .review-profile {
        display: flex;
        align-items: center;
        gap: 12px;
    }

    .review-avatar {
        flex-shrink: 0;
        display: flex;
        align-items: center;
        justify-content: center;
        width: 45px;
        height: 45px;
        border-radius: 14px;
        background: var(--forest);
        color: white;
        font-size: 17px;
        font-weight: 800;
    }

    .review-profile-info {
        flex: 1;
        min-width: 0;
    }

    .review-name {
        font-size: 13px;
        font-weight: 800;
        overflow-wrap: anywhere;
    }

    .review-date {
        font-size: 11px;
        color: #809083;
        margin-top: 3px;
    }

    .review-status {
        flex-shrink: 0;
        padding: 7px 10px;
        border-radius: 999px;
        background: #E9F1E8;
        color: var(--forest);
        font-size: 10px;
        font-weight: 800;
    }

    .review-status.hidden {
        background: #F5E9E8;
        color: #A14B44;
    }

    .review-stars {
        display: flex;
        gap: 3px;
        margin-top: 19px;
        font-size: 23px;
        line-height: 1;
    }

    .review-message {
        margin-top: 15px;
        margin-bottom: 24px;
        font-size: 13px;
        line-height: 1.8;
        color: #42594A;
        white-space: pre-line;
        overflow-wrap: anywhere;
        flex: 1;
    }

    .review-footer {
        display: flex;
        align-items: center;
        justify-content: space-between;
        flex-wrap: wrap;
        gap: 12px;
        border-top: 1px solid var(--line);
        padding-top: 16px;
    }

    .review-footer-label {
        font-size: 10px;
        text-transform: uppercase;
        letter-spacing: .12em;
        font-weight: 800;
        color: #89978B;
    }

    .review-actions {
        display: flex;
        flex-wrap: wrap;
        gap: 8px;
    }

    .review-actions form {
        margin: 0;
    }

    .review-button {
        padding: 10px 13px;
        border-radius: 10px;
        border: 1px solid var(--line);
        background: var(--ivory);
        color: var(--forest);
        font-size: 11px;
        font-weight: 800;
        cursor: pointer;
    }

    .review-button.show {
        background: var(--forest);
        color: white;
        border-color: var(--forest);
    }

    .review-button.delete {
        color: #B33C3C;
        background: #FFF7F7;
        border-color: #F1DADA;
    }

    .review-button:hover {
        filter: brightness(.96);
    }

    .reviews-alert {
        border: 1px solid #B9D5BF;
        background: #EBF4EA;
        color: var(--forest);
        padding: 15px 18px;
        border-radius: 13px;
        margin-bottom: 22px;
        font-size: 13px;
        font-weight: 700;
    }

    .reviews-empty {
        grid-column: 1 / -1;
        padding: 65px 20px;
        background: white;
        border: 1px solid var(--line);
        border-radius: 22px;
        text-align: center;
    }

    .reviews-empty h3 {
        font-size: 20px;
        font-weight: 800;
    }

    .reviews-empty p {
        font-size: 13px;
        color: var(--muted);
        margin-top: 9px;
    }

    .reviews-pagination {
        margin-top: 24px;
    }

    @media (max-width: 1050px) {
        .reviews-stats {
            grid-template-columns: repeat(2, minmax(0, 1fr));
        }
    }

    @media (max-width: 750px) {
        .reviews-list {
            grid-template-columns: 1fr;
        }

        .reviews-search {
            max-width: none;
            width: 100%;
        }
    }

    @media (max-width: 480px) {
        .reviews-stats {
            gap: 9px;
        }

        .reviews-stat {
            padding: 17px;
            min-height: 130px;
        }

        .review-item {
            padding: 18px;
        }

        .reviews-title {
            font-size: 31px;
        }
    }
</style>

<div class="reviews-page">

    <!-- HEADER -->
    <header class="reviews-header">
        <div>
            <p class="reviews-eyebrow">
                Admin Panel / Feedback Management
            </p>

            <h1 class="reviews-title">
                KELOLA ULASAN.
            </h1>

            <p class="reviews-description">
                Moderasi penilaian, pengalaman, dan aspirasi
                warga NU Lesmana.
            </p>
        </div>

        <a
            href="{{ route('home') }}#saran"
            target="_blank"
            rel="noopener noreferrer"
            class="reviews-website"
        >
            <i class="ph ph-arrow-square-out"></i>
            Lihat Ulasan Publik
        </a>
    </header>

    <!-- NOTIFIKASI -->
    @if(session('success'))
        <div class="reviews-alert" role="status">
            <i class="ph ph-check-circle"></i>
            {{ session('success') }}
        </div>
    @endif

    <!-- KARTU STATISTIK -->
    <section class="reviews-stats">

        <div class="reviews-stat primary">
            <span class="reviews-stat-label">
                Total Ulasan Warga
            </span>

            <div>
                <div class="reviews-stat-number">
                    {{ number_format($totalReviews, 0, ',', '.') }}
                </div>

                <p class="reviews-stat-note">
                    Seluruh ulasan yang masuk
                </p>
            </div>
        </div>

        <div class="reviews-stat">
            <span class="reviews-stat-label">
                Ulasan Ditampilkan
            </span>

            <div>
                <div class="reviews-stat-number">
                    {{ number_format($visibleReviews, 0, ',', '.') }}
                </div>

                <p class="reviews-stat-note">
                    Terlihat di website publik
                </p>
            </div>
        </div>

        <div class="reviews-stat">
            <span class="reviews-stat-label">
                Ulasan Disembunyikan
            </span>

            <div>
                <div class="reviews-stat-number">
                    {{ number_format($hiddenReviews, 0, ',', '.') }}
                </div>

                <p class="reviews-stat-note">
                    Tidak tampil untuk pengunjung
                </p>
            </div>
        </div>

        <div class="reviews-stat">
            <span class="reviews-stat-label">
                Rata-rata Penilaian
            </span>

            <div>
                <div class="reviews-stat-number">
                    {{ number_format($averageRating, 1, ',', '.') }}
                    <span style="color:#BD8732;font-size:25px;">★</span>
                </div>

                <p class="reviews-stat-note">
                    Dari maksimal 5 bintang
                </p>
            </div>
        </div>

    </section>

    <!-- FILTER DAN PENCARIAN -->
    <section class="reviews-filter-panel">

        <div class="reviews-filters">

            <nav class="reviews-tabs" aria-label="Filter ulasan">

                <a
                    href="{{ route('admin.reviews.index', ['status' => 'all', 'search' => $search]) }}"
                    class="reviews-tab {{ $status === 'all' ? 'active' : '' }}"
                >
                    Semua ({{ $totalReviews }})
                </a>

                <a
                    href="{{ route('admin.reviews.index', ['status' => 'visible', 'search' => $search]) }}"
                    class="reviews-tab {{ $status === 'visible' ? 'active' : '' }}"
                >
                    Tampil ({{ $visibleReviews }})
                </a>

                <a
                    href="{{ route('admin.reviews.index', ['status' => 'hidden', 'search' => $search]) }}"
                    class="reviews-tab {{ $status === 'hidden' ? 'active' : '' }}"
                >
                    Tersembunyi ({{ $hiddenReviews }})
                </a>

            </nav>

            <form
                action="{{ route('admin.reviews.index') }}"
                method="GET"
                class="reviews-search"
            >
                <input
                    type="hidden"
                    name="status"
                    value="{{ $status }}"
                >

                <input
                    type="search"
                    name="search"
                    maxlength="100"
                    value="{{ $search }}"
                    placeholder="Cari nama atau isi ulasan..."
                    aria-label="Cari ulasan"
                >

                <button type="submit">
                    Cari
                </button>
            </form>

        </div>

    </section>

    <!-- DAFTAR ULASAN -->
    <section>
        <div class="reviews-list-title">
            <h2>Daftar Ulasan</h2>

            <p>
                {{ $reviews->total() }} hasil ditemukan
            </p>
        </div>

        <div class="reviews-list">

            @forelse ($reviews as $review)

                @php
                    $reviewName = trim(
                        $review->name ?: 'Anonim'
                    );

                    $initial = mb_strtoupper(
                        mb_substr($reviewName, 0, 1)
                    );

                    $rating = max(
                        1,
                        min(5, (int) $review->rating)
                    );
                @endphp

                <article class="review-item {{ $review->is_visible ? '' : 'is-hidden' }}">

                    <!-- PROFIL -->
                    <div class="review-profile">

                        <div class="review-avatar" aria-hidden="true">
                            {{ $initial }}
                        </div>

                        <div class="review-profile-info">

                            <h3 class="review-name">
                                {{ $reviewName }}
                            </h3>

                            <p class="review-date">
                                {{ $review->created_at?->format('d M Y, H:i') }}
                            </p>

                        </div>

                        <span class="review-status {{ $review->is_visible ? '' : 'hidden' }}">

                            {{ $review->is_visible ? 'Ditampilkan' : 'Disembunyikan' }}

                        </span>

                    </div>

                    <!-- RATING -->
                    <div
                        class="review-stars"
                        role="img"
                        aria-label="{{ $rating }} dari 5 bintang"
                    >
                        @for ($star = 1; $star <= 5; $star++)

                            <span
                                aria-hidden="true"
                                style="color:{{ $star <= $rating ? '#BD8732' : '#D6DFD5' }}"
                            >
                                ★
                            </span>

                        @endfor
                    </div>

                    <!-- ISI ULASAN -->
                    <p class="review-message">
                        {{ $review->message }}
                    </p>

                    <!-- TOMBOL AKSI -->
                    <div class="review-footer">

                        <span class="review-footer-label">
                            {{ $review->is_verified_member ? 'Anggota Terverifikasi' : 'Pengunjung' }}
                        </span>

                        <div class="review-actions">

                            <!-- SEMBUNYIKAN / TAMPILKAN -->
                            <form
                                action="{{ route('admin.reviews.visibility', $review) }}"
                                method="POST"
                            >
                                @csrf
                                @method('PATCH')

                                <button
                                    type="submit"
                                    class="review-button {{ $review->is_visible ? '' : 'show' }}"
                                >
                                    @if ($review->is_visible)
                                        Sembunyikan
                                    @else
                                        Tampilkan Lagi
                                    @endif
                                </button>
                            </form>

                            <!-- HAPUS -->
                            <form
                                action="{{ route('admin.reviews.destroy', $review) }}"
                                method="POST"
                                onsubmit="return confirm('Hapus ulasan ini secara permanen? Tindakan ini tidak bisa dibatalkan.')"
                            >
                                @csrf
                                @method('DELETE')

                                <button
                                    type="submit"
                                    class="review-button delete"
                                >
                                    Hapus
                                </button>
                            </form>

                        </div>

                    </div>

                </article>

            @empty

                <div class="reviews-empty">
                    <h3>Belum ada ulasan ditemukan.</h3>

                    <p>
                        Ulasan yang sesuai dengan filter
                        atau pencarian akan muncul di sini.
                    </p>
                </div>

            @endforelse

        </div>

        <!-- PAGINATION -->
        @if ($reviews->hasPages())
            <div class="reviews-pagination">
                {{ $reviews->links() }}
            </div>
        @endif

    </section>

</div>

@endsection
