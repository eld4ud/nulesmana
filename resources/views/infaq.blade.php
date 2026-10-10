<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Transparansi Kas Infaq - NU Pasiraman Lor</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;600;700;800;900&display=swap" rel="stylesheet">
    <script src="https://unpkg.com/@phosphor-icons/web"></script>
    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; background-color: #f4f7f6; }
    </style>
</head>
<body class="text-gray-900 min-h-screen flex flex-col">

    <!-- HEADER / NAVBAR -->
    <header class="bg-white border-b border-gray-100 sticky top-0 z-50">
        <div class="max-w-6xl mx-auto px-6 h-20 flex justify-between items-center">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 bg-green-800 rounded-full flex items-center justify-center text-white font-bold">
                    <i class="ph ph-globe-hemisphere-west text-2xl"></i>
                </div>
                <div>
                    <h1 class="font-extrabold text-lg text-gray-900 leading-tight">Transparansi Kas Infaq</h1>
                    <p class="text-xs text-gray-400">Ranting NU Pasiraman Lor</p>
                </div>
            </div>

            <a href="{{ route('dashboard') }}" class="bg-gray-100 hover:bg-gray-200 text-gray-800 text-xs font-bold px-5 py-2.5 rounded-full transition flex items-center gap-2">
                <i class="ph ph-arrow-left text-base"></i> Kembali ke Dashboard
            </a>
        </div>
    </header>

    <!-- CONTENT CONTAINER -->
    <main class="max-w-6xl mx-auto w-full px-6 py-10 flex-1">
        
        <!-- TOP SUMMARY CARDS -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-10">
            <!-- Total Saldo -->
            <div class="bg-green-900 text-white rounded-3xl p-8 shadow-xl relative overflow-hidden flex flex-col justify-between h-48">
                <div class="flex justify-between items-center z-10">
                    <span class="text-xs font-bold uppercase tracking-wider text-green-200">Total Saldo Kas Current</span>
                    <span class="w-8 h-8 rounded-full bg-white/20 flex items-center justify-center"><i class="ph ph-wallet text-lg"></i></span>
                </div>
                <div class="z-10">
                    <h2 class="text-4xl font-black mb-1">Rp {{ number_format($totalInfaq ?? 0, 0, ',', '.') }}</h2>
                    <p class="text-xs text-green-100"><i class="ph ph-shield-check"></i> Audit Transparan & Real-time</p>
                </div>
            </div>

            <!-- Infaq Masuk -->
            <div class="bg-white rounded-3xl p-8 border border-gray-100 shadow-sm flex flex-col justify-between h-48">
                <div class="flex justify-between items-center">
                    <span class="text-xs font-bold uppercase tracking-wider text-gray-400">Pemasukan Kas</span>
                    <span class="w-8 h-8 rounded-full bg-green-50 text-green-600 flex items-center justify-center"><i class="ph ph-arrow-down-left text-lg"></i></span>
                </div>
                <div>
                    <h2 class="text-3xl font-extrabold text-green-600 mb-1">Rp {{ number_format($infaqMasuk ?? 0, 0, ',', '.') }}</h2>
                    <p class="text-xs text-gray-400">Total akumulasi dana infaq masuk</p>
                </div>
            </div>

            <!-- Infaq Keluar / Penyaluran -->
            <div class="bg-white rounded-3xl p-8 border border-gray-100 shadow-sm flex flex-col justify-between h-48">
                <div class="flex justify-between items-center">
                    <span class="text-xs font-bold uppercase tracking-wider text-gray-400">Penyaluran / Pengeluaran</span>
                    <span class="w-8 h-8 rounded-full bg-orange-50 text-orange-600 flex items-center justify-center"><i class="ph ph-arrow-up-right text-lg"></i></span>
                </div>
                <div>
                    <h2 class="text-3xl font-extrabold text-orange-600 mb-1">Rp {{ number_format($infaqKeluar ?? 0, 0, ',', '.') }}</h2>
                    <p class="text-xs text-gray-400">Digunakan untuk kegiatan & sosial ranting</p>
                </div>
            </div>
        </div>

        <!-- MAIN GRID: TABLE REKAP & INFO PENYALURAN -->
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-8">
            
            <!-- LIST TRANSAKSI INFAQ -->
            <div class="lg:col-span-8 bg-white rounded-3xl p-8 border border-gray-100 shadow-sm">
                <div class="flex justify-between items-center mb-6">
                    <div>
                        <h3 class="text-xl font-extrabold text-gray-900">Riwayat Transaksi Kas</h3>
                        <p class="text-xs text-gray-400 font-medium mt-1">*Nama donatur/pemberi infaq disamarkan sebagai "Hamba Allah" untuk menjaga niat ikhlas.</p>
                    </div>
                </div>

                <div class="space-y-3">
                    @forelse($infaqTransactions ?? [] as $transaction)
                        <div class="flex items-center justify-between p-4 bg-gray-50 rounded-2xl hover:bg-gray-100/80 transition">
                            <div class="flex items-center gap-4">
                                <div class="w-10 h-10 rounded-xl flex items-center justify-center font-bold {{ $transaction->type == 'masuk' ? 'bg-green-100 text-green-700' : 'bg-orange-100 text-orange-700' }}">
                                    <i class="ph {{ $transaction->type == 'masuk' ? 'ph-arrow-down-left' : 'ph-arrow-up-right' }} text-xl"></i>
                                </div>
                                <div>
                                    <p class="font-bold text-sm text-gray-900">
                                        {{ $transaction->type == 'masuk' ? 'Hamba Allah' : ($transaction->description ?? 'Pengeluaran Kas') }}
                                    </p>
                                    <p class="text-xs text-gray-400">
                                        {{ $transaction->created_at ? $transaction->created_at->translatedFormat('d F Y • H:i') : '-' }}
                                    </p>
                                </div>
                            </div>
                            <div class="text-right">
                                <p class="font-extrabold text-base {{ $transaction->type == 'masuk' ? 'text-green-600' : 'text-orange-600' }}">
                                    {{ $transaction->type == 'masuk' ? '+' : '-' }} Rp {{ number_format($transaction->amount, 0, ',', '.') }}
                                </p>
                                <span class="text-[10px] uppercase font-bold tracking-wider px-2 py-0.5 rounded {{ $transaction->type == 'masuk' ? 'bg-green-50 text-green-700' : 'bg-orange-50 text-orange-700' }}">
                                    {{ $transaction->type }}
                                </span>
                            </div>
                        </div>
                    @empty
                        <div class="text-center py-16 text-gray-400">
                            <i class="ph ph-receipt text-5xl mb-2 inline-block"></i>
                            <p class="text-sm italic">Belum ada transaksi infaq yang dicatat.</p>
                        </div>
                    @endforelse
                </div>
            </div>

            <!-- SIDEBAR INFO INFAQ & SALURKAN -->
            <div class="lg:col-span-4 space-y-6">
                <!-- Card Salurkan Infaq -->
                <div class="bg-gradient-to-br from-green-900 via-green-800 to-black text-white rounded-3xl p-8 shadow-xl relative overflow-hidden">
                    <h3 class="text-xl font-black mb-2">Ingin Berinfaq?</h3>
                    <p class="text-xs text-green-200 leading-relaxed mb-6">
                        Salurkan infaq terbaik Anda untuk pembangunan fasilitas majelis, kegiatan rutin santri, dan santunan anak yatim Ranting NU Pasiraman Lor.
                    </p>

                    <div class="bg-white/10 backdrop-blur-md rounded-2xl p-4 mb-4 border border-white/10">
                        <p class="text-[10px] text-green-300 font-bold uppercase tracking-wider mb-1">Rekening Kas NU</p>
                        <p class="text-lg font-black tracking-wide">1234-5678-9012</p>
                        <p class="text-xs text-gray-300 mt-1">Bank BSI a.n PRNU Pasiraman Lor</p>
                    </div>

                    <div class="text-center">
                        <p class="text-xs font-semibold text-green-200">Konfirmasi Infaq via WA Bendahara:</p>
                        <a href="https://wa.me/6281234567890" target="_blank" class="inline-flex items-center gap-2 mt-3 bg-white text-green-900 font-extrabold px-6 py-3 rounded-full text-xs hover:bg-gray-100 transition shadow-lg">
                            <i class="ph ph-whatsapp-logo text-lg"></i> Konfirmasi Infaq
                        </a>
                    </div>
                </div>

                <!-- Card Catatan Amanah -->
                <div class="bg-white rounded-3xl p-6 border border-gray-100 shadow-sm">
                    <h4 class="font-bold text-sm text-gray-900 mb-2 flex items-center gap-2">
                        <i class="ph ph-info text-green-700 text-lg"></i> Transparansi Publik
                    </h4>
                    <p class="text-xs text-gray-500 leading-relaxed">
                        Seluruh pengeluaran dana infaq selalu melewati rapat pengurus harian dan dipertanggungjawabkan pada Lailatul Ijtima' rutin setiap bulannya.
                    </p>
                </div>
            </div>

        </div>

    </main>

</body>
</html>