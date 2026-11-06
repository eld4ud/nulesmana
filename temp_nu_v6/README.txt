NULESMANA V6 | MOBILE RAPI + ANIMASI RINGAN
========================================

Untuk proyek Laravel Nulesmana versi lokal (berdasarkan hero repo dan paket TechText sebelumnya).
Fokus: hero responsif, judul tanpa tabrakan di HP, kotak hover putus-putus,
animasinya tetap ada (intro, sweep, outline, click bounce, drag), teks kecil
lebih tegas, ukuran foto dan tombol proporsional di mobile.

INSTALL (PowerShell VS Code di C:\Users\user\MCCrud):
1) Download ZIP ke folder Downloads.
2) Di terminal proyek:
   Expand-Archive -LiteralPath "$HOME\Downloads\Nulesmana_Mobile_Ringan_Animasi_V6.zip" -DestinationPath ".\temp_nu_v6" -Force
   powershell -NoProfile -ExecutionPolicy Bypass -File ".\temp_nu_v6\install-nulesmana-v6.ps1"
   if ($LASTEXITCODE -ne 0) { throw "Instalasi gagal; baca error di atas." }
   Remove-Item ".\temp_nu_v6" -Recurse -Force
3) Jalankan php artisan serve jika perlu. Buka /, tekan Ctrl+Shift+R.

ROLLBACK (kalau hasilnya tidak cocok):
   powershell -NoProfile -ExecutionPolicy Bypass -File ".\temp_nu_v6\rollback-nulesmana-v6.ps1"
Jika folder temp sudah dihapus, ekstrak ZIP lagi, kemudian jalankan rollback di atas.
Installer membuat backup_nulesmana_v6_YYYYMMDD_HHMMSS di root proyek.

YANG DIUBAH:
- resources/views/welcome.blade.php (hanya H1 hero, class ID/hero, font tag, CSS/JS link)
- public/css/nulesmana-techtext.css
- public/css/nulesmana-public-type.css
- public/js/nulesmana-techtext.js

TIDAK DIUBAH:
- Dashboard admin, controller, route, database, gambar dan struktur data.
- CDN Tailwind tidak dihapus otomatis agar class eksisting tetap aman.

PENJELASAN:
- Ini adaptasi ringan berdasarkan interaksi TechText, bukan kode React Bits
  yang berjalan identik. Kotak hover dibuat dengan CSS, tidak ada Canvas loop.
- Animasi intro berjalan sekali. Sweep berjalan sesekali ketika judul terlihat;
  berhenti saat pengguna berinteraksi/berpindah tab.
- Pada HP yang tidak punya mouse, intro dan sweep tetap berjalan; kotak dapat
  muncul sesaat saat huruf diketuk. Geser huruf hanya untuk perangkat mouse.
- Animasi berhenti untuk pengunjung yang memilih Reduce Motion.
- Font: Manrope + Instrument Serif (serif italic) + font Arab Amiri;
  Bebas Neue dipertahankan untuk judul lama di bagian lain.
- Font referensi Dribbble tidak bisa diidentifikasi secara pasti. Ini pendekatan.
- Skor Lighthouse tidak dijamin meningkat karena halaman masih memakai Tailwind
  Play CDN dan resource lain. Harus diaudit ulang.
- Pakai link ?v=6 untuk mencegah cache mengunci aset lama.

UKURAN HP UNTUK DICEK DI DEVTOOLS: 360 x 800, 390 x 844, 430 x 932.
Jika installer gagal mengenali hero karena file lokal sudah diubah sendiri,
installer berhenti TANPA menimpa file. Hindari menghapus kode secara acak.
