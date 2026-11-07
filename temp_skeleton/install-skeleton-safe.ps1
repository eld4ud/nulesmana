$ErrorActionPreference = 'Stop'
Set-StrictMode -Version Latest

$root = (Get-Location).Path
$artisan = Join-Path $root 'artisan'
$target = Join-Path $root 'resources\views\welcome.blade.php'

if (-not (Test-Path -LiteralPath $artisan)) {
    throw 'Jalankan script dari folder utama Laravel (harus ada file artisan).'
}
if (-not (Test-Path -LiteralPath $target)) {
    throw 'welcome.blade.php tidak ditemukan. Tidak ada file yang diubah.'
}

$source = [System.IO.File]::ReadAllText($target)
if ($source.Contains('NU_SAFE_SKELETON_BEGIN')) {
    Write-Host 'Patch sudah terpasang. Tidak ada perubahan kedua.' -ForegroundColor Yellow
    exit 0
}
if ($source -notmatch '<div\s+id=["'']nu-skeleton["'']' -or $source -notmatch 'nl-reveal-enabled') {
    throw 'Skeleton / reveal yang diharapkan tidak ditemukan. File mungkin berbeda dari repo. Tidak ada file diubah.'
}
$head = [regex]::Match($source, '<head(?:\s[^>]*)?>', 'IgnoreCase')
if (-not $head.Success) {
    throw 'Tag <head> tidak ditemukan. Tidak ada file diubah.'
}

# Paksa overlay skeleton tidak memblokir first render.
# Section reveal dan animasi interaktif lain dibiarkan apa adanya.
$patch = @'

    <!-- NU_SAFE_SKELETON_BEGIN -->
    <style id="nu-safe-skeleton-perf">
        #nu-skeleton { display: none !important; }
        html.nl-reveal-enabled [data-hero-enter] {
            opacity: 1 !important;
            visibility: visible !important;
            filter: none !important;
            transform: none !important;
        }
    </style>
    <!-- NU_SAFE_SKELETON_END -->
'@

$updated = $source.Insert($head.Index + $head.Length, $patch)
if (($updated -notmatch 'NU_SAFE_SKELETON_BEGIN') -or ($updated.Length -le $source.Length)) {
    throw 'Validasi perubahan gagal. Tidak ada file diubah.'
}

$backupFolder = Join-Path $root ('backup_skeleton_perf_' + (Get-Date -Format 'yyyyMMdd_HHmmss'))
New-Item -ItemType Directory -Path $backupFolder -Force | Out-Null
Copy-Item -LiteralPath $target -Destination (Join-Path $backupFolder 'welcome.blade.php') -ErrorAction Stop

$temp = "$target.nu-perf.tmp"
try {
    [System.IO.File]::WriteAllText($temp, $updated, [System.Text.UTF8Encoding]::new($false))
    Copy-Item -LiteralPath $temp -Destination $target -Force -ErrorAction Stop
} finally {
    if (Test-Path -LiteralPath $temp) { Remove-Item -LiteralPath $temp -Force }
}

Write-Host 'Sukses: skeleton tidak lagi menutup landing page saat load.' -ForegroundColor Green
Write-Host 'Animasi TechText, galeri dan section lain tidak diubah.'
Write-Host "Backup: $backupFolder"
Write-Host 'Untuk uji ulang: php artisan view:clear, lalu Ctrl+Shift+R dan Lighthouse Mobile.'
