<x-app-layout>
    <x-slot name="header">
        <h2 class="font-bold text-xl text-gray-800 leading-tight">
            Panel Admin - Kelola Berita & Rundown Kegiatan
        </h2>
    </x-slot>

    <div class="py-12 bg-gray-100 min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-8">
            
            <!-- NOTIFIKASI -->
            @if(session('success'))
                <div class="bg-green-900 text-white px-6 py-4 rounded-2xl font-bold shadow flex items-center justify-between text-xs">
                    <span><i class="ph ph-check-circle text-base align-middle mr-2"></i> {{ session('success') }}</span>
                    <button onclick="this.parentElement.remove()" class="text-white/80">✕</button>
                </div>
            @endif

            @if ($errors->any())
                <div class="bg-red-600 text-white px-6 py-4 rounded-2xl font-bold shadow text-xs">
                    <ul class="list-disc pl-4">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <!-- FORM INPUT BERITA & RUNDOWN -->
            <div class="bg-white rounded-3xl p-8 shadow-xl border border-gray-100">
                <h3 class="text-lg font-black text-gray-900 mb-6 flex items-center gap-2">
                    <i class="ph ph-note-pencil text-green-800 text-xl"></i> Tambah Berita & Rundown Baru
                </h3>

                <form action="{{ route('admin.news.store') }}" method="POST" enctype="multipart/form-data" class="space-y-5">
                    @csrf
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                        <div>
                            <label class="block text-xs font-bold text-gray-700 uppercase mb-2">Judul Berita / Agenda</label>
                            <input type="text" name="title" required placeholder="Contoh: Pengajian Akbar Lailatul Ijtima" class="w-full bg-gray-50 border border-gray-200 rounded-xl px-4 py-3 text-xs font-semibold outline-none focus:ring-2 focus:ring-green-600">
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-gray-700 uppercase mb-2">Tanggal Pelaksanaan / Agenda</label>
                            <input type="date" name="event_date" class="w-full bg-gray-50 border border-gray-200 rounded-xl px-4 py-3 text-xs font-semibold outline-none focus:ring-2 focus:ring-green-600">
                        </div>
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-gray-700 uppercase mb-2">Isi Konten Berita</label>
                        <textarea name="content" rows="4" required placeholder="Tuliskan deskripsi lengkap berita atau kegiatan..." class="w-full bg-gray-50 border border-gray-200 rounded-xl px-4 py-3 text-xs font-semibold outline-none focus:ring-2 focus:ring-green-600"></textarea>
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-gray-700 uppercase mb-2">Rundown Acara (Susunan Waktu & Acara)</label>
                        <textarea name="rundown" rows="5" placeholder="19.30 - Pembukaan oleh MC&#10;20.00 - Pembacaan Tahlil & Doa&#10;21.00 - Mauidhoh Hasanah" class="w-full bg-stone-900 text-lime-400 font-mono border border-gray-200 rounded-xl px-4 py-3 text-xs outline-none focus:ring-2 focus:ring-green-600"></textarea>
                        <p class="text-[10px] text-gray-400 mt-1">Gunakan Enter untuk memisahkan setiap baris rundown.</p>
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-gray-700 uppercase mb-2">Foto Sampul / Banner Berita</label>
                        <input type="file" name="image" class="w-full text-xs text-gray-500 file:mr-4 file:py-2.5 file:px-4 file:rounded-xl file:border-0 file:text-xs file:font-bold file:bg-green-50 file:text-green-800 hover:file:bg-green-100">
                    </div>

                    <button type="submit" class="w-full bg-gray-900 hover:bg-green-800 text-white font-black py-4 rounded-xl transition text-xs shadow-lg">
                        Publikasikan Berita & Rundown ke Website Publik
                    </button>
                </form>
            </div>

            <!-- TABEL DAFTAR BERITA -->
            <div class="bg-white rounded-3xl p-8 shadow-xl border border-gray-100">
                <h3 class="text-lg font-black text-gray-900 mb-6">Daftar Berita & Rundown Terpublikasi</h3>
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200 text-xs">
                        <thead class="bg-gray-50 text-gray-500 uppercase tracking-wider">
                            <tr>
                                <th class="px-6 py-3 text-left">Judul</th>
                                <th class="px-6 py-3 text-left">Tanggal</th>
                                <th class="px-6 py-3 text-left">Rundown</th>
                                <th class="px-6 py-3 text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200 text-gray-700">
                            @forelse($newsList ?? [] as $news)
                                <tr>
                                    <td class="px-6 py-4 font-bold text-gray-900">{{ $news->title }}</td>
                                    <td class="px-6 py-4">{{ $news->event_date ? \Carbon\Carbon::parse($news->event_date)->translatedFormat('d M Y') : '-' }}</td>
                                    <td class="px-6 py-4">
                                        @if($news->rundown)
                                            <span class="bg-green-100 text-green-800 text-[10px] font-bold px-2.5 py-1 rounded-full">Ada Rundown</span>
                                        @else
                                            <span class="bg-gray-100 text-gray-500 text-[10px] font-bold px-2.5 py-1 rounded-full">Tidak Ada</span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 text-center">
                                        <form action="{{ route('admin.news.destroy', $news->id) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus berita ini?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-red-600 bg-red-50 hover:bg-red-100 font-bold px-3 py-1.5 rounded-lg transition">Hapus</button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="px-6 py-8 text-center text-gray-400">Belum ada berita yang diposting.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>