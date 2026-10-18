@extends('layouts.admin')
@section('title', 'Kelola Berita')
@section('heading', 'Kelola Berita')
@section('subtitle', 'Buat publikasi dan kelola informasi kegiatan warga')
@section('content')
            <div class="grid grid-cols-1 items-start gap-8 lg:grid-cols-5">

                {{-- FORM --}}
                <section class="rounded-3xl border border-gray-100 bg-white p-5 shadow-sm sm:p-8 lg:col-span-2">
                    <div class="mb-7 flex items-center gap-4">
                        <div class="flex h-12 w-12 items-center justify-center rounded-2xl bg-[#eaeae8] text-2xl text-[#181818]">
                            <i class="ph ph-pencil-line"></i>
                        </div>

                        <div>
                            <h2 class="text-xl font-extrabold text-gray-900">
                                Tambah Publikasi
                            </h2>
                            <p class="mt-1 text-xs text-gray-500">
                                Isi informasi berita di bawah.
                            </p>
                        </div>
                    </div>

                    <form action="{{ route('admin.news.store') }}"
                          method="POST"
                          enctype="multipart/form-data"
                          class="space-y-5">
                        @csrf

                        <div>
                            <label for="title" class="mb-2 block text-sm font-bold text-gray-700">
                                Judul berita
                            </label>

                            <input
                                id="title"
                                type="text"
                                name="title"
                                value="{{ old('title') }}"
                                maxlength="255"
                                required
                                placeholder="Contoh: Pengajian Rutin Warga"
                                class="w-full rounded-xl border border-gray-200 bg-gray-50 px-4 py-3 text-sm text-gray-900 outline-none transition placeholder:text-gray-400 focus:border-[#292929] focus:ring-2 focus:ring-[#e5e5e2]"
                            >
                            @error('title')
                                <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="event_date" class="mb-2 block text-sm font-bold text-gray-700">
                                Tanggal kegiatan
                            </label>

                            <input
                                id="event_date"
                                type="date"
                                name="event_date"
                                value="{{ old('event_date') }}"
                                required
                                class="w-full rounded-xl border border-gray-200 bg-gray-50 px-4 py-3 text-sm text-gray-900 outline-none transition focus:border-[#292929] focus:ring-2 focus:ring-[#e5e5e2]"
                            >
                            @error('event_date')
                                <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="content" class="mb-2 block text-sm font-bold text-gray-700">
                                Isi berita
                            </label>

                            <textarea
                                id="content"
                                name="content"
                                rows="8"
                                required
                                placeholder="Tuliskan informasi kegiatan, waktu, tempat, dan isi berita secara lengkap..."
                                class="w-full resize-y rounded-xl border border-gray-200 bg-gray-50 px-4 py-3 text-sm leading-6 text-gray-900 outline-none transition placeholder:text-gray-400 focus:border-[#292929] focus:ring-2 focus:ring-[#e5e5e2]"
                            >{{ old('content') }}</textarea>
                            @error('content')
                                <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="image" class="mb-2 block text-sm font-bold text-gray-700">
                                Foto sampul
                            </label>

                            <label for="image"
                                   class="flex cursor-pointer flex-col items-center justify-center rounded-2xl border-2 border-dashed border-[#d5d5d1] bg-[#f4f4f2]/50 px-5 py-7 text-center transition hover:bg-[#ededeb]">
                                <i class="ph ph-image text-4xl text-[#292929]"></i>
                                <span class="mt-3 text-sm font-bold text-gray-800">
                                    Pilih foto berita
                                </span>
                                <span class="mt-1 text-xs text-gray-500">
                                    JPG, JPEG, PNG, atau WEBP. Maksimal 2 MB.
                                </span>
                                <span id="imageName" class="mt-2 break-all text-xs font-semibold text-[#292929]"></span>
                            </label>

                            <input
                                id="image"
                                type="file"
                                name="image"
                                accept=".jpg,.jpeg,.png,.webp,image/jpeg,image/png,image/webp"
                                class="sr-only"
                            >
                            @error('image')
                                <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                            @enderror

                            <img id="imagePreview"
                                 alt="Pratinjau foto berita"
                                 class="mt-4 hidden max-h-56 w-full rounded-xl object-cover">
                        </div>

                        <button type="submit"
                                class="flex w-full items-center justify-center gap-2 rounded-xl bg-[#181818] px-5 py-4 text-sm font-extrabold text-white shadow-sm transition hover:bg-[#303030] focus:ring-4 focus:ring-[#e5e5e2]">
                            <i class="ph ph-paper-plane-tilt text-lg"></i>
                            Publikasikan Berita
                        </button>

                        <p class="text-center text-xs leading-5 text-gray-400">
                            Berita akan ditampilkan di website setelah berhasil disimpan.
                        </p>
                    </form>
                </section>

                {{-- DAFTAR BERITA --}}
                <section class="overflow-hidden rounded-3xl border border-gray-100 bg-white shadow-sm lg:col-span-3">

                    <div class="flex flex-col gap-3 border-b border-gray-100 p-5 sm:flex-row sm:items-center sm:justify-between sm:p-7">
                        <div>
                            <h2 class="text-xl font-extrabold text-gray-900">
                                Daftar Berita
                            </h2>
                            <p class="mt-1 text-xs text-gray-500">
                                Semua publikasi yang sudah tersimpan.
                            </p>
                        </div>

                        <span class="w-fit rounded-full bg-[#eaeae8] px-4 py-2 text-xs font-extrabold text-[#181818]">
                            {{ $publishedNews->count() }} berita
                        </span>
                    </div>

                    <div class="divide-y divide-gray-100">
                        @forelse($publishedNews as $news)
                            <article class="flex flex-col gap-4 p-5 transition hover:bg-gray-50 sm:flex-row sm:items-start sm:p-6">

                                @if($news->image)
                                    <img
                                        src="{{ \Illuminate\Support\Facades\Storage::url($news->image) }}"
                                        alt="{{ $news->title }}"
                                        class="h-28 w-full rounded-xl bg-gray-100 object-cover sm:w-32"
                                    >
                                @else
                                    <div class="flex h-28 w-full items-center justify-center rounded-xl bg-[#f4f4f2] text-4xl text-[#292929] sm:w-32">
                                        <i class="ph ph-newspaper"></i>
                                    </div>
                                @endif

                                <div class="min-w-0 flex-1">
                                    <p class="text-xs font-semibold text-[#292929]">
                                        {{ $news->event_date
                                            ? \Carbon\Carbon::parse($news->event_date)->translatedFormat('d F Y')
                                            : 'Tanggal tidak tersedia' }}
                                    </p>

                                    <h3 class="mt-2 break-words text-base font-extrabold text-gray-900">
                                        {{ $news->title }}
                                    </h3>

                                    <p class="mt-2 text-sm leading-6 text-gray-500">
                                        {{ \Illuminate\Support\Str::limit($news->content, 120) }}
                                    </p>

                                    <div class="mt-4 flex flex-wrap items-center gap-3">
                                        <a href="{{ route('public.news.show', $news->id) }}"
                                           target="_blank"
                                           class="inline-flex items-center gap-1 text-xs font-bold text-[#181818] hover:underline">
                                            Lihat berita
                                            <i class="ph ph-arrow-up-right"></i>
                                        </a>

                                        <form action="{{ route('admin.news.destroy', $news->id) }}"
                                              method="POST"
                                              onsubmit="return confirm('Yakin ingin menghapus berita ini?')">
                                            @csrf
                                            @method('DELETE')

                                            <button type="submit"
                                                    class="inline-flex items-center gap-1 rounded-lg bg-red-50 px-3 py-2 text-xs font-bold text-red-700 transition hover:bg-red-100">
                                                <i class="ph ph-trash"></i>
                                                Hapus
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </article>
                        @empty
                            <div class="px-6 py-16 text-center">
                                <i class="ph ph-newspaper text-5xl text-gray-300"></i>
                                <h3 class="mt-4 font-extrabold text-gray-800">
                                    Belum ada berita
                                </h3>
                                <p class="mt-2 text-sm text-gray-500">
                                    Berita yang kamu publikasikan akan muncul di sini.
                                </p>
                            </div>
                        @endforelse
                    </div>

                </section>
            </div>

@endsection
@push('scripts')
    <script>
        const imageInput = document.getElementById('image');
        const imageName = document.getElementById('imageName');
        const imagePreview = document.getElementById('imagePreview');

        imageInput.addEventListener('change', function () {
            const file = this.files[0];

            if (!file) {
                imageName.textContent = '';
                imagePreview.classList.add('hidden');
                imagePreview.removeAttribute('src');
                return;
            }

            imageName.textContent = file.name;

            if (!file.type.startsWith('image/')) {
                imagePreview.classList.add('hidden');
                return;
            }

            imagePreview.src = URL.createObjectURL(file);
            imagePreview.classList.remove('hidden');
        });
    </script>

@endpush
