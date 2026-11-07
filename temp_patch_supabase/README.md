# Patch migrasi Nulesmana untuk pengujian PostgreSQL / Supabase

## Ditemukan dalam 12 file yang diunggah

1. `2026_09_06_122807_create_events_table.php` sebelumnya salah membuat dan menghapus `news`, bukan `events`. **Perbaikan:** migrasi ini menjadi no-op, agar tidak menghapus berita ketika rollback. Tidak ada tabel `events` yang dibuat, karena struktur tabel events asli belum jelas. Bila aplikasi memang memerlukan tabel `events`, buat migrasi terpisah sesudah meninjau model/controller terkait.
2. `2026_10_14_000001_add_member_fields_to_users_table.php` memakai `->after('name')` (hanya untuk MySQL). **Perbaikan:** hapus modifier `after` agar lintas-database.
3. Dua migrasi `photo` punya kondisi `Schema::hasColumn`, sehingga untuk database baru tidak otomatis bertabrakan.

## Cara instal

Di direktori Laravel (contoh `C:\Users\user\MCCrud`), ekstrak ZIP patch ke `temp_patch_supabase` kemudian jalankan `powershell -NoProfile -ExecutionPolicy Bypass -File .\temp_patch_supabase\install.ps1`.

Installer akan membandingkan SHA-256 kedua migrasi asli dengan file ZIP yang Anda unggah, membuat backup lokal, menyalin patch, lalu lint PHP. **Installer tidak menjalankan migrasi**.

## Pemeriksaan selanjutnya

1. Pastikan `.env.supabase` adalah koneksi PostgreSQL dan `search_path=laravel`.
2. Jalankan `php artisan --env=supabase migrate --database=pgsql --pretend` untuk melihat perintah SQL tanpa menjalankan migrasi (sesuai Laravel docs).
3. Jika output aman, jalankan `php artisan --env=supabase migrate --database=pgsql` **hanya untuk project Supabase pengujian**.
4. Periksa schema dengan query `SELECT table_name FROM information_schema.tables WHERE table_schema='laravel' ORDER BY table_name;`.

**Peringatan**: jangan jalankan `migrate:fresh`, `migrate:refresh`, atau `migrate:rollback` di Supabase yang memiliki tabel bawaan. Pastikan `app/Support/Phone.php` ada sebelum menjalankan migrasi yang memakainya. Jika muncul error, hentikan dan baca output; jangan pakai `migrate:fresh` untuk mengatasinya.
