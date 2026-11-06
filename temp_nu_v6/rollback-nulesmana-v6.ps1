# Kembali ke kondisi sebelum V6 dari backup terakhir.
$ErrorActionPreference = 'Stop'
$root = (Get-Location).Path
if (!(Test-Path -LiteralPath (Join-Path $root 'artisan'))) { throw 'Buka root proyek Laravel terlebih dahulu.' }
$backup = Get-ChildItem -LiteralPath $root -Directory -Filter 'backup_nulesmana_v6_*' |
    Sort-Object Name -Descending | Select-Object -First 1
if (!$backup) { throw 'Backup V6 tidak ditemukan.' }
$paths = @(
    'resources\views\welcome.blade.php',
    'public\css\nulesmana-public-type.css',
    'public\css\nulesmana-techtext.css',
    'public\js\nulesmana-techtext.js'
)
$missing = @()
$missingFile = Join-Path $backup.FullName 'previously-absent.txt'
if (Test-Path -LiteralPath $missingFile) { $missing = @(Get-Content -LiteralPath $missingFile) }
foreach ($r in $paths) {
    $old = Join-Path $backup.FullName $r
    $target = Join-Path $root $r
    if (Test-Path -LiteralPath $old) { Copy-Item -LiteralPath $old -Destination $target -Force }
    elseif ($r -in $missing -and (Test-Path -LiteralPath $target)) { Remove-Item -LiteralPath $target -Force }
}
php artisan optimize:clear
Write-Host "Rollback ke $($backup.Name) selesai. Refresh browser (Ctrl+Shift+R)." -ForegroundColor Yellow
