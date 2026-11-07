# Nulesmana safe mobile patch. Only edits welcome.blade.php and a new CSS asset.
$ErrorActionPreference = 'Stop'
$backupForRecovery = $null
$changedFiles = $false
try {
    $root = (Get-Location).Path
    if (!(Test-Path (Join-Path $root 'artisan'))) { throw 'Jalankan di ROOT Laravel yang berisi artisan.' }
    $blade = Join-Path $root 'resources\views\welcome.blade.php'
    $dest = Join-Path $root 'public\css\nulesmana-mobile-stable.css'
    $asset = Join-Path $PSScriptRoot 'assets\nulesmana-mobile-stable.css'
    $gallerySource = Join-Path $PSScriptRoot 'assets\galeri-original.html'
    if (!(Test-Path $blade) -or !(Test-Path $asset) -or !(Test-Path $gallerySource)) { throw 'File projek/paket tidak lengkap.' }
    $original = [System.IO.File]::ReadAllText($blade, [System.Text.Encoding]::UTF8)
    $updated = $original
    $stylesTag = '<link data-nu-mobile-stable rel="stylesheet" href="{{ asset(''css/nulesmana-mobile-stable.css'') }}?v=1">'
    if ($updated -match 'data-nu-mobile-stable') { throw 'Patch mobile sudah terpasang, tidak perlu dipasang dua kali.' }
    if (([regex]::Matches($updated, '(?i)</head>')).Count -ne 1) { throw 'Tag </head> tidak ditemukan secara unik; tidak ada perubahan.' }
    if (([regex]::Matches($updated, '(?i)<section\b[^>]*\bid=["'']galeri["'']')).Count -ne 1) { throw 'Galeri belum ditemukan secara unik; tidak ada perubahan.' }
    if ($updated -notmatch '(?i)data-coverflow' -or $updated -notmatch '(?i)coverflow-slide') { throw 'Galeri coverflow tidak ditemukan; tidak ada perubahan.' }

    # Only recover gallery when its style/JS looks damaged. Preserve all image markup, including WebP.
    $galleryRepaired = $false
    $sectionRx = [regex]::Match($updated, '(?i)<section\b[^>]*\bid=["'']galeri["''][^>]*>')
    $sectionEnd = $updated.IndexOf('</section>', $sectionRx.Index, [System.StringComparison]::OrdinalIgnoreCase)
    if ($sectionEnd -ge 0) {
        $sectionEnd += '</section>'.Length
        $marker = '<!-- ULASAN DAN ASPIRASI WARGA -->'
        $markerAt = $updated.IndexOf($marker, $sectionEnd, [System.StringComparison]::OrdinalIgnoreCase)
        if ($markerAt -ge 0) {
            $tail = $updated.Substring($sectionEnd, $markerAt - $sectionEnd)
            $hasGalleryCode = $tail -match 'coverflow-slide|coverflow-stage|coverflow-current'
            $brokenMarkup = $hasGalleryCode -and ($tail -notmatch '(?i)<style\b' -or $tail -notmatch '(?i)</style>' -or $tail -notmatch '(?i)<script\b' -or $tail -notmatch '(?i)</script>')
            if ($brokenMarkup -and $tail -notmatch '(?i)<section\b|@foreach\b|@include\b|@php\b') {
                $galleryCode = [System.IO.File]::ReadAllText($gallerySource, [System.Text.Encoding]::UTF8).Trim()
                $updated = $updated.Substring(0, $sectionEnd) + "`r`n" + $galleryCode + "`r`n" + $updated.Substring($markerAt)
                $galleryRepaired = $true
            } elseif ($brokenMarkup) {
                Write-Warning 'Galeri terlihat rusak, tetapi ada komponen lain di sekitarnya. Galeri tidak disentuh.'
            }
        } else { Write-Warning 'Penanda bagian berikutnya tidak ada; galeri tidak diubah.' }
    }
    # Remove only the autoplay tag from an earlier package (not the original coverflow logic).
    $updated = [regex]::Replace($updated, '(?is)\s*<script\b(?=[^>]*\bdata-nulesmana-coverflow-autoplay\b)[^>]*>\s*</script>', '')
    $updated = [regex]::new('(?i)</head>').Replace($updated, ("    $stylesTag`r`n</head>"), 1)
    if ($updated -notmatch 'data-nu-mobile-stable') { throw 'Validasi patch gagal, tidak ada file yang diubah.' }

    $stamp = Get-Date -Format 'yyyyMMdd_HHmmss'
    $folder = Join-Path $root ("backup_nulesmana_stabilizer\$stamp")
    New-Item -ItemType Directory -Path $folder -Force | Out-Null
    Copy-Item -LiteralPath $blade -Destination (Join-Path $folder 'welcome.blade.php')
    if (Test-Path $dest) { Copy-Item -LiteralPath $dest -Destination (Join-Path $folder 'nulesmana-mobile-stable.css') }
    else { Set-Content -LiteralPath (Join-Path $folder 'css-was-absent.txt') -Value 'yes' }
    $bytes = [System.IO.File]::ReadAllBytes($blade)
    $bom = $bytes.Length -ge 3 -and $bytes[0] -eq 239 -and $bytes[1] -eq 187 -and $bytes[2] -eq 191
    $enc = New-Object System.Text.UTF8Encoding($bom)
    $backupForRecovery = $folder
    $changedFiles = $true
    [System.IO.File]::WriteAllText($blade, $updated, $enc)
    New-Item -ItemType Directory -Path (Split-Path $dest) -Force | Out-Null
    Copy-Item -LiteralPath $asset -Destination $dest -Force
    Set-Content -LiteralPath (Join-Path $root 'backup_nulesmana_stabilizer\LATEST.txt') -Value $folder
    if (Get-Command php -ErrorAction SilentlyContinue) { & php artisan view:clear }
    Write-Host 'BERHASIL: patch CSS mobile terpasang.' -ForegroundColor Green
    Write-Host "CSS/JS galeri dipulihkan: $galleryRepaired"
    Write-Host "Backup untuk rollback: $folder"
    Write-Host 'Dashboard, database, route, TechText JS, dan Tailwind CDN tidak diganti.'
    exit 0
} catch {
    if ($changedFiles -and $backupForRecovery -and (Test-Path (Join-Path $backupForRecovery 'welcome.blade.php'))) {
        try {
            Copy-Item -LiteralPath (Join-Path $backupForRecovery 'welcome.blade.php') -Destination $blade -Force
            if (Test-Path (Join-Path $backupForRecovery 'css-was-absent.txt')) {
                if (Test-Path $dest) { Remove-Item -LiteralPath $dest -Force }
            } elseif (Test-Path (Join-Path $backupForRecovery 'nulesmana-mobile-stable.css')) {
                Copy-Item -LiteralPath (Join-Path $backupForRecovery 'nulesmana-mobile-stable.css') -Destination $dest -Force
            }
            Write-Host 'Perubahan parsial dibatalkan dari backup.' -ForegroundColor Yellow
        } catch { Write-Warning 'Rollback otomatis gagal; gunakan backup secara manual.' }
    }
    Write-Host "GAGAL: $($_.Exception.Message)" -ForegroundColor Red
    exit 1
}
