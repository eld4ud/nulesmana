# Nulesmana: Supabase Storage patch (berdasarkan ZIP source 7 November 2026)

**Tujuan:** Memindahkan upload gambar ke dua bucket Supabase tanpa mengganti Blade desain, dashboard admin, data, atau migrasi.

- `news-images` (public): berita, galeri, foto struktur organisasi, dan metadata posisi crop `organization-positions/*.json`.
- `member-photos` (private): foto dari pendaftaran anggota, edit admin, dan kartu anggota. Foto dibaca melalui route Laravel `/media/member-photo/{member}`. Route ini mengecek `auth` dan mengizinkan **admin** atau **anggota sendiri yang sudah approved**. Ia men-stream foto, tidak membeberkan URL atau kredensial bucket privat.
- Laragon dan `.env` utama tetap mode `local` secara default; `.env.supabase` dan Vercel harus mengaktifkan mode `supabase` secara eksplisit.
- Foto dan metadata crop struktur disimpan di bucket publik karena tampil di website publik. Bucket `news-images` perlu mengizinkan `application/json` juga jika kamu memakai pembatasan MIME. Screenshot bucket pengguna masih **Any**, jadi saat ini kompatibel.

## Pasang di Windows PowerShell VS Code

1. Download `Nulesmana_Supabase_Storage_Patch.zip` ke folder Downloads.
2. Buka terminal PowerShell di proyek `C:\Users\user\MCCrud`.
3. Jalankan:

```powershell
cd "C:\Users\user\MCCrud"
Expand-Archive -LiteralPath "$HOME\Downloads\Nulesmana_Supabase_Storage_Patch.zip" -DestinationPath ".\temp_nulesmana_storage" -Force
powershell -NoProfile -ExecutionPolicy Bypass -File ".\temp_nulesmana_storage\install.ps1"
php artisan config:clear
php artisan view:clear
php artisan route:list --path=media/member-photo
php -l app/Support/NulesmanaMedia.php
```

Installer membandingkan checksum file dengan ZIP source yang diperiksa. **Jika file lokal berbeda, ia BERHENTI** dan tidak memaksa timpa. Backup tersimpan di `%LOCALAPPDATA%\NulesmanaStoragePatchBackups\...` (di luar repo), dan path backup dicetak ke terminal.

## Aktifkan pada `.env.supabase` (bukan `.env` lokal)

Tambah di akhir `.env.supabase`:

```dotenv
NULESMANA_STORAGE_MODE=supabase
```

Biarkan nilai `SUPABASE_S3_KEY`, `SUPABASE_S3_SECRET`, `SUPABASE_S3_ENDPOINT`, `SUPABASE_S3_REGION`, `SUPABASE_NEWS_PUBLIC_URL` yang sudah berhasil diuji sebelumnya. **Jangan mengunggah `.env.supabase`**. Kedua disk `supabase_news` dan `supabase_members` tetap harus ada di `config/filesystems.php` dari installer sebelumnya.

Tes mode tanpa menunjukkan rahasia:

```powershell
php artisan config:clear
php artisan --env=supabase tinker --execute="dump(config('filesystems.nulesmana_mode'), \App\Support\NulesmanaMedia::newsDisk(), \App\Support\NulesmanaMedia::memberDisk());"
```

Harapan: `supabase`, `supabase_news`, `supabase_members`.

Untuk website lokal (`php artisan serve`, `.env` tanpa `--env`), mode default tetap `local` dan tidak mengubah URL/konten galeri.

## Sebelum deploy ke Vercel

Set `NULESMANA_STORAGE_MODE=supabase` di **Environment Variables Vercel**, dengan key S3 dan DB yang sama dari `.env.supabase`, jangan commit secrets. `APP_URL` harus cocok dengan URL deployment, `APP_KEY` harus ditetapkan, `APP_DEBUG=false`. Untuk production set `SESSION_DRIVER=database` dan `CACHE_STORE=database` setelah DB benar.

**Ini patch integrasi Storage, bukan deploy otomatis.** Test listing S3 sebelumnya sukses, tetapi upload + streaming HTTP dan Docker build belum diuji pada lingkunganmu. Konfigurasi `vercel.json`, `Dockerfile.vercel`, `Caddyfile` milikmu tidak diubah paket ini. Sebelum deploy, cek boot container, variabel environment, akun admin, database, dan semua halaman pada Preview Deployment.

## Penting: migrasi data lama

Perubahan mode **tidak** memindahkan foto yang sebelumnya ada di `storage/app/public` ke Supabase. Data anggota/berita dari MySQL lokal juga **belum otomatis pindah** ke PostgreSQL Supabase. Bila DB remote memakai path lama tetapi objeknya belum diunggah ke bucket yang tepat, foto tidak tampil. Kita perlu migrasi file + data secara terpisah dan aman. Foto private lama yang masih ada di `public/storage` pada Laragon tetap perlu audit privasi sebelum website publik digunakan.

Belum ada migration database tambahan dalam patch. Tidak menyentuh tabel `events` yang memang tidak dipakai.

## Keamanan dan keterbatasan

- S3 key hanya server-side; jangan taruh di Blade atau JavaScript.
- Semua foto anggota baru dari controller yang termasuk source ZIP akan masuk bucket private di mode Supabase.
- `KartuController` mempunyai metode uploadFoto, tetapi saat ini tidak ada route uploadFoto pada `routes/member.php` versi ZIP. Tidak dibuat route baru karena perubahan fitur akun di luar lingkup patch ini.
- Foto anggota untuk member yang *belum approved* hanya dapat dilihat admin. Kartu untuk member approved tetap bisa ditampilkan melalui route privat.
- Existing fallback foto lama `member-photos/{id}/avatar.*` digunakan hanya di mode lokal, bukan mode Supabase.
- Public bucket menyimpan crop JSON yang bersifat nonrahasia. Bila nanti kamu membatasi bucket hanya menerima MIME image, tambahkan `application/json` agar edit posisi struktur tidak gagal.

## Rollback

```powershell
cd "C:\Users\user\MCCrud"
powershell -NoProfile -ExecutionPolicy Bypass -File ".\temp_nulesmana_storage\rollback.ps1"
php artisan config:clear
php artisan view:clear
```

Rollback berhenti jika file patch sudah kamu modifikasi setelah pemasangan, untuk menghindari kehilangan edit terbaru. Ini hanya mengembalikan **file kode**, tidak membatalkan upload/data yang sudah dibuat.

## Uji singkat sebelum commit

1. Gunakan akun uji, tanpa foto/data anggota asli.
2. Coba tambah berita berfoto di mode Supabase, pastikan objek masuk ke `news-images/news/` dan foto tampil di galeri serta detail.
3. Coba pendaftaran anggota uji berfoto, pastikan objek masuk ke `member-photos/members/` dan URL publik Supabase tidak bisa mengaksesnya.
4. Admin dapat melihat foto anggota uji, pengunjung tanpa login tidak bisa mengakses `/media/member-photo/{member}`.
5. Tambah foto jabatan dan edit slider crop di admin, pastikan file berada di `news-images/organization-positions/`.
6. Pastikan `.env.supabase` diabaikan Git, tinjau `git status --short`, dan commit hanya file yang telah diperiksa. Jangan pakai `git add .` sembarangan.
