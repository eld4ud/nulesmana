# OPSIONAL: batasi POST registrasi 10 percobaan per menit per IP.
$ErrorActionPreference = 'Stop'
if (!(Test-Path .\artisan)) { throw 'Buka root proyek Laravel dulu.' }
$file = (Resolve-Path '.\routes\web.php').Path
$content = [System.IO.File]::ReadAllText($file)
$old = "Route::post('/register-member', [PublicController::class, 'registerMember'])->name('member.register');"
$new = "Route::post('/register-member', [PublicController::class, 'registerMember'])->middleware('throttle:10,1')->name('member.register');"
if ($content.Contains($new)) { Write-Host 'Rate limit sudah aktif; tidak diubah.'; exit 0 }
if (!$content.Contains($old)) { throw 'Pola route berbeda. File tidak diubah.' }
$backup = "$file.bak-$(Get-Date -Format 'yyyyMMdd-HHmmss')"
Copy-Item $file $backup
[System.IO.File]::WriteAllText($file, $content.Replace($old, $new), [System.Text.UTF8Encoding]::new($false))
Write-Host "Rate limit pendaftaran terpasang. Backup: $backup" -ForegroundColor Green
Write-Host 'Jalankan: php artisan optimize:clear; php artisan route:list --path=register-member -v'
