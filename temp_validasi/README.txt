NULESMANA - VALIDASI FORM ANGGOTA (KOTAK MERAH + GETAR)

Dibuat untuk form tiga langkah di resources/views/pages/signup.blade.php
sesuai kode yang tersedia di GitHub. Tidak mengganti wizard, upload foto,
controller, database, navbar, animasi, maupun dashboard admin.

PASANG:
1. Download ZIP ke Downloads.
2. Buka PowerShell VS Code di root proyek Laravel.
3. Expand-Archive -LiteralPath "$HOME\Downloads\Nulesmana_Keamanan_Form_Validasi.zip" -DestinationPath ".\temp_validasi" -Force
4. powershell -NoProfile -ExecutionPolicy Bypass -File ".\temp_validasi\install-signup-safe.ps1"
5. php artisan view:clear
6. Refresh browser Ctrl+Shift+R dan tes tombol Lanjut dengan email kosong.

TES:
- Email kosong: border merah, getar singkat, pesan 'Email wajib diisi.'
- Format salah: 'Format email belum benar'.
- Foto kosong: bingkai foto merah dan pesan, tidak lanjut ke tahap berikut.
- Password <8 dan konfirmasi tidak sama: tampil kesalahan saat submit.
- Semua benar: wizard melanjutkan dan Laravel tetap memvalidasi data di server.
- Preferensi reduce motion: tanpa animasi getar.

ROLLBACK:
powershell -NoProfile -ExecutionPolicy Bypass -File ".\temp_validasi\rollback-signup-safe.ps1"

OPSIONAL PERKUAT REGISTRASI:
powershell -NoProfile -ExecutionPolicy Bypass -File ".\temp_validasi\security\aktifkan-rate-limit.ps1"
Perlu diuji dengan jumlah registrasi wajar dan akses bersama satu IP.

BATASAN:
- Merah/getar hanya UX. Validasi server Laravel TETAP WAJIB.
- Foto anggota tersimpan pada disk public di versi repo. Audit privasi
  storage dan tampilan NIK sebelum rilis resmi.
- Installer menolak patch bila struktur file lokal tidak sesuai.
