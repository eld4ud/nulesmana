$ErrorActionPreference = 'Stop'

# Jalankan dari root Laravel, misalnya C:\Users\user\MCCrud
$root = (Get-Location).Path
if (-not (Test-Path (Join-Path $root 'artisan'))) {
    throw 'Buka terminal di folder utama Laravel Nulesmana terlebih dahulu.'
}

$packageDir = Split-Path -Parent $MyInvocation.MyCommand.Path
$routesPath = Join-Path $root 'routes\web.php'
$newsPath = Join-Path $root 'resources\views\admin\news.blade.php'
$newController = Join-Path $root 'app\Http\Controllers\Admin\NewsEditController.php'
$newView = Join-Path $root 'resources\views\admin\news-edit.blade.php'
$sourceController = Join-Path $packageDir 'app\Http\Controllers\Admin\NewsEditController.php'
$sourceView = Join-Path $packageDir 'resources\views\admin\news-edit.blade.php'

foreach ($needed in @($routesPath, $newsPath, $sourceController, $sourceView)) {
    if (-not (Test-Path -LiteralPath $needed)) { throw "File wajib tidak ditemukan: $needed" }
}
if ((Test-Path -LiteralPath $newController) -or (Test-Path -LiteralPath $newView)) {
    throw 'File fitur edit berita sudah ada. Installer dihentikan agar tidak menimpa perubahan sebelumnya.'
}

$routes = [IO.File]::ReadAllText($routesPath)
$news = [IO.File]::ReadAllText($newsPath)
if ($routes -notmatch "(?s)middleware\(\s*\[\s*'auth'\s*,\s*'admin'\s*\]\s*\)" -or
    $routes -notmatch "prefix\(\s*'admin'\s*\)") {
    throw 'Grup route admin tidak terdeteksi. Tidak ada file diubah.'
}
if ($routes -match "name\('news\.edit'\)" -or $routes -match "name\('news\.update'\)") {
    throw 'Route edit berita sudah tersedia. Tidak ada file diubah.'
}

# Sisipkan route sebelum DELETE berita, masih di dalam grup middleware admin.
$routeAnchor = "Route::delete('/news/{id}'"
if ($routes.Split([string[]]@($routeAnchor), [StringSplitOptions]::None).Count -ne 2) {
    throw 'Route DELETE berita tidak cocok dengan versi repo. Tidak ada file diubah.'
}
$newRoutes = @'
// EDIT BERITA: hanya admin, lewat grup middleware auth + admin di atas.
Route::get('/news/{id}/edit', [\App\Http\Controllers\Admin\NewsEditController::class, 'edit'])
    ->whereNumber('id')->name('news.edit');
Route::put('/news/{id}', [\App\Http\Controllers\Admin\NewsEditController::class, 'update'])
    ->whereNumber('id')->name('news.update');

'@
$updatedRoutes = $routes.Replace($routeAnchor, $newRoutes + $routeAnchor)

# Taruh tombol Edit tepat sebelum tombol Hapus tanpa merombak Blade saat ini.
$pattern = '<form\s+action\s*=\s*"\{\{\s*route\(''admin\.news\.destroy'',\s*\$news->id\)\s*\}\}"'
$matcher = [regex]::new($pattern)
if ($matcher.Matches($news).Count -ne 1) {
    throw 'Posisi tombol Hapus berbeda dari kode repo. Tidak ada file diubah.'
}
$editButton = @'
<a href="{{ route('admin.news.edit', $news->id) }}"
   class="inline-flex items-center gap-1 rounded-lg border border-[#cbdace] bg-[#edf4ee] px-3 py-2 text-xs font-bold text-[#173d30] transition hover:bg-[#dae9dd]">
    <i class="ph ph-pencil-simple"></i> Edit
</a>
'@
$updatedNews = $matcher.Replace($news, [System.Text.RegularExpressions.MatchEvaluator]{
    param($match)
    return $editButton + "`r`n" + $match.Value
}, 1)

# Pemeriksaan PHP controller sebelum mengubah proyek.
& php -l $sourceController
if ($LASTEXITCODE -ne 0) { throw 'Sintaks controller paket gagal divalidasi. Tidak ada file diubah.' }

$backupDir = Join-Path $root ('backup_news_edit_' + (Get-Date -Format 'yyyyMMdd_HHmmss'))
New-Item -ItemType Directory -Path $backupDir -Force | Out-Null
Copy-Item -LiteralPath $routesPath -Destination (Join-Path $backupDir 'web.php')
Copy-Item -LiteralPath $newsPath -Destination (Join-Path $backupDir 'news.blade.php')

$utf8 = [System.Text.UTF8Encoding]::new($false)
try {
    New-Item -ItemType Directory -Path (Split-Path $newController) -Force | Out-Null
    New-Item -ItemType Directory -Path (Split-Path $newView) -Force | Out-Null
    Copy-Item -LiteralPath $sourceController -Destination $newController
    Copy-Item -LiteralPath $sourceView -Destination $newView
    [IO.File]::WriteAllText($routesPath, $updatedRoutes, $utf8)
    [IO.File]::WriteAllText($newsPath, $updatedNews, $utf8)
    & php -l $routesPath
    if ($LASTEXITCODE -ne 0) { throw 'Validasi routes gagal. Mengembalikan backup.' }
    & php -l $newController
    if ($LASTEXITCODE -ne 0) { throw 'Validasi controller gagal. Mengembalikan backup.' }
} catch {
    Copy-Item -LiteralPath (Join-Path $backupDir 'web.php') -Destination $routesPath -Force
    Copy-Item -LiteralPath (Join-Path $backupDir 'news.blade.php') -Destination $newsPath -Force
    if (Test-Path $newController) { Remove-Item -LiteralPath $newController -Force }
    if (Test-Path $newView) { Remove-Item -LiteralPath $newView -Force }
    throw
}

Write-Host ''
Write-Host 'Fitur Edit Berita BERHASIL dipasang!' -ForegroundColor Green
Write-Host "Backup tersedia di: $backupDir" -ForegroundColor Cyan
Write-Host 'Silakan jalankan: php artisan optimize:clear'
Write-Host 'Buka: http://127.0.0.1:8000/admin/news'
