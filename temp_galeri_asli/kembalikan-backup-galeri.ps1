$ErrorActionPreference = 'Stop'
try {
    $root = (Get-Location).Path
    if (!(Test-Path (Join-Path $root 'artisan'))) { throw 'Harus berada di root proyek Laravel.' }
    $folder = Join-Path $root 'backup_galeri_asli'
    $recent = Get-ChildItem -LiteralPath $folder -Directory -ErrorAction Stop |
        Sort-Object Name -Descending | Select-Object -First 1
    if (!$recent) { throw 'Backup galeri tidak ditemukan.' }
    $backup = Join-Path $recent.FullName 'welcome.blade.php'
    if (!(Test-Path $backup)) { throw 'File backup tidak ditemukan.' }
    Copy-Item -LiteralPath $backup -Destination (Join-Path $root 'resources\views\welcome.blade.php') -Force
    if (Get-Command php -ErrorAction SilentlyContinue) { & php artisan view:clear }
    Write-Host "Backup sebelumnya dipulihkan dari $($recent.FullName)" -ForegroundColor Green
    exit 0
} catch {
    Write-Host "ROLLBACK GAGAL: $($_.Exception.Message)" -ForegroundColor Red
    exit 1
}
