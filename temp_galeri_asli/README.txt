NULESMANA - PULIHKAN GALERI ORIGINAL (tanpa autoplay)

Mengembalikan hanya CSS dan JavaScript galeri yang ada di welcome.blade.php,
berdasarkan fitur coverflow asli di repo eld4ud/nulesmana.

Diperbaiki:
- CSS tampil sebagai teks mentah di halaman
- Foto menembus bagian lain karena posisi JS tidak aktif
- Scroll mouse tidak lagi menggeser galeri
- Autoplay tambahan dari paket sebelumnya dinonaktifkan

Dipertahankan:
- Markup HTML galeri (termasuk penggunaan WebP jika sudah diedit)
- Foto dan link berita
- Hero, animasi TechText, dashboard admin, database, route, controller

CARA INSTAL
1) Buka PowerShell VS Code di root proyek Laravel (ada file artisan)
2) Ekstrak ZIP ini ke temp_galeri_asli
3) Jalankan:
   powershell -NoProfile -ExecutionPolicy Bypass -File .\temp_galeri_asli\pulihkan-galeri.ps1
4) Refresh paksa halaman: Ctrl+Shift+R

Perlindungan: installer mengecek penanda galeri dan ulasan. Jika tidak cocok,
berhenti tanpa mengubah file. Backup otomatis disimpan di backup_galeri_asli.

CATATAN: jika pengguna mengedit struktur section secara besar-besaran,
validasi bisa gagal dan harus diperiksa manual. File foto sama sekali tidak dihapus.

Jika ingin mengembalikan file sebelum pemasangan paket ini:
   powershell -NoProfile -ExecutionPolicy Bypass -File .\temp_galeri_asli\kembalikan-backup-galeri.ps1
