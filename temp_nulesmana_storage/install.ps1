#Requires -Version 5.1
param([string]$ProjectRoot = (Get-Location).Path)
$ErrorActionPreference = 'Stop'
$project = (Resolve-Path -LiteralPath $ProjectRoot).Path
if (-not (Test-Path -LiteralPath (Join-Path $project 'artisan'))) {
    throw "Folder ini bukan root proyek Laravel. Pindah ke C:\Users\user\MCCrud, lalu ulangi."
}
$manifest = Get-Content -LiteralPath (Join-Path $PSScriptRoot 'manifest.json') -Raw | ConvertFrom-Json
$entries = @($manifest.files)
$payload = Join-Path $PSScriptRoot 'payload'

# Fail closed before touching anything. No overwrites on unexpected local changes.
foreach ($entry in $entries) {
    $rel = $entry.path.Replace('/', [IO.Path]::DirectorySeparatorChar)
    $dest = Join-Path $project $rel
    $source = Join-Path $payload $rel
    if (-not (Test-Path -LiteralPath $source -PathType Leaf)) { throw "Paket tidak lengkap: $rel" }
    $newHash = (Get-FileHash -LiteralPath $source -Algorithm SHA256).Hash
    if ($newHash -ne $entry.patchedSha256) { throw "Isi paket berubah: $rel" }
    if ($entry.originalExists) {
        if (-not (Test-Path -LiteralPath $dest -PathType Leaf)) { throw "File target hilang: $rel" }
        $current = (Get-FileHash -LiteralPath $dest -Algorithm SHA256).Hash
        if ($current -ne $entry.originalSha256) {
            throw "File lokal berbeda dari ZIP yang diaudit: $rel`nPatch dihentikan. Jangan timpa file ini secara paksa."
        }
    } elseif (Test-Path -LiteralPath $dest) {
        throw "File baru sudah ada, patch dihentikan: $rel"
    }
}

$base = Join-Path $env:LOCALAPPDATA 'NulesmanaStoragePatchBackups'
$stamp = Get-Date -Format 'yyyyMMdd_HHmmss'
$backup = Join-Path $base ($stamp + '_' + [guid]::NewGuid().ToString('N').Substring(0,8))
New-Item -ItemType Directory -Path $backup -Force | Out-Null
Copy-Item -LiteralPath (Join-Path $PSScriptRoot 'manifest.json') -Destination (Join-Path $backup 'manifest.json') -Force
foreach ($entry in $entries) {
    if (-not $entry.originalExists) { continue }
    $rel = $entry.path.Replace('/', [IO.Path]::DirectorySeparatorChar)
    $dest = Join-Path $backup $rel
    New-Item -ItemType Directory -Path (Split-Path $dest -Parent) -Force | Out-Null
    Copy-Item -LiteralPath (Join-Path $project $rel) -Destination $dest -Force
}

$applied = @()
try {
    foreach ($entry in $entries) {
        $rel = $entry.path.Replace('/', [IO.Path]::DirectorySeparatorChar)
        $dest = Join-Path $project $rel
        New-Item -ItemType Directory -Path (Split-Path $dest -Parent) -Force | Out-Null
        Copy-Item -LiteralPath (Join-Path $payload $rel) -Destination $dest -Force
        $applied += $entry
        $actual = (Get-FileHash -LiteralPath $dest -Algorithm SHA256).Hash
        if ($actual -ne $entry.patchedSha256) { throw "Verifikasi gagal: $rel" }
    }
} catch {
    $reason = $_.Exception.Message
    foreach ($entry in $applied) {
        $rel = $entry.path.Replace('/', [IO.Path]::DirectorySeparatorChar)
        $dest = Join-Path $project $rel
        if ($entry.originalExists) {
            Copy-Item -LiteralPath (Join-Path $backup $rel) -Destination $dest -Force
        } elseif (Test-Path -LiteralPath $dest) {
            Remove-Item -LiteralPath $dest -Force
        }
    }
    throw "Gagal pasang, file yang sempat dipasang sudah dikembalikan: $reason"
}
Set-Content -LiteralPath (Join-Path $PSScriptRoot 'LAST_BACKUP_PATH.txt') -Value $backup -Encoding UTF8
Write-Host "PATCH DIPASANG: $($entries.Count) file. Backup: $backup" -ForegroundColor Green
Write-Host "Mode Laragon tetap LOCAL sampai NULESMANA_STORAGE_MODE=supabase diatur." -ForegroundColor Cyan
Write-Host "Lanjut: php artisan config:clear; php artisan view:clear" -ForegroundColor Cyan
