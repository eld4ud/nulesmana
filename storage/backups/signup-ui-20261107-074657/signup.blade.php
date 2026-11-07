@extends('layouts.member')
@section('title', 'Daftar Anggota')
@php
    $startStep = $errors->hasAny(['password', 'password_confirmation', 'banom'])
        ? 3
        : ($errors->has('address') ? 2 : 1);
    $steps = [
        1 => ['Data Pribadi', 'Nama dan kontak'],
        2 => ['Domisili', 'Alamat tinggal'],
        3 => ['Banom & Akun', 'Pilihan banom dan password'],
    ];
    $inputClass = 'w-full bg-[#F5F4F0] border border-[#D9DDD8] rounded-xl px-4 py-3 text-xs sm:text-sm font-semibold text-[#183C2F] outline-none focus:ring-2 focus:ring-[#183C2F]/30 focus:border-[#183C2F] transition';
@endphp
@section('content')
<style>
    /* Atribut hidden selalu menang dari class utilitas. */
    .nl-signup-step[hidden],
    .nl-signup-action[hidden] { display: none !important; }
    .nl-camera-dialog[hidden] { display: none !important; }
    .nl-camera-dialog { position: fixed; inset: 0; z-index: 99999; display: flex; align-items: center; justify-content: center; padding: 16px; background: rgba(10,26,17,.78); }
    .nl-camera-panel { width: min(100%, 530px); background: #F5F4F0; color: #183C2F; padding: 20px; border-radius: 16px; box-shadow: 0 25px 80px rgba(0,0,0,.22); }
    .nl-camera-video { width: 100%; max-height: 65vh; aspect-ratio: 3/4; object-fit: cover; background: #16241A; border-radius: 8px; transform: scaleX(-1); }
    .nl-camera-controls { display: flex; flex-wrap: wrap; justify-content: end; gap: 10px; margin-top: 16px; }
    @media(prefers-reduced-motion:reduce) { .nl-camera-dialog *, .nl-camera-dialog *::before { animation:none!important; transition:none!important; } }
</style>
<div class="max-w-3xl mx-auto" id="nl-signup-wizard" data-start-step="{{ $startStep }}">
    <div class="text-center mb-6 sm:mb-8">
        <span class="bg-[#183C2F] text-[#F5F4F0] text-[10px] font-black px-3 py-1.5 rounded-full uppercase tracking-wider inline-block">
            Keanggotaan
        </span>
        <h1 class="font-display text-5xl sm:text-7xl leading-[0.95] text-[#183C2F] mt-3">
            PENDAFTARAN ANGGOTA
        </h1>
        <p class="text-sm sm:text-base font-semibold text-gray-700 mt-2 max-w-xl mx-auto">
            Lengkapi data Anda. Setelah diverifikasi pengurus, NIA terbit otomatis dan bisa dipakai untuk masuk.
        </p>
    </div>
    @if (session('success'))
        <div class="bg-[#183C2F] text-white px-5 py-3.5 rounded-2xl font-bold flex items-center gap-2 mb-4 text-xs sm:text-sm" role="status">
            <i class="ph ph-check-circle text-lg"></i>
            {{ session('success') }}
        </div>
    @endif
    @if ($errors->any())
        <div class="bg-red-50 border border-red-200 text-red-800 px-5 py-3.5 rounded-2xl text-xs sm:text-sm font-bold mb-4" role="alert">
            <p class="flex items-center gap-2">
                <i class="ph ph-warning-circle text-lg"></i>
                Pendaftaran belum berhasil. Periksa kolom berikut:
            </p>
            <ul class="list-disc pl-10 mt-1 font-semibold">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
            <p class="mt-2 font-medium">Foto dan password perlu dipilih/diisi lagi setelah validasi server gagal.</p>
        </div>
    @endif
    <div class="bg-white rounded-[2rem] sm:rounded-[2.5rem] p-6 sm:p-10 shadow-xl border border-[#E5E8E2]">
        <!-- Indikator tiga tahapan: selalu tampil, walaupun JavaScript belum dimuat. -->
        <div class="flex items-start justify-between mb-8" aria-label="Tahapan pendaftaran">
            @foreach ($steps as $n => [$title, $sub])
                <div class="flex-1 flex flex-col items-center text-center relative" data-progress-step="{{ $n }}">
                    @if ($n > 1)
                        <span class="absolute top-5 right-1/2 w-full h-0.5 bg-gray-200" data-progress-line aria-hidden="true"></span>
                    @endif
                    <span class="relative z-10 w-10 h-10 rounded-full flex items-center justify-center text-sm font-black transition bg-gray-100 text-gray-400" data-progress-bubble>
                        {{ $n }}
                    </span>
                    <p class="text-[11px] sm:text-xs font-black mt-2 text-gray-400" data-progress-title>
                        {{ $title }}
                    </p>
                    <p class="hidden sm:block text-[10px] font-semibold text-gray-500">{{ $sub }}</p>
                </div>
            @endforeach
        </div>
        <form
            id="nl-signup-form"
            method="POST"
            enctype="multipart/form-data"
            action="{{ route('member.register', [], false) }}"
            autocomplete="off"
            novalidate
        >
            @csrf
            <!-- Tahap 1: Data Pribadi -->
            <div class="nl-signup-step space-y-4" data-step="1" @if($startStep !== 1) hidden @endif>
                <div>
                    <label for="name" class="block text-xs font-bold text-gray-700 uppercase mb-1">Nama Lengkap</label>
                    <input id="name" type="text" name="name" value="{{ old('name') }}" required placeholder="Sesuai KTP / KK" class="{{ $inputClass }}">
                </div>
                <div>
                    <label for="gender" class="block text-xs font-bold text-gray-700 uppercase mb-1">Jenis Kelamin</label>
                    <select id="gender" name="gender" required class="{{ $inputClass }}">
                        <option value="" disabled @selected(!old('gender'))>Pilih jenis kelamin</option>
                        <option value="Laki-laki" @selected(old('gender') === 'Laki-laki')>Laki-laki</option>
                        <option value="Perempuan" @selected(old('gender') === 'Perempuan')>Perempuan</option>
                    </select>
                    @error('gender')<p class="mt-1 text-xs font-semibold text-red-700">{{ $message }}</p>@enderror
                </div>
                <div>
                    <label for="email" class="block text-xs font-bold text-gray-700 uppercase mb-1">Email</label>
                    <input id="email" type="email" name="email" value="{{ old('email') }}" required placeholder="email@domain.com" autocomplete="email" class="{{ $inputClass }}">
                    <p class="text-[11px] font-medium text-gray-500 mt-1">Jika sudah pernah mendaftar, gunakan halaman login anggota.</p>
                    @error('email')<p class="mt-1 text-xs font-semibold text-red-700">{{ $message }}</p>@enderror
                </div>
                <div>
                    <label for="phone" class="block text-xs font-bold text-gray-700 uppercase mb-1">No. WhatsApp</label>
                    <input id="phone" type="tel" inputmode="tel" name="phone" value="{{ old('phone') }}" required placeholder="08xxxxxxxxxx" class="{{ $inputClass }}">
                    <p class="text-[11px] text-gray-500 font-medium mt-1">Nomor ini juga bisa dipakai untuk masuk ke akun.</p>
                </div>
                <!-- Foto anggota digunakan oleh admin, profil anggota, dan KIA. -->
                <div class="rounded-2xl border border-[#D9DDD8] bg-[#FAFBF8] p-4 sm:p-5">
                    <label class="block text-xs font-bold text-gray-700 uppercase mb-3" for="nl-photo-gallery">
                        Foto Anggota <span class="text-red-600">*</span>
                    </label>
                    <div class="flex items-center gap-4">
                        <div class="h-24 w-20 shrink-0 overflow-hidden rounded-xl border border-[#D9DDD8] bg-[#E8ECE6] flex items-center justify-center">
                            <img id="nl-photo-preview" alt="Preview foto anggota" class="hidden h-full w-full object-cover">
                            <i id="nl-photo-placeholder" class="ph ph-user text-4xl text-[#718075]" aria-hidden="true"></i>
                        </div>
                        <div class="min-w-0 flex-1 space-y-2">
                            <label for="nl-photo-gallery" class="inline-flex cursor-pointer items-center gap-2 rounded-lg bg-[#183C2F] px-4 py-2.5 text-xs font-bold text-white hover:bg-[#27523E]">
                                <i class="ph ph-image text-base"></i> Pilih dari galeri
                            </label>
                            <button type="button" id="nl-open-camera" class="inline-flex cursor-pointer items-center gap-2 rounded-lg border border-[#183C2F] px-4 py-2.5 text-xs font-bold text-[#183C2F] hover:bg-[#EAF0E8]">
                                <i class="ph ph-camera text-base"></i> Ambil selfie
                            </button>
                            <p id="nl-photo-name" class="break-words text-[11px] text-gray-500" aria-live="polite">Belum ada foto dipilih.</p>
                        </div>
                    </div>
                    <input id="nl-photo-gallery" type="file" name="photo" accept="image/jpeg,image/png,image/webp" required class="sr-only" aria-label="Pilih foto anggota dari galeri">
                    <p class="mt-3 text-[11px] text-[#66756B]">Foto wajah jelas, JPG/PNG/WebP maksimal 2 MB. Selfie memakai kamera langsung setelah izin diberikan. Foto baru dikirim saat formulir disubmit.</p>
                    @error('photo')<p class="mt-2 text-xs font-semibold text-red-700">{{ $message }} Pilih foto kembali.</p>@enderror
                    <p id="nl-photo-error" class="hidden mt-2 text-xs font-semibold text-red-700" role="alert"></p>
                </div>
            </div>
            <!-- Tahap 2: Domisili -->
            <div class="nl-signup-step space-y-4" data-step="2" @if($startStep !== 2) hidden @endif>
                <div>
                    <label for="address" class="block text-xs font-bold text-gray-700 uppercase mb-1">Alamat Lengkap</label>
                    <textarea id="address" name="address" rows="4" required placeholder="Dusun, RT/RW, desa" class="{{ $inputClass }}">{{ old('address') }}</textarea>
                </div>
            </div>
            <!-- Tahap 3: Banom dan Akun -->
            <div class="nl-signup-step space-y-4" data-step="3" @if($startStep !== 3) hidden @endif>
                <div>
                    <label for="banom" class="block text-xs font-bold text-gray-700 uppercase mb-1">Pilihan Banom</label>
                    <select id="banom" name="banom" required class="{{ $inputClass }}">
                        @foreach (['IPNU' => 'IPNU (Pelajar Putra)', 'IPPNU' => 'IPPNU (Pelajar Putri)', 'Ansor' => 'GP Ansor / Banser', 'Fatayat' => 'Fatayat NU', 'Muslimat' => 'Muslimat NU', 'NU' => 'Nahdlatul Ulama'] as $value => $label)
                            <option value="{{ $value }}" @selected(old('banom') === $value)>{{ $label }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <div class="flex items-center justify-between mb-1">
                        <label for="password" class="block text-xs font-bold text-gray-700 uppercase">Password</label>
                        <button id="nl-toggle-password" type="button" class="text-[11px] font-black text-[#183C2F] hover:underline" aria-pressed="false">
                            Tampilkan
                        </button>
                    </div>
                    <input id="password" type="password" name="password" required minlength="8" placeholder="Minimal 8 karakter" autocomplete="new-password" class="{{ $inputClass }}">
                </div>
                <div>
                    <label for="password_confirmation" class="block text-xs font-bold text-gray-700 uppercase mb-1">Ulangi Password</label>
                    <input id="password_confirmation" type="password" name="password_confirmation" required placeholder="Ulangi password" autocomplete="new-password" class="{{ $inputClass }}">
                </div>
            </div>
            <div class="flex items-center justify-between gap-3 mt-8">
                <!-- SATU tombol kembali: pada langkah 1 ke beranda, selebihnya mundur satu tahap. -->
                <button
                    type="button"
                    id="nl-back"
                    class="bg-[#F5F4F0] hover:bg-gray-200 text-[#183C2F] text-xs sm:text-sm font-black px-5 sm:px-7 py-3.5 rounded-full transition flex items-center gap-2"
                >
                    <i class="ph ph-arrow-left"></i>
                    Kembali
                </button>
                <button
                    type="button"
                    id="nl-next"
                    class="nl-signup-action bg-[#183C2F] hover:bg-[#245640] text-white text-xs sm:text-sm font-black px-6 sm:px-8 py-3.5 rounded-full transition flex items-center gap-2"
                    @if($startStep === 3) hidden @endif
                >
                    Lanjut
                    <i class="ph ph-arrow-right"></i>
                </button>
                <button
                    type="submit"
                    id="nl-submit"
                    class="nl-signup-action bg-[#183C2F] hover:bg-[#245640] text-white text-xs sm:text-sm font-black px-6 sm:px-8 py-3.5 rounded-full transition flex items-center gap-2 shadow-md"
                    @if($startStep !== 3) hidden @endif
                >
                    <i class="ph ph-paper-plane-tilt"></i>
                    Kirim Pendaftaran
                </button>
            </div>
        </form>
        <p class="text-center text-xs font-semibold text-gray-600 mt-6">
            Sudah punya akun?
            <a href="{{ route('member.login') }}" class="font-black text-[#183C2F] hover:underline">Masuk di sini</a>
        </p>
    </div>
</div>
<div class="nl-camera-dialog" id="nl-camera-dialog" hidden role="dialog" aria-modal="true" aria-labelledby="nl-camera-title">
    <div class="nl-camera-panel">
        <div class="flex items-center justify-between gap-3 mb-3">
            <h2 id="nl-camera-title" class="font-display text-3xl">AMBIL SELFIE</h2>
            <button type="button" id="nl-camera-close" class="text-sm font-bold underline underline-offset-4">Tutup</button>
        </div>
        <video id="nl-camera-video" class="nl-camera-video" autoplay muted playsinline aria-label="Pratinjau kamera depan"></video>
        <p class="text-xs text-[#587264] mt-2">Posisikan wajah di tengah gambar. Foto dapat diganti sebelum mengirim pendaftaran.</p>
        <div class="nl-camera-controls">
            <button type="button" id="nl-camera-cancel" class="border border-[#183C2F] px-5 py-3 rounded-lg text-xs font-bold">Batal</button>
            <button type="button" id="nl-camera-shot" class="bg-[#183C2F] text-white px-5 py-3 rounded-lg text-xs font-bold">Jepret foto</button>
        </div>
    </div>
</div>
<!-- Script berada langsung dalam konten agar tidak tergantung bundler. -->
<script>
(function () {
    function initSignupWizard() {
        const root = document.getElementById('nl-signup-wizard');
        if (!root || root.dataset.initialized === 'true') return;
        root.dataset.initialized = 'true';
        const form = document.getElementById('nl-signup-form');
        const backButton = document.getElementById('nl-back');
        const nextButton = document.getElementById('nl-next');
        const submitButton = document.getElementById('nl-submit');
        const progressItems = [...root.querySelectorAll('[data-progress-step]')];
        const panels = [...root.querySelectorAll('.nl-signup-step')];
        const togglePasswordButton = document.getElementById('nl-toggle-password');
        const password = document.getElementById('password');
        const passwordConfirmation = document.getElementById('password_confirmation');
        const galleryInput = document.getElementById('nl-photo-gallery');
        const photoPreview = document.getElementById('nl-photo-preview');
        const photoPlaceholder = document.getElementById('nl-photo-placeholder');
        const photoName = document.getElementById('nl-photo-name');
        const photoError = document.getElementById('nl-photo-error');
        const cameraDialog = document.getElementById('nl-camera-dialog');
        const cameraVideo = document.getElementById('nl-camera-video');
        const openCameraButton = document.getElementById('nl-open-camera');
        const shotButton = document.getElementById('nl-camera-shot');
        let cameraStream = null;
        let previewUrl = null;
        const maxPhotoBytes = 2 * 1024 * 1024;
        function setPhotoError(message) {
            photoError.textContent = message || '';
            photoError.classList.toggle('hidden', !message);
        }
        function displayPhoto(file) {
            const validTypes = ['image/jpeg', 'image/png', 'image/webp'];
            if (!file || !validTypes.includes(file.type) || file.size > maxPhotoBytes) {
                galleryInput.value = '';
                photoPreview.classList.add('hidden');
                photoPreview.removeAttribute('src');
                photoPlaceholder.classList.remove('hidden');
                photoName.textContent = 'Belum ada foto dipilih.';
                setPhotoError('Gunakan JPG, PNG, atau WebP berukuran maksimal 2 MB.');
                return;
            }
            if (previewUrl) URL.revokeObjectURL(previewUrl);
            previewUrl = URL.createObjectURL(file);
            photoPreview.src = previewUrl;
            photoPreview.classList.remove('hidden');
            photoPlaceholder.classList.add('hidden');
            photoName.textContent = file.name;
            setPhotoError('');
        }
        galleryInput.addEventListener('change', () => displayPhoto(galleryInput.files[0]));
        function stopCamera() {
            if (cameraStream) cameraStream.getTracks().forEach(track => track.stop());
            cameraStream = null;
            cameraVideo.srcObject = null;
            cameraDialog.hidden = true;
        }
        async function openCamera() {
            if (!navigator.mediaDevices || !navigator.mediaDevices.getUserMedia) {
                setPhotoError('Kamera browser tidak tersedia. Gunakan HTTPS atau localhost, atau pilih foto dari galeri.');
                return;
            }
            openCameraButton.disabled = true;
            try {
                cameraStream = await navigator.mediaDevices.getUserMedia({ audio: false, video: { facingMode: 'user', width: { ideal: 1280 }, height: { ideal: 960 } } });
                cameraVideo.srcObject = cameraStream;
                cameraDialog.hidden = false;
                await cameraVideo.play();
                shotButton.focus();
                setPhotoError('');
            } catch (error) {
                stopCamera();
                setPhotoError('Kamera tidak dapat dibuka. Periksa izin kamera, atau pilih foto dari galeri.');
            } finally {
                openCameraButton.disabled = false;
            }
        }
        async function takePhoto() {
            if (!cameraStream || !cameraVideo.videoWidth) {
                setPhotoError('Kamera belum siap. Coba kembali.');
                return;
            }
            const canvas = document.createElement('canvas');
            const scale = Math.min(1, 1080 / cameraVideo.videoWidth, 1440 / cameraVideo.videoHeight);
            canvas.width = Math.max(1, Math.floor(cameraVideo.videoWidth * scale));
            canvas.height = Math.max(1, Math.floor(cameraVideo.videoHeight * scale));
            const ctx = canvas.getContext('2d');
            ctx.translate(canvas.width, 0);
            ctx.scale(-1, 1);
            ctx.drawImage(cameraVideo, 0, 0, canvas.width, canvas.height);
            const blob = await new Promise(resolve => canvas.toBlob(resolve, 'image/jpeg', .83));
            if (!blob) { setPhotoError('Foto gagal dibuat. Silakan coba lagi.'); return; }
            if (blob.size > maxPhotoBytes) { setPhotoError('Hasil foto terlalu besar. Coba lagi.'); return; }
            const file = new File([blob], 'selfie-nulesmana.jpg', { type: 'image/jpeg', lastModified: Date.now() });
            const transfer = new DataTransfer();
            transfer.items.add(file);
            galleryInput.files = transfer.files;
            displayPhoto(file);
            stopCamera();
            openCameraButton.focus();
        }
        openCameraButton.addEventListener('click', openCamera);
        shotButton.addEventListener('click', () => takePhoto().catch(() => setPhotoError('Gagal mengambil foto. Silakan coba lagi.')));
        document.getElementById('nl-camera-close').addEventListener('click', stopCamera);
        document.getElementById('nl-camera-cancel').addEventListener('click', stopCamera);
        cameraDialog.addEventListener('click', event => { if (event.target === cameraDialog) stopCamera(); });
        document.addEventListener('keydown', event => { if (event.key === 'Escape' && !cameraDialog.hidden) stopCamera(); });
        window.addEventListener('pagehide', () => { stopCamera(); if (previewUrl) URL.revokeObjectURL(previewUrl); });
        const homeUrl = @json(route('home'));
        let step = Math.min(3, Math.max(1, Number(root.dataset.startStep) || 1));
        function setStep(number) {
            step = Math.min(3, Math.max(1, number));
            panels.forEach(panel => {
                panel.hidden = Number(panel.dataset.step) !== step;
            });
            progressItems.forEach(item => {
                const n = Number(item.dataset.progressStep);
                const circle = item.querySelector('[data-progress-bubble]');
                const title = item.querySelector('[data-progress-title]');
                const line = item.querySelector('[data-progress-line]');
                const active = n <= step;
                const current = n === step;
                circle.classList.toggle('bg-[#183C2F]', active);
                circle.classList.toggle('text-white', active);
                circle.classList.toggle('bg-gray-100', !active);
                circle.classList.toggle('text-gray-400', !active);
                circle.classList.toggle('ring-4', current);
                circle.classList.toggle('ring-[#183C2F]/15', current);
                circle.textContent = n < step ? '✓' : String(n);
                if (current) circle.setAttribute('aria-current', 'step');
                else circle.removeAttribute('aria-current');
                title.classList.toggle('text-[#183C2F]', active);
                title.classList.toggle('text-gray-400', !active);
                if (line) {
                    line.classList.toggle('bg-[#183C2F]', active);
                    line.classList.toggle('bg-gray-200', !active);
                }
            });
            nextButton.hidden = step === 3;
            submitButton.hidden = step !== 3;
        }
        function firstInvalidField(number) {
            const panel = panels.find(element => Number(element.dataset.step) === number);
            const requiredFields = panel ? [...panel.querySelectorAll('[required]')] : [];
            return requiredFields.find(field => !field.checkValidity()) || null;
        }
        function checkStep(number) {
            const invalid = firstInvalidField(number);
            if (!invalid) return true;
            setStep(number);
            window.requestAnimationFrame(() => invalid.reportValidity());
            return false;
        }
        backButton.addEventListener('click', () => {
            if (step === 1) window.location.assign(homeUrl);
            else setStep(step - 1);
        });
        nextButton.addEventListener('click', () => {
            if (checkStep(step)) setStep(step + 1);
        });
        togglePasswordButton.addEventListener('click', () => {
            const visible = password.type === 'password';
            password.type = visible ? 'text' : 'password';
            passwordConfirmation.type = visible ? 'text' : 'password';
            togglePasswordButton.textContent = visible ? 'Sembunyikan' : 'Tampilkan';
            togglePasswordButton.setAttribute('aria-pressed', String(visible));
        });
        form.addEventListener('keydown', event => {
            if (event.key !== 'Enter' || step === 3 || event.target.tagName === 'TEXTAREA') return;
            event.preventDefault();
            if (checkStep(step)) setStep(step + 1);
        });
        form.addEventListener('submit', event => {
            passwordConfirmation.setCustomValidity('');
            if (password.value !== passwordConfirmation.value) {
                passwordConfirmation.setCustomValidity('Konfirmasi password tidak sama.');
            }
            for (let number = 1; number <= 3; number++) {
                if (!checkStep(number)) {
                    event.preventDefault();
                    return;
                }
            }
        });
        passwordConfirmation.addEventListener('input', () => {
            passwordConfirmation.setCustomValidity('');
        });
        password.addEventListener('input', () => {
            passwordConfirmation.setCustomValidity('');
        });
        setStep(step);
    }
    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', initSignupWizard, { once: true });
    } else {
        initSignupWizard();
    }
})();
</script>
@endsection
