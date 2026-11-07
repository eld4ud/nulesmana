#Requires -Version 5.1
param(
    [string]$ProjectRoot = (Get-Location).Path,
    [string]$BackupDir = ''
)
$ErrorActionPreference = 'Stop'
$project = (Resolve-Path -LiteralPath $ProjectRoot).Path
if (-not (Test-Path -LiteralPath (Join-Path $project 'artisan'))) { throw 'Buka root Laravel.' }
if (-not $BackupDir) {
    $pointer = Join-Path $PSScriptRoot 'LAST_BACKUP_PATH.txt'
    if (-not (Test-Path -LiteralPath $pointer)) { throw 'Backup tidak ditemukan. Gunakan -BackupDir dengan lokasi backup dari installer.' }
    $BackupDir = (Get-Content -LiteralPath $pointer -Raw).Trim()
}
$backup = (Resolve-Path -LiteralPath $BackupDir).Path
$manifest = Get-Content -LiteralPath (Join-Path $backup 'manifest.json') -Raw | ConvertFrom-Json
$entries = @($manifest.files)

# Do not discard any edits made since installation.
foreach ($entry in $entries) {
    $rel = $entry.path.Replace('/', [IO.Path]::DirectorySeparatorChar)
    $dest = Join-Path $project $rel
    if (-not (Test-Path -LiteralPath $dest -PathType Leaf)) { throw "Patch file missing: $rel" }
    if ((Get-FileHash -LiteralPath $dest -Algorithm SHA256).Hash -ne $entry.patchedSha256) {
        throw "File $rel berubah setelah patch. Rollback dihentikan agar editmu tidak hilang."
    }
    if ($entry.originalExists -and -not (Test-Path -LiteralPath (Join-Path $backup $rel) -PathType Leaf)) {
        throw "Backup tidak lengkap: $rel"
    }
}
foreach ($entry in $entries) {
    $rel = $entry.path.Replace('/', [IO.Path]::DirectorySeparatorChar)
    $dest = Join-Path $project $rel
    if ($entry.originalExists) {
        Copy-Item -LiteralPath (Join-Path $backup $rel) -Destination $dest -Force
    } else {
        Remove-Item -LiteralPath $dest -Force
    }
}
Write-Host "ROLLBACK BERHASIL. $($entries.Count) file dipulihkan." -ForegroundColor Green
Write-Host "Jalankan: php artisan config:clear; php artisan view:clear" -ForegroundColor Cyan
