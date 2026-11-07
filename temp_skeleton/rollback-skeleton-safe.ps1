$ErrorActionPreference = 'Stop'
Set-StrictMode -Version Latest

$root = (Get-Location).Path
if (-not (Test-Path -LiteralPath (Join-Path $root 'artisan'))) {
    throw 'Jalankan script dari folder utama Laravel.'
}
$target = Join-Path $root 'resources\views\welcome.blade.php'
if (-not (Test-Path -LiteralPath $target)) { throw 'welcome.blade.php tidak ditemukan.' }
$text = [System.IO.File]::ReadAllText($target)
$pattern = '(?ms)\r?\n[ \t]*<!-- NU_SAFE_SKELETON_BEGIN -->.*?<!-- NU_SAFE_SKELETON_END -->'
$matches = [regex]::Matches($text, $pattern)
if ($matches.Count -eq 0) { Write-Host 'Patch tidak ditemukan; tidak ada perubahan.'; exit 0 }
if ($matches.Count -ne 1) { throw 'Ditemukan lebih dari 1 patch. Tidak ada file diubah.' }
$updated = ([regex]::new($pattern)).Replace($text, '', 1)
$backup = "$target.rollback-$(Get-Date -Format 'yyyyMMdd_HHmmss').bak"
Copy-Item -LiteralPath $target -Destination $backup
[System.IO.File]::WriteAllText($target, $updated, [System.Text.UTF8Encoding]::new($false))
Write-Host 'Rollback selesai. CSS patch skeleton dilepas.' -ForegroundColor Green
Write-Host "Backup sebelum rollback: $backup"
