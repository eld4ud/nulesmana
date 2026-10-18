@extends('layouts.admin')
@section('title', 'Kelola Infak / Kas')
@section('heading', 'Kelola Infak / Kas')
@section('subtitle', 'Catat pemasukan, pengeluaran, dan riwayat kas ranting')
@section('content')
<div class="space-y-6">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <div class="bg-[#181818] text-white p-6 rounded-3xl shadow-xl flex flex-col justify-between h-36">
                    <span class="text-xs font-bold text-[#ddddda] uppercase">Total Saldo Kas Current</span>
                    <h3 class="text-3xl font-black">Rp {{ number_format($totalInfaq, 0, ',', '.') }}</h3>
                </div>
                <div class="bg-gray-50 border border-gray-100 p-6 rounded-3xl flex flex-col justify-between h-36">
                    <span class="text-xs font-bold text-gray-400 uppercase">Total Pemasukan</span>
                    <h3 class="text-3xl font-black text-[#444444]">Rp {{ number_format($infaqMasuk, 0, ',', '.') }}</h3>
                </div>
                <div class="bg-gray-50 border border-gray-100 p-6 rounded-3xl flex flex-col justify-between h-36">
                    <span class="text-xs font-bold text-gray-400 uppercase">Total Pengeluaran</span>
                    <h3 class="text-3xl font-black text-[#555555]">Rp {{ number_format($infaqKeluar, 0, ',', '.') }}</h3>
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
                        <button type="submit" class="bg-gray-900 hover:bg-[#303030] text-white font-bold text-xs px-6 py-3 rounded-xl transition">
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
                                <span class="font-extrabold text-sm {{ $t->type == 'masuk' ? 'text-[#444444]' : 'text-[#555555]' }}">
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
@endsection
