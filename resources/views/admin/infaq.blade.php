<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kelola Kas Infaq - Admin NU Pasiraman Lor</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;600;700;800;900&display=swap" rel="stylesheet">
    <script src="https://unpkg.com/@phosphor-icons/web"></script>
    <style> body { font-family: 'Plus Jakarta Sans', sans-serif; background-color: #f4f7f6; } </style>
</head>
<body class="text-slate-800 h-screen overflow-hidden flex font-sans p-4 gap-4">

    <aside class="w-[260px] bg-white rounded-3xl flex flex-col justify-between py-6 shadow-sm hidden md:flex">
        <div>
            <div class="px-8 flex items-center gap-3 mb-10">
                <div class="w-9 h-9 rounded-full bg-green-900 text-white flex items-center justify-center font-bold">
                    <i class="ph ph-globe-hemisphere-west text-xl"></i>
                </div>
                <div>
                    <h1 class="text-lg font-black tracking-tight text-gray-900 leading-none">NU Pasiraman</h1>
                    <span class="text-[10px] text-green-700 font-bold uppercase tracking-wider">Admin Panel</span>
                </div>
            </div>
            <div class="px-4">
                <p class="px-4 text-xs font-bold text-gray-400 mb-3 tracking-wider">MODUL UTAMA</p>
                <nav class="flex flex-col gap-1.5">
                    <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-3 px-4 py-3 text-gray-500 hover:text-green-900 hover:bg-gray-50 rounded-2xl font-bold text-sm transition">
                        <i class="ph ph-squares-four text-xl"></i> Dashboard
                    </a>
                    <a href="{{ route('admin.members.index') }}" class="flex items-center gap-3 px-4 py-3 text-gray-500 hover:text-green-900 hover:bg-gray-50 rounded-2xl font-bold text-sm transition">
                        <i class="ph ph-users-three text-xl"></i> Kelola Anggota
                    </a>
                    <a href="{{ route('admin.news.index') }}" class="flex items-center gap-3 px-4 py-3 text-gray-500 hover:text-green-900 hover:bg-gray-50 rounded-2xl font-bold text-sm transition">
                        <i class="ph ph-newspaper text-xl"></i> Kelola Berita
                    </a>
                    <a href="{{ route('admin.infaq.index') }}" class="flex items-center gap-3 px-4 py-3 bg-green-50 text-green-900 rounded-2xl relative font-bold text-sm">
                        <div class="absolute left-0 top-1/2 -translate-y-1/2 w-1.5 h-8 bg-green-900 rounded-r-full"></div>
                        <i class="ph ph-wallet text-xl"></i> Kelola Infaq / Kas
                    </a>
                </nav>
            </div>
        </div>
        <div class="px-4">
            <a href="{{ route('admin.dashboard') }}" class="w-full flex items-center justify-center gap-2 px-4 py-3 bg-gray-100 text-gray-700 rounded-2xl font-bold text-sm hover:bg-gray-200 transition">
                <i class="ph ph-arrow-left text-lg"></i> Kembali
            </a>
        </div>
    </aside>

    <main class="flex-1 flex flex-col bg-white rounded-3xl overflow-hidden shadow-sm">
        <header class="h-20 px-8 flex items-center justify-between border-b border-gray-100">
            <div>
                <h2 class="text-xl font-extrabold text-gray-900">Kelola Transparansi Kas & Infaq</h2>
                <p class="text-xs text-gray-400">Catat pemasukan kas, donasi warga, dan pengeluaran ranting</p>
            </div>
        </header>

        <div class="flex-1 overflow-y-auto p-8 space-y-8">
            @if(session('success'))
                <div class="bg-green-900 text-white px-6 py-4 rounded-2xl font-bold text-sm shadow">
                    {{ session('success') }}
                </div>
            @endif

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <div class="bg-green-900 text-white p-6 rounded-3xl shadow-xl flex flex-col justify-between h-36">
                    <span class="text-xs font-bold text-green-200 uppercase">Total Saldo Kas Current</span>
                    <h3 class="text-3xl font-black">Rp {{ number_format($totalInfaq, 0, ',', '.') }}</h3>
                </div>
                <div class="bg-gray-50 border border-gray-100 p-6 rounded-3xl flex flex-col justify-between h-36">
                    <span class="text-xs font-bold text-gray-400 uppercase">Total Pemasukan</span>
                    <h3 class="text-3xl font-black text-green-600">Rp {{ number_format($infaqMasuk, 0, ',', '.') }}</h3>
                </div>
                <div class="bg-gray-50 border border-gray-100 p-6 rounded-3xl flex flex-col justify-between h-36">
                    <span class="text-xs font-bold text-gray-400 uppercase">Total Pengeluaran</span>
                    <h3 class="text-3xl font-black text-orange-600">Rp {{ number_format($infaqKeluar, 0, ',', '.') }}</h3>
                </div>
            </div>

            <div class="bg-gray-50 border border-gray-100 rounded-3xl p-6">
                <h3 class="text-base font-extrabold text-gray-900 mb-4">+ Catat Transaksi Kas Baru</h3>
                <form action="{{ route('admin.infaq.store') }}" method="POST" class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    @csrf
                    <div>
                        <label class="block text-xs font-bold text-gray-700 uppercase mb-1">Nominal (Rp)</label>
                        <input type="number" name="amount" required placeholder="Contoh: 50000" class="w-full bg-white border border-gray-200 rounded-xl px-4 py-2.5 text-xs font-semibold">
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-gray-700 uppercase mb-1">Jenis Transaksi</label>
                        <select name="type" required class="w-full bg-white border border-gray-200 rounded-xl px-4 py-2.5 text-xs font-semibold">
                            <option value="masuk">Infaq Masuk (+)</option>
                            <option value="keluar">Pengeluaran Kas (-)</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-gray-700 uppercase mb-1">Keterangan / Sumber</label>
                        <input type="text" name="description" required placeholder="Contoh: Donasi Hamba Allah / Konsumsi Majelis" class="w-full bg-white border border-gray-200 rounded-xl px-4 py-2.5 text-xs font-semibold">
                    </div>
                    <div class="md:col-span-3 text-right">
                        <button type="submit" class="bg-gray-900 hover:bg-green-800 text-white font-bold text-xs px-6 py-3 rounded-xl transition">
                            Simpan Transaksi
                        </button>
                    </div>
                </form>
            </div>

            <div class="bg-white border border-gray-100 rounded-3xl p-6 shadow-sm">
                <h3 class="text-base font-extrabold text-gray-900 mb-4">Riwayat Transaksi Kas</h3>
                <div class="space-y-3">
                    @forelse($infaqTransactions as $t)
                        <div class="p-4 rounded-2xl flex items-center justify-between bg-gray-50 border border-gray-100">
                            <div>
                                <p class="font-bold text-sm text-gray-900">{{ $t->description }}</p>
                                <p class="text-[11px] text-gray-400">{{ $t->created_at->format('d M Y • H:i') }}</p>
                            </div>
                            <div class="flex items-center gap-4">
                                <span class="font-extrabold text-sm {{ $t->type == 'masuk' ? 'text-green-600' : 'text-orange-600' }}">
                                    {{ $t->type == 'masuk' ? '+' : '-' }} Rp {{ number_format($t->amount, 0, ',', '.') }}
                                </span>
                                <form action="{{ route('admin.infaq.destroy', $t->id) }}" method="POST" onsubmit="return confirm('Hapus riwayat transaksi ini?')">
                                    @csrf @method('DELETE')
                                    <button class="text-xs text-red-500 hover:underline font-bold">Hapus</button>
                                </form>
                            </div>
                        </div>
                    @empty
                        <p class="text-xs text-gray-400 italic text-center py-4">Belum ada catatan transaksi kas.</p>
                    @endforelse
                </div>
            </div>
        </div>
    </main>
</body>
</html>