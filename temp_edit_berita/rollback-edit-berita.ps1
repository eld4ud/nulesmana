$ErrorActionPreference = 'Stop'
$root = (Get-Location).Path
if (-not (Test-Path (Join-Path $root 'artisan'))) {
    throw 'Jalankan rollback dari root Laravel Nulesmana.'
}
$backup = Get-ChildItem -LiteralPath $root -Directory -Filter 'backup_news_edit_*' |
    Sort-Object LastWriteTime -Descending | Select-Object -First 1
if (-not $backup) { throw 'Folder backup installer tidak ditemukan.' }
$routes = Join-Path $root 'routes\web.php'
$blade = Join-Path $root 'resources\views\admin\news.blade.php'
Copy-Item (Join-Path $backup.FullName 'web.php') $routes -Force
Copy-Item (Join-Path $backup.FullName 'news.blade.php') $blade -Force
$controller = Join-Path $root 'app\Http\Controllers\Admin\NewsEditController.php'
$view = Join-Path $root 'resources\views\admin\news-edit.blade.php'
if (Test-Path $controller) { Remove-Item $controller -Force }
if (Test-Path $view) { Remove-Item $view -Force }
Write-Host 'Rollback selesai. Jalankan php artisan optimize:clear' -ForegroundColor Green
Write-Host "Backup yang dipakai: $($backup.FullName)"
