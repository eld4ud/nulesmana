$ErrorActionPreference = 'Stop'
try {
    $root = (Get-Location).Path
    $latest = Join-Path $root 'backup_nulesmana_stabilizer\LATEST.txt'
    if (!(Test-Path $latest)) { throw 'File LATEST.txt tidak ditemukan.' }
    $folder = (Get-Content -LiteralPath $latest -Raw).Trim()
    if (!(Test-Path (Join-Path $folder 'welcome.blade.php'))) { throw 'Backup tidak ditemukan.' }
    Copy-Item -LiteralPath (Join-Path $folder 'welcome.blade.php') -Destination (Join-Path $root 'resources\views\welcome.blade.php') -Force
    $dest = Join-Path $root 'public\css\nulesmana-mobile-stable.css'
    if (Test-Path (Join-Path $folder 'css-was-absent.txt')) {
        if (Test-Path $dest) { Remove-Item -LiteralPath $dest -Force }
    } else {
        Copy-Item -LiteralPath (Join-Path $folder 'nulesmana-mobile-stable.css') -Destination $dest -Force
    }
    if (Get-Command php -ErrorAction SilentlyContinue) { & php artisan view:clear }
    Write-Host 'Kembali ke kondisi sebelum pemasangan.' -ForegroundColor Green
    exit 0
} catch {
    Write-Host "ROLLBACK GAGAL: $($_.Exception.Message)" -ForegroundColor Red
    exit 1
}
