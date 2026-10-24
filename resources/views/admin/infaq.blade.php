
@extends('layouts.admin')

@section('title', 'Kelola Infaq & Kas')
@section('heading', 'Kelola Infaq & Kas')
@section('subtitle', 'Pantau arus kas, pertumbuhan infaq, dan catat transaksi ranting')

@section('content')

@php
    $saldoKas = (float) ($totalInfaq ?? 0);
    $pemasukan = (float) ($infaqMasuk ?? 0);
    $pengeluaran = (float) ($infaqKeluar ?? 0);

    $persenKasTersisa = $pemasukan > 0
        ? max(0, round($saldoKas / $pemasukan * 100, 1))
        : 0;

    $chartTransactions = $infaqTransactions->map(fn ($t) => [
        'date' => $t->created_at?->format('Y-m-d'),
        'type' => (string) $t->type,
        'amount' => (float) $t->amount,
    ])->values();
@endphp

<style>
    .nl-funds {
        font-family: 'DM Sans', ui-sans-serif, system-ui, sans-serif;
        color: #183C2F;
    }

    .nl-funds .nl-soft {
        background: #F5F4F0;
        border: 1px solid #E5E9E2;
    }

    .nl-funds .nl-stat {
        padding: 22px;
        border-radius: 22px;
        min-width: 0;
    }

    .nl-funds .nl-label {
        font-size: 11px;
        font-weight: 800;
        letter-spacing: .12em;
        text-transform: uppercase;
    }

    .nl-funds .nl-number {
        font-size: clamp(20px, 2.5vw, 31px);
        font-weight: 850;
        letter-spacing: -.055em;
        line-height: 1.2;
        overflow-wrap: anywhere;
    }

    .nl-funds .nl-pill {
        display: inline-flex;
        align-items: center;
        gap: 5px;
        padding: 6px 10px;
        border-radius: 100px;
        font-size: 11px;
        font-weight: 800;
    }

    .nl-funds .nl-chart-card {
        background: #132B22;
        border: 1px solid #29463A;
        color: white;
        border-radius: 25px;
        padding: 24px;
        overflow: hidden;
    }

    .nl-funds .nl-period {
        font-size: 11px;
        font-weight: 800;
        padding: 9px 13px;
        border: 1px solid #385448;
        border-radius: 12px;
        background: transparent;
        color: #D6E2D7;
        cursor: pointer;
    }

    .nl-funds .nl-period[aria-pressed='true'] {
        color: #183C2F;
        background: #E6F0E4;
        border-color: #E6F0E4;
    }

    .nl-funds .nl-input {
        background: white;
        width: 100%;
        border: 1px solid #D9E0D6;
        border-radius: 13px;
        padding: 13px 15px;
        outline: none;
        color: #183C2F;
        font-size: 13px;
        font-weight: 650;
    }

    .nl-funds .nl-input:focus {
        border-color: #183C2F;
        box-shadow: 0 0 0 3px rgba(24, 60, 47, .10);
    }

    .nl-funds .nl-transaction {
        display: flex;
        gap: 12px;
        align-items: center;
        justify-content: space-between;
        padding: 15px 0;
        border-bottom: 1px solid #E9EEE6;
    }

    .nl-funds .nl-transaction:last-child {
        border-bottom: 0;
    }

    .nl-funds .nl-muted {
        color: #79877D;
    }

    .nl-funds .nl-chart-wrap {
        position: relative;
        height: 310px;
        min-height: 310px;
    }

    .nl-funds .nl-flow-chart-wrap {
        position: relative;
        height: 210px;
        min-height: 210px;
    }

    @media (max-width: 640px) {
        .nl-funds .nl-chart-card {
            padding: 18px 14px;
        }

        .nl-funds .nl-chart-wrap {
            height: 240px;
            min-height: 240px;
        }

        .nl-funds .nl-period {
            padding: 8px 10px;
        }
    }

    @media print {
        .nl-funds .nl-no-print,
        .nl-funds form,
        .nl-funds button {
            display: none !important;
        }

        .nl-funds .nl-chart-card {
            background: white !important;
            color: #183C2F !important;
            border-color: #D9E0D6 !important;
        }

        .nl-funds .nl-chart-card * {
            color: #183C2F;
        }

        .nl-funds .nl-chart-wrap {
            height: 210px;
            min-height: 210px;
        }
    }
</style>

<div class="nl-funds space-y-6">

    <!-- NOTIFIKASI -->
    @if (session('success'))
        <div
            class="rounded-2xl bg-[#E5F0E6] border border-[#BAD4BC] px-5 py-4 text-sm font-bold text-[#183C2F]"
            role="status"
        >
            <i class="ph ph-check-circle mr-2"></i>
            {{ session('success') }}
        </div>
    @endif

    @if ($errors->any())
        <div
            class="rounded-2xl bg-red-50 border border-red-200 px-5 py-4 text-sm text-red-800"
            role="alert"
        >
            <p class="font-bold mb-2">
                Transaksi belum bisa disimpan:
            </p>

            <ul class="list-disc pl-5 space-y-1">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <!-- HEADER FINANCE -->
    <div class="flex flex-col sm:flex-row sm:items-end sm:justify-between gap-4">
        <div>
            <p class="text-[11px] uppercase tracking-[.19em] font-extrabold text-[#7A8D7F]">
                Finance Overview / NU Lesmana
            </p>

            <h2 class="text-3xl sm:text-4xl font-black tracking-[-.06em] text-[#183C2F] mt-1">
                ANALISIS INFAQ.
            </h2>

            <p class="text-xs sm:text-sm text-[#64756A] mt-2">
                Semua angka berasal dari transaksi kas yang sudah dicatat admin.
            </p>
        </div>

        <button
            type="button"
            onclick="window.print()"
            class="nl-no-print rounded-full border border-[#CED9CE] px-5 py-3 text-xs font-extrabold hover:bg-[#EDF3EB] transition self-start"
        >
            <i class="ph ph-printer mr-2"></i>
            Cetak laporan
        </button>
    </div>

    <!-- STATISTIK KEUANGAN -->
    <div class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-4 gap-3 sm:gap-4">

        <div class="nl-stat bg-[#183C2F] text-white flex flex-col justify-between gap-6">
            <span class="nl-label text-white/60">
                Saldo kas tersedia
            </span>

            <div>
                <p class="nl-number">
                    Rp {{ number_format($saldoKas, 0, ',', '.') }}
                </p>

                <p class="text-[11px] text-white/60 mt-2">
                    Pemasukan − pengeluaran
                </p>
            </div>
        </div>

        <div class="nl-stat nl-soft flex flex-col justify-between gap-6">
            <span class="nl-label text-[#728176]">
                Total pemasukan
            </span>

            <div>
                <p class="nl-number">
                    Rp {{ number_format($pemasukan, 0, ',', '.') }}
                </p>

                <p class="text-[11px] text-[#63796A] mt-2">
                    <i class="ph ph-arrow-up-right"></i>
                    Akumulasi transaksi masuk
                </p>
            </div>
        </div>

        <div class="nl-stat nl-soft flex flex-col justify-between gap-6">
            <span class="nl-label text-[#728176]">
                Total pengeluaran
            </span>

            <div>
                <p class="nl-number">
                    Rp {{ number_format($pengeluaran, 0, ',', '.') }}
                </p>

                <p class="text-[11px] text-[#63796A] mt-2">
                    <i class="ph ph-arrow-down-right"></i>
                    Akumulasi transaksi keluar
                </p>
            </div>
        </div>

        <div class="nl-stat nl-soft flex flex-col justify-between gap-6">
            <span class="nl-label text-[#728176]">
                Persentase kas tersisa
            </span>

            <div>
                <p class="nl-number">
                    {{ number_format($persenKasTersisa, 1, ',', '.') }}%
                </p>

                <div class="h-2 rounded-full bg-[#DFE7DD] overflow-hidden mt-3">
                    <div
                        class="h-full bg-[#183C2F] rounded-full"
                        style="width: {{ min(100, $persenKasTersisa) }}%"
                    ></div>
                </div>

                <p class="text-[11px] text-[#63796A] mt-2">
                    Saldo dibanding seluruh pemasukan, bukan target donasi
                </p>
            </div>
        </div>
    </div>

    <!-- GRAFIK UTAMA ALA FINANCE -->
    <section class="nl-chart-card">

        <div class="flex flex-col lg:flex-row lg:items-start lg:justify-between gap-5">
            <div>
                <p class="text-[11px] uppercase tracking-[.18em] font-extrabold text-[#A2B6A9]">
                    Cash Flow / Balance
                </p>

                <h3 class="text-xl sm:text-2xl font-black tracking-tight mt-2">
                    Pergerakan Saldo Kas
                </h3>

                <div class="flex items-center gap-3 mt-3 flex-wrap">
                    <span
                        id="nl-period-end"
                        class="text-2xl font-black tracking-[-.04em]"
                        aria-live="polite"
                    >
                        Rp {{ number_format($saldoKas, 0, ',', '.') }}
                    </span>

                    <span
                        id="nl-income-growth"
                        class="nl-pill bg-white/10 text-white/80"
                    >
                        Menghitung...
                    </span>
                </div>

                <p class="text-xs text-white/55 mt-2">
                    Persentase membandingkan pemasukan dengan periode sebelumnya
                </p>
            </div>

            <!-- FILTER GRAFIK -->
            <div
                class="flex flex-wrap gap-2 nl-no-print"
                aria-label="Rentang waktu grafik"
            >
                <button class="nl-period" type="button" data-days="7" aria-pressed="false">
                    7H
                </button>

                <button class="nl-period" type="button" data-days="30" aria-pressed="true">
                    30H
                </button>

                <button class="nl-period" type="button" data-days="90" aria-pressed="false">
                    90H
                </button>

                <button class="nl-period" type="button" data-days="365" aria-pressed="false">
                    1T
                </button>
            </div>
        </div>

        <div class="nl-chart-wrap mt-7">
            <canvas
                id="nl-balance-chart"
                role="img"
                aria-label="Grafik perubahan saldo kas per hari"
            ></canvas>
        </div>

        <p
            id="nl-chart-note"
            class="text-[11px] text-white/55 mt-2"
            aria-live="polite"
        >
            Mengambil data transaksi...
        </p>
    </section>

    <!-- GRAFIK BULANAN DAN FORM TRANSAKSI -->
    <div class="grid grid-cols-1 xl:grid-cols-[1.05fr_.95fr] gap-4 sm:gap-6">

        <!-- GRAFIK PEMASUKAN / PENGELUARAN -->
        <section class="bg-white rounded-[24px] border border-[#E3E9E1] p-5 sm:p-7 shadow-sm">
            <div class="flex items-start justify-between gap-3 mb-5">
                <div>
                    <p class="text-[11px] tracking-[.15em] uppercase font-bold text-[#829084]">
                        Monthly Activity
                    </p>

                    <h3 class="text-lg font-black mt-1">
                        Aktivitas 6 Bulan Terakhir
                    </h3>
                </div>

                <div class="text-[10px] font-bold text-[#6D7C70] text-right space-y-1">
                    <p>
                        <span class="inline-block w-2 h-2 bg-[#183C2F] rounded-sm mr-1"></span>
                        Masuk
                    </p>

                    <p>
                        <span class="inline-block w-2 h-2 bg-[#CBA86C] rounded-sm mr-1"></span>
                        Keluar
                    </p>
                </div>
            </div>

            <div class="nl-flow-chart-wrap">
                <canvas
                    id="nl-month-chart"
                    role="img"
                    aria-label="Grafik batang pemasukan dan pengeluaran enam bulan terakhir"
                ></canvas>
            </div>
        </section>

        <!-- FORM CATAT TRANSAKSI -->
        <section class="bg-white rounded-[24px] border border-[#E3E9E1] p-5 sm:p-7 shadow-sm">

            <div class="mb-5">
                <p class="text-[11px] tracking-[.15em] uppercase font-bold text-[#829084]">
                    New Transaction
                </p>

                <h3 class="text-lg font-black mt-1">
                    Catat Transaksi Kas
                </h3>
            </div>

            <form
                action="{{ route('admin.infaq.store') }}"
                method="POST"
                class="space-y-4"
            >
                @csrf

                <div>
                    <label
                        for="nl-amount"
                        class="block text-xs font-bold mb-1.5"
                    >
                        Nominal (Rp)
                    </label>

                    <input
                        id="nl-amount"
                        type="number"
                        name="amount"
                        required
                        min="1"
                        step="1"
                        value="{{ old('amount') }}"
                        placeholder="Contoh: 50000"
                        class="nl-input"
                    >
                </div>

                <div>
                    <label
                        for="nl-type"
                        class="block text-xs font-bold mb-1.5"
                    >
                        Jenis transaksi
                    </label>

                    <select
                        id="nl-type"
                        name="type"
                        required
                        class="nl-input"
                    >
                        <option
                            value="masuk"
                            @selected(old('type', 'masuk') === 'masuk')
                        >
                            Infaq Masuk (+)
                        </option>

                        <option
                            value="keluar"
                            @selected(old('type') === 'keluar')
                        >
                            Pengeluaran Kas (-)
                        </option>
                    </select>
                </div>

                <div>
                    <label
                        for="nl-description"
                        class="block text-xs font-bold mb-1.5"
                    >
                        Keterangan / sumber
                    </label>

                    <input
                        id="nl-description"
                        type="text"
                        name="description"
                        maxlength="255"
                        required
                        value="{{ old('description') }}"
                        placeholder="Contoh: Infaq Majelis / Konsumsi Kegiatan"
                        class="nl-input"
                    >
                </div>

                <button
                    type="submit"
                    class="w-full flex items-center justify-center gap-2 bg-[#183C2F] hover:bg-[#275442] text-white rounded-xl px-5 py-3.5 text-xs font-extrabold transition"
                >
                    <i class="ph ph-plus-circle text-base"></i>
                    Simpan Transaksi
                </button>

                <p class="text-[11px] nl-muted leading-5">
                    Hanya catat pemasukan yang benar-benar sudah diterima.
                    Konfirmasi QRIS anggota belum terhubung pada tahap ini.
                </p>
            </form>
        </section>
    </div>

    <!-- RIWAYAT TRANSAKSI -->
    <section class="bg-white rounded-[24px] border border-[#E3E9E1] p-5 sm:p-7 shadow-sm">

        <div class="flex items-end justify-between gap-3 mb-4">
            <div>
                <p class="text-[11px] tracking-[.15em] uppercase font-bold text-[#829084]">
                    Transaction History
                </p>

                <h3 class="text-lg font-black mt-1">
                    Riwayat Transaksi
                </h3>
            </div>

            <span class="text-[11px] font-bold text-[#738376]">
                {{ $infaqTransactions->count() }} catatan
            </span>
        </div>

        @forelse ($infaqTransactions as $t)
            <div class="nl-transaction">

                <div class="flex items-center gap-3 min-w-0">
                    <div
                        class="w-10 h-10 shrink-0 rounded-xl flex items-center justify-center {{ $t->type === 'masuk' ? 'bg-[#E6F0E6] text-[#183C2F]' : 'bg-[#F8EDDE] text-[#986D31]' }}"
                    >
                        <i class="ph {{ $t->type === 'masuk' ? 'ph-arrow-down-left' : 'ph-arrow-up-right' }} text-lg"></i>
                    </div>

                    <div class="min-w-0">
                        <p class="text-xs sm:text-sm font-extrabold break-words">
                            {{ $t->description }}
                        </p>

                        <p class="text-[11px] nl-muted mt-1">
                            {{ $t->created_at?->format('d M Y · H:i') }}
                        </p>
                    </div>
                </div>

                <div class="shrink-0 text-right pl-2">
                    <p
                        class="text-xs sm:text-sm font-black {{ $t->type === 'masuk' ? 'text-[#183C2F]' : 'text-[#996F39]' }}"
                    >
                        {{ $t->type === 'masuk' ? '+' : '−' }}
                        Rp {{ number_format((float) $t->amount, 0, ',', '.') }}
                    </p>

                    <form
                        action="{{ route('admin.infaq.destroy', $t->id) }}"
                        method="POST"
                        class="mt-1 nl-no-print"
                        onsubmit="return confirm('Yakin hapus catatan transaksi ini?')"
                    >
                        @csrf
                        @method('DELETE')

                        <button
                            type="submit"
                            class="text-[11px] font-bold text-red-600 hover:underline"
                        >
                            Hapus
                        </button>
                    </form>
                </div>
            </div>

        @empty
            <div class="py-14 text-center">
                <i class="ph ph-chart-line-down text-3xl text-[#90A093]"></i>

                <p class="font-bold mt-3">
                    Belum ada transaksi kas
                </p>

                <p class="text-sm nl-muted mt-1">
                    Grafik akan terisi setelah admin mencatat transaksi.
                </p>
            </div>
        @endforelse
    </section>
</div>

<!-- CHART.JS -->
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.8/dist/chart.umd.min.js"></script>

<script>
(function () {
    'use strict';

    const transactions = {{ \Illuminate\Support\Js::from($chartTransactions) }};
    const todayIso = {{ \Illuminate\Support\Js::from(now()->format('Y-m-d')) }};

    const money = amount =>
        'Rp ' + Math.round(amount).toLocaleString('id-ID');

    const parseDay = iso => {
        const parts = String(iso).split('-').map(Number);

        return new Date(
            parts[0],
            parts[1] - 1,
            parts[2],
            12,
            0,
            0
        );
    };

    const dayIso = date => [
        date.getFullYear(),
        String(date.getMonth() + 1).padStart(2, '0'),
        String(date.getDate()).padStart(2, '0')
    ].join('-');

    const addDays = (date, number) => {
        const next = new Date(date);
        next.setDate(next.getDate() + number);
        return next;
    };

    const today = parseDay(todayIso);

    const usable = transactions.filter(t =>
        t.date &&
        (t.type === 'masuk' || t.type === 'keluar') &&
        Number.isFinite(Number(t.amount))
    );

    // Kelompokkan transaksi berdasarkan tanggal.
    const daily = new Map();

    for (const entry of usable) {
        if (!daily.has(entry.date)) {
            daily.set(entry.date, {
                masuk: 0,
                keluar: 0
            });
        }

        daily.get(entry.date)[entry.type] += Number(entry.amount);
    }

    // Penanganan jika library gagal dimuat.
    if (typeof Chart === 'undefined') {
        document.getElementById('nl-chart-note').textContent =
            'Grafik tidak dapat dimuat. Periksa koneksi internet atau CDN Chart.js.';

        return;
    }

    Chart.defaults.font.family =
        "'DM Sans', system-ui, sans-serif";

    Chart.defaults.font.size = 11;

    const mainCanvas =
        document.getElementById('nl-balance-chart');

    const monthlyCanvas =
        document.getElementById('nl-month-chart');

    if (!mainCanvas || !monthlyCanvas) {
        return;
    }

    // Gradien grafik hijau.
    const ctx = mainCanvas.getContext('2d');

    const gradient = ctx.createLinearGradient(
        0,
        0,
        0,
        310
    );

    gradient.addColorStop(
        0,
        'rgba(157,224,177,.32)'
    );

    gradient.addColorStop(
        1,
        'rgba(157,224,177,0)'
    );

    // Grafik saldo utama.
    const main = new Chart(ctx, {
        type: 'line',

        data: {
            labels: [],

            datasets: [{
                label: 'Saldo kas',
                data: [],
                borderColor: '#A1E3B3',
                backgroundColor: gradient,
                borderWidth: 2.7,
                fill: true,
                tension: .33,
                pointRadius: 0,
                pointHoverRadius: 5,
                pointHoverBackgroundColor: '#D7FFE2',
                pointHoverBorderColor: '#183C2F',
                pointHoverBorderWidth: 2
            }]
        },

        options: {
            maintainAspectRatio: false,
            responsive: true,

            animation: {
                duration: 450
            },

            interaction: {
                intersect: false,
                mode: 'index'
            },

            plugins: {
                legend: {
                    display: false
                },

                tooltip: {
                    displayColors: false,
                    backgroundColor: '#F5F4F0',
                    titleColor: '#4C6454',
                    bodyColor: '#183C2F',
                    padding: 12,

                    callbacks: {
                        label: context =>
                            'Saldo: ' + money(context.parsed.y)
                    }
                }
            },

            scales: {
                x: {
                    border: {
                        display: false
                    },

                    grid: {
                        display: false
                    },

                    ticks: {
                        color: '#97ACA0',
                        maxTicksLimit: 6,
                        maxRotation: 0
                    }
                },

                y: {
                    border: {
                        display: false,
                        dash: [4, 4]
                    },

                    grid: {
                        color: 'rgba(191,215,194,.12)'
                    },

                    ticks: {
                        color: '#97ACA0',
                        maxTicksLimit: 5,

                        callback: value =>
                            'Rp ' + Intl.NumberFormat(
                                'id-ID',
                                {
                                    notation: 'compact',
                                    maximumFractionDigits: 1
                                }
                            ).format(value)
                    }
                }
            }
        }
    });

    const fmtDay = iso =>
        parseDay(iso).toLocaleDateString('id-ID', {
            day: 'numeric',
            month: 'short'
        });

    // Filter 7 hari / 30 hari / 90 hari / 1 tahun.
    function updatePeriod(days) {

        document.querySelectorAll('.nl-period').forEach(
            button => button.setAttribute(
                'aria-pressed',
                String(Number(button.dataset.days) === days)
            )
        );

        const from = addDays(today, 1 - days);

        let balance = 0;
        let periodIncome = 0;
        let priorIncome = 0;

        // Saldo sebelum tanggal awal periode.
        for (const transaction of usable) {
            const date = parseDay(transaction.date);
            const amount = Number(transaction.amount);

            if (date < from) {
                balance += (
                    transaction.type === 'masuk' ? 1 : -1
                ) * amount;
            }

            if (
                date >= from &&
                date <= today &&
                transaction.type === 'masuk'
            ) {
                periodIncome += amount;
            }

            if (
                date >= addDays(from, -days) &&
                date < from &&
                transaction.type === 'masuk'
            ) {
                priorIncome += amount;
            }
        }

        const labels = [];
        const values = [];

        let hasPeriodTransactions = false;

        // Hitung saldo setiap hari.
        for (let i = 0; i < days; i++) {
            const iso = dayIso(addDays(from, i));

            const amounts = daily.get(iso) || {
                masuk: 0,
                keluar: 0
            };

            if (amounts.masuk || amounts.keluar) {
                hasPeriodTransactions = true;
            }

            balance += amounts.masuk - amounts.keluar;

            labels.push(fmtDay(iso));
            values.push(balance);
        }

        main.data.labels = labels;
        main.data.datasets[0].data = values;

        main.update();

        document.getElementById(
            'nl-period-end'
        ).textContent = money(balance);

        // Persentase perubahan pemasukan.
        const growth = document.getElementById(
            'nl-income-growth'
        );

        if (priorIncome > 0) {
            const percent = (
                (periodIncome - priorIncome) /
                priorIncome
            ) * 100;

            growth.textContent =
                (percent > 0 ? '+' : '') +
                percent.toLocaleString('id-ID', {
                    maximumFractionDigits: 1
                }) +
                '% pemasukan';

            growth.style.backgroundColor =
                percent >= 0
                    ? 'rgba(161,227,179,.14)'
                    : 'rgba(248,177,163,.13)';

            growth.style.color =
                percent >= 0
                    ? '#B7EDC4'
                    : '#FFC8BE';

        } else {
            growth.textContent = 'Belum ada pembanding';

            growth.style.backgroundColor =
                'rgba(255,255,255,.10)';

            growth.style.color = '#E6EDE6';
        }

        document.getElementById(
            'nl-chart-note'
        ).textContent = hasPeriodTransactions
            ? 'Saldo harian berdasarkan seluruh catatan masuk dan keluar.'
            : 'Belum ada transaksi pada periode ini. Garis datar menunjukkan saldo yang belum berubah.';
    }

    // Aktifkan tombol filter waktu.
    document.querySelectorAll('.nl-period').forEach(
        button => button.addEventListener(
            'click',
            () => updatePeriod(Number(button.dataset.days))
        )
    );

    updatePeriod(30);

    // Grafik batang aktivitas enam bulan.
    const monthStarts = [];

    const beginning = new Date(
        today.getFullYear(),
        today.getMonth() - 5,
        1,
        12
    );

    for (let i = 0; i < 6; i++) {
        monthStarts.push(
            new Date(
                beginning.getFullYear(),
                beginning.getMonth() + i,
                1,
                12
            )
        );
    }

    const months = monthStarts.map(date => {
        const key =
            `${date.getFullYear()}-${String(
                date.getMonth() + 1
            ).padStart(2, '0')}`;

        let masuk = 0;
        let keluar = 0;

        for (const transaction of usable) {
            if (transaction.date.startsWith(key)) {
                if (transaction.type === 'masuk') {
                    masuk += Number(transaction.amount);
                } else {
                    keluar += Number(transaction.amount);
                }
            }
        }

        return {
            label: date.toLocaleDateString('id-ID', {
                month: 'short',
                year: '2-digit'
            }),
            masuk,
            keluar
        };
    });

    new Chart(monthlyCanvas, {
        type: 'bar',

        data: {
            labels: months.map(month => month.label),

            datasets: [
                {
                    label: 'Pemasukan',
                    data: months.map(month => month.masuk),
                    backgroundColor: '#183C2F',
                    borderRadius: 5,
                    maxBarThickness: 22
                },
                {
                    label: 'Pengeluaran',
                    data: months.map(month => month.keluar),
                    backgroundColor: '#CBA86C',
                    borderRadius: 5,
                    maxBarThickness: 22
                }
            ]
        },

        options: {
            responsive: true,
            maintainAspectRatio: false,

            plugins: {
                legend: {
                    display: false
                },

                tooltip: {
                    callbacks: {
                        label: context =>
                            context.dataset.label +
                            ': ' +
                            money(context.parsed.y)
                    }
                }
            },

            scales: {
                x: {
                    grid: {
                        display: false
                    },

                    border: {
                        display: false
                    },

                    ticks: {
                        color: '#697C6E'
                    }
                },

                y: {
                    beginAtZero: true,

                    border: {
                        display: false
                    },

                    grid: {
                        color: '#EEF1EC'
                    },

                    ticks: {
                        color: '#697C6E',
                        maxTicksLimit: 5,

                        callback: value =>
                            'Rp ' + Intl.NumberFormat(
                                'id-ID',
                                {
                                    notation: 'compact',
                                    maximumFractionDigits: 1
                                }
                            ).format(value)
                    }
                }
            }
        }
    });

})();
</script>

@endsection
