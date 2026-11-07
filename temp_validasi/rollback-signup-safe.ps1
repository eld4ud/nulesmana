# Pulihkan patch UI terakhir; tidak mengubah database maupun route.
$ErrorActionPreference = 'Stop'
$root = (Get-Location).Path
if (!(Test-Path (Join-Path $root 'artisan'))) { throw 'Buka root Laravel dulu.' }
$base = Join-Path $root 'storage\backups'
$backup = Get-ChildItem $base -Directory -Filter 'signup-ui-*' -ErrorAction Stop |
    Sort-Object Name -Descending | Select-Object -First 1
if (!$backup) { throw 'Backup signup-ui tidak ditemukan.' }
$manifest = Get-Content (Join-Path $backup.FullName 'manifest.json') -Raw | ConvertFrom-Json
Copy-Item (Join-Path $backup.FullName 'signup.blade.php') (Join-Path $root 'resources\views\pages\signup.blade.php') -Force
$css = Join-Path $root 'public\css\nulesmana-signup-errors.css'
$js = Join-Path $root 'public\js\nulesmana-signup-errors.js'
if ($manifest.cssExisted) { Copy-Item (Join-Path $backup.FullName 'previous.css') $css -Force }
elseif (Test-Path $css) { Remove-Item $css -Force }
if ($manifest.jsExisted) { Copy-Item (Join-Path $backup.FullName 'previous.js') $js -Force }
elseif (Test-Path $js) { Remove-Item $js -Force }
Write-Host "Berhasil dikembalikan dari: $($backup.FullName)" -ForegroundColor Green
Write-Host 'Jalankan: php artisan view:clear'
