@extends('layouts.admin')

@section('title', 'Edit Berita')
@section('heading', 'Edit Berita')
@section('subtitle', 'Perbarui publikasi yang sudah ada tanpa membuat berita baru')

@section('content')
<div class="mx-auto max-w-5xl space-y-6">
    <div class="flex flex-wrap items-center justify-between gap-3">
        <a href="{{ route('admin.news.index') }}"
           class="inline-flex items-center gap-2 rounded-xl border border-[#cbd7ce] bg-white px-4 py-2.5 text-sm font-semibold text-[#173d30] transition hover:bg-[#edf2ee]">
            <i class="ph ph-arrow-left"></i> Kembali ke Kelola Berita
        </a>
        <a href="{{ route('public.news.show', $news->id) }}" target="_blank" rel="noopener noreferrer"
           class="inline-flex items-center gap-2 text-sm font-semibold text-[#173d30] hover:underline">
            Lihat berita publik <i class="ph ph-arrow-up-right"></i>
        </a>
    </div>

    @if($errors->any())
        <div class="rounded-2xl border border-red-200 bg-red-50 px-5 py-4 text-sm text-red-800" role="alert">
            <p class="font-bold">Ada data yang perlu diperbaiki:</p>
            <ul class="mt-2 list-inside list-disc space-y-1">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('admin.news.update', $news->id) }}" method="POST" enctype="multipart/form-data"
          class="grid grid-cols-1 items-start gap-6 lg:grid-cols-5">
        @csrf
        @method('PUT')

        <section class="rounded-3xl border border-[#e1e7e1] bg-white p-5 shadow-sm sm:p-7 lg:col-span-3">
            <div class="mb-7 flex items-center gap-3">
                <div class="flex h-12 w-12 items-center justify-center rounded-2xl bg-[#eaf0ec] text-2xl text-[#173d30]">
                    <i class="ph ph-pencil-simple"></i>
                </div>
                <div>
                    <h2 class="text-xl font-extrabold text-[#173d30]">Ubah informasi berita</h2>
                    <p class="mt-1 text-sm text-[#617368]">Edit judul, tanggal kegiatan, atau isi publikasi.</p>
                </div>
            </div>

            <div class="space-y-5">
                <div>
                    <label for="news-edit-title" class="mb-2 block text-sm font-bold text-[#173d30]">Judul berita</label>
                    <input id="news-edit-title" name="title" type="text" maxlength="255" required
                           value="{{ old('title', $news->title) }}"
                           class="w-full rounded-xl border border-[#d9e1da] bg-[#f8faf7] px-4 py-3 text-sm text-[#173d30] outline-none focus:border-[#173d30] focus:ring-2 focus:ring-[#dce8df]">
                    @error('title')<p class="mt-1 text-xs text-red-600">{{ $message }}</p>@enderror
                </div>

                <div>
                    <label for="news-edit-date" class="mb-2 block text-sm font-bold text-[#173d30]">Tanggal kegiatan</label>
                    <input id="news-edit-date" name="event_date" type="date" required
                           max="{{ now('Asia/Jakarta')->toDateString() }}" data-nulesmana-date-limit
                           value="{{ old('event_date', $news->event_date ? \Carbon\Carbon::parse($news->event_date)->format('Y-m-d') : '') }}"
                           class="w-full rounded-xl border border-[#d9e1da] bg-[#f8faf7] px-4 py-3 text-sm text-[#173d30] outline-none focus:border-[#173d30] focus:ring-2 focus:ring-[#dce8df]">
                    <p class="mt-1 text-xs text-[#617368]">Maksimal tanggal hari ini (WIB). Tanggal besok tidak bisa dipilih.</p>
                    @error('event_date')<p class="mt-1 text-xs text-red-600">{{ $message }}</p>@enderror
                </div>

                <div>
                    <label for="news-edit-content" class="mb-2 block text-sm font-bold text-[#173d30]">Isi berita</label>
                    <textarea id="news-edit-content" name="content" rows="12" required
                              class="w-full resize-y rounded-xl border border-[#d9e1da] bg-[#f8faf7] px-4 py-3 text-sm leading-7 text-[#173d30] outline-none focus:border-[#173d30] focus:ring-2 focus:ring-[#dce8df]">{{ old('content', $news->content) }}</textarea>
                    @error('content')<p class="mt-1 text-xs text-red-600">{{ $message }}</p>@enderror
                </div>
            </div>
        </section>

        <aside class="space-y-5 lg:col-span-2">
            <section class="rounded-3xl border border-[#e1e7e1] bg-white p-5 shadow-sm sm:p-7">
                <h2 class="text-lg font-extrabold text-[#173d30]">Foto sampul</h2>
                <p class="mt-1 text-sm leading-6 text-[#617368]">Biarkan kosong untuk mempertahankan foto lama.</p>

                <div class="mt-5 overflow-hidden rounded-2xl border border-[#d9e1da] bg-[#eff3ee]">
                    <img id="news-edit-preview"
                         src="{{ $news->image ? \App\Support\NulesmanaMedia::newsUrl($news->image) : '' }}"
                         data-original="{{ $news->image ? \App\Support\NulesmanaMedia::newsUrl($news->image) : '' }}"
                         alt="Pratinjau foto sampul berita"
                         class="{{ $news->image ? '' : 'hidden ' }}aspect-video w-full object-cover">
                    <div id="news-edit-empty" class="{{ $news->image ? 'hidden ' : '' }}flex aspect-video flex-col items-center justify-center gap-2 text-[#7c9182]">
                        <i class="ph ph-image text-4xl"></i>
                        <span class="text-xs font-semibold">Belum ada foto</span>
                    </div>
                </div>

                <label for="news-edit-image" class="mt-5 block text-sm font-bold text-[#173d30]">Ganti foto (opsional)</label>
                <input id="news-edit-image" name="image" type="file"
                       accept=".jpg,.jpeg,.png,.webp,image/jpeg,image/png,image/webp"
                       class="mt-2 block w-full cursor-pointer rounded-xl border border-[#d9e1da] bg-[#f8faf7] px-3 py-3 text-xs text-[#173d30] file:mr-3 file:rounded-lg file:border-0 file:bg-[#e4ece6] file:px-3 file:py-2 file:font-bold file:text-[#173d30]">
                <p id="news-edit-image-name" class="mt-2 text-xs text-[#617368]">JPG, JPEG, PNG, atau WebP. Maksimal 2 MB.</p>
                @error('image')<p class="mt-1 text-xs text-red-600">{{ $message }}</p>@enderror

                @if($news->image)
                    <label class="mt-5 flex cursor-pointer items-start gap-3 rounded-xl bg-[#f4f6f3] p-3 text-sm text-[#43594b]">
                        <input id="news-edit-remove" type="checkbox" name="remove_image" value="1"
                               @checked(old('remove_image'))
                               class="mt-1 h-4 w-4 rounded border-[#9eb4a4] text-[#173d30]">
                        <span>Hapus foto dari berita (jika tidak mengunggah foto baru).</span>
                    </label>
                @endif
            </section>

            <section class="rounded-3xl border border-[#dce7dc] bg-[#f0f5f0] p-5 sm:p-6">
                <p class="text-sm font-semibold leading-6 text-[#526d59]">Perubahan akan langsung terlihat pada halaman publik setelah disimpan.</p>
                <button type="submit"
                        class="mt-5 flex w-full items-center justify-center gap-2 rounded-xl bg-[#173d30] px-5 py-4 text-sm font-extrabold text-white transition hover:bg-[#285844] focus:outline-none focus:ring-4 focus:ring-[#a5c1ad]">
                    <i class="ph ph-floppy-disk text-lg"></i> Simpan Perubahan
                </button>
                <a href="{{ route('admin.news.index') }}" class="mt-3 block text-center text-sm font-semibold text-[#526d59] hover:underline">Batal, kembali</a>
            </section>
        </aside>
    </form>
</div>
@endsection

@push('scripts')
<script src="{{ asset('js/nulesmana-news-date-limit.js') }}" defer></script>
<script>
(() => {
    const input = document.getElementById('news-edit-image');
    const preview = document.getElementById('news-edit-preview');
    const empty = document.getElementById('news-edit-empty');
    const label = document.getElementById('news-edit-image-name');
    const remove = document.getElementById('news-edit-remove');
    if (!input || !preview || !empty) return;
    let previewUrl = null;
    const original = preview.dataset.original || '';
    input.addEventListener('change', () => {
        if (previewUrl) URL.revokeObjectURL(previewUrl);
        previewUrl = null;
        const file = input.files && input.files[0];
        if (file && file.type.startsWith('image/')) {
            previewUrl = URL.createObjectURL(file);
            preview.src = previewUrl;
            preview.classList.remove('hidden');
            empty.classList.add('hidden');
            if (label) label.textContent = file.name;
            if (remove) remove.checked = false;
        } else {
            if (original) {
                preview.src = original;
                preview.classList.remove('hidden');
                empty.classList.add('hidden');
            } else {
                preview.removeAttribute('src');
                preview.classList.add('hidden');
                empty.classList.remove('hidden');
            }
            if (label) label.textContent = 'JPG, JPEG, PNG, atau WebP. Maksimal 2 MB.';
        }
    });
    window.addEventListener('pagehide', () => {
        if (previewUrl) URL.revokeObjectURL(previewUrl);
    });
})();
</script>
@endpush
