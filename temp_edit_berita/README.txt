NULESMANA - FITUR EDIT BERITA (VERSI AMAN)

Menambahkan tombol Edit pada daftar berita di /admin/news dan halaman edit
/admin/news/{id}/edit.

FITUR
- Mengubah judul, tanggal, dan isi berita
- Mengganti foto dengan pratinjau
- Mempertahankan foto lama jika tidak memilih file baru
- Opsi melepas foto dari berita
- Validasi JPG/JPEG/PNG/WebP maksimal 2 MB
- Proteksi admin mengikuti middleware grup route admin
- Tanpa migrasi database, tanpa mengubah controller besar yang sudah ada
- Menggunakan layouts.admin yang sama

PEMASANGAN
1. Download ZIP dan ekstrak ke folder sementara.
2. Buka PowerShell di root Laravel (ada file artisan).
3. Jalankan: powershell -NoProfile -ExecutionPolicy Bypass -File ".\temp_edit_berita\install-edit-berita.ps1"
4. Jalankan: php artisan optimize:clear
5. Periksa: php artisan route:list --path=admin/news
6. Masuk ke /admin/news dan klik Edit.

PENGAMAN
Installer berhenti jika struktur route atau tombol Hapus tidak cocok dengan
versi lokalmu; jangan memaksa mengganti file secara manual tanpa pemeriksaan.
Backup otomatis tersimpan dalam backup_news_edit_TANGGAL di root Laravel.
Rollback menggunakan rollback-edit-berita.ps1 dari root Laravel.
Tidak menghapus foto lama secara otomatis agar tidak kehilangan data.

CATATAN
Paket disusun berdasarkan repo GitHub eld4ud/nulesmana saat diperiksa.
Jika kode lokal memiliki perubahan yang berbeda, validasi dapat berhenti.
