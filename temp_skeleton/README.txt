NULESMANA - PATCH PERFORMA SKELETON (UJI A/B)
================================================

Temuan: repository Nulesmana punya overlay #nu-skeleton yang menutupi
halaman sampai foto hero siap, dengan fallback timeout 5500 ms.
Pada mobile/jaringan lambat, overlay seperti ini dapat menunda tampilan
konten utama, sehingga patut diuji sebagai sumber LCP tinggi.

Patch ini HANYA menyisipkan CSS di bagian awal <head> file
resources/views/welcome.blade.php:
- menyembunyikan overlay skeleton saat pertama kali render;
- membuat teks/foto hero tidak menunggu kelas animasi pembuka;
- tidak mengubah galeri, TechText, Tailwind, Google Fonts, admin,
  controller, database, maupun route.

Animasi lain, termasuk TechText dan coverflow, tetap ada. Hero tidak lagi
menunggu efek masuk lama supaya konten cepat muncul. Kalau kurang cocok,
jalankan rollback-skeleton-safe.ps1.

CARA PAKAI (PowerShell di folder Laravel, harus ada artisan):
1. Ekstrak ZIP lewat Expand-Archive.
2. powershell -NoProfile -ExecutionPolicy Bypass -File ".\temp_skeleton\cek-performa.ps1"
3. powershell -NoProfile -ExecutionPolicy Bypass -File ".\temp_skeleton\install-skeleton-safe.ps1"
4. php artisan view:clear
5. Refresh browser Ctrl+Shift+R; uji Lighthouse Mobile 3 kali.

ROLLBACK:
  powershell -NoProfile -ExecutionPolicy Bypass -File ".\temp_skeleton\rollback-skeleton-safe.ps1"
  php artisan view:clear

Script akan menolak mengubah proyek jika elemen skeleton tidak ditemukan.
Backup welcome.blade.php dibuat otomatis sebelum pengubahan.

PENTING: efek pada skor Lighthouse BELUM diuji pada Laravel lokal kamu.
Jangan menilai dari satu kali audit. Bandingkan median 3 audit dengan
setting sama dan pastikan tampilan hero/navbar/galeri tetap berjalan.
Jika hasil lebih buruk, rollback. Jangan menghapus Tailwind CDN sekaligus
saat pengujian ini, supaya tahu dampak perubahan secara terpisah.
