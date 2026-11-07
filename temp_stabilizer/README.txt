NULESMANA STABILIZER V1 - DEADLINE SAFE

Tujuan:
- CSS mobile terpisah hanya untuk resources/views/welcome.blade.php
- memperbaiki foto coverflow yang keluar dari area stage
- bila kode galeri ditemukan rusak sebagai CSS mentah, pulihkan CSS dan JavaScript ORIGINAL tanpa mengganti markup foto/WebP
- hapus pemanggilan AUTOPLAY ekstra yang dipasang paket sebelumnya
- tidak menyentuh layout/admin, database, route, kode fitur berita, maupun JS TechText
- tidak menghapus Tailwind CDN; memerlukan pemeriksaan Tailwind Vite sebelum aman dihapus

CARA INSTAL di PowerShell dari root Laravel:
Expand-Archive -LiteralPath "$HOME\Downloads\Nulesmana_Stabilizer_Mobile_V1.zip" -DestinationPath ".\temp_stabilizer" -Force
powershell -NoProfile -ExecutionPolicy Bypass -File ".\temp_stabilizer\install-mobile-stable.ps1"
if ($LASTEXITCODE -ne 0) { throw "Instalasi gagal; jangan lanjut" }
php artisan optimize:clear

CEK HALAMAN (server harus aktif):
powershell -NoProfile -ExecutionPolicy Bypass -File ".\temp_stabilizer\cek-website.ps1"

ROLLBACK: jalankan segera bila terlihat masalah, sebelum edit lain:
powershell -NoProfile -ExecutionPolicy Bypass -File ".\temp_stabilizer\rollback-mobile-stable.ps1"

UJI MANUAL:
- 360, 390, 430, 768, 1366 px: navbar/tombol tidak kepotong; galeri tidak keluar section
- galeri dengan 2+ berita: tombol kiri kanan, wheel mouse di dalam stage, drag/swipe
- akun anggota biasa tidak boleh bisa akses /admin/dashboard
- akun admin: tambah berita, edit judul/tanggal/foto, cek perubahan publik
- pengurus: edit jabatan/foto, cek perubahan publik
- pendaftaran dan KTA: gunakan data uji, jangan data identitas asli
- ulang Lighthouse setelah masalah fungsional beres (3x, pilih nilai tengah)

Batasan:
Kode lokal belum tersedia sehingga tidak ada jaminan untuk semua revisi Blade.
Installer berhenti jika struktur galeri tidak dikenali. Tidak pernah menyentuh dashboard.
