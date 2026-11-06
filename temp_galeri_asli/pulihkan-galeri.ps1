$ErrorActionPreference = 'Stop'
try {
    $root = (Get-Location).Path
    $blade = Join-Path $root 'resources\views\welcome.blade.php'
    $source = Join-Path $PSScriptRoot 'galeri-original.html'
    if (!(Test-Path (Join-Path $root 'artisan'))) { throw 'Jalankan dari folder utama Laravel (harus ada artisan).' }
    if (!(Test-Path $blade)) { throw 'resources/views/welcome.blade.php tidak ditemukan.' }
    if (!(Test-Path $source)) { throw 'galeri-original.html tidak ditemukan di paket.' }

    $original = [System.IO.File]::ReadAllText($blade)
    $sectionMatches = [regex]::Matches($original, '<section\b[^>]*\bid\s*=\s*["'']galeri["''][^>]*>', 'IgnoreCase')
    $marker = '<!-- ULASAN DAN ASPIRASI WARGA -->'
    $originalTail = [System.IO.File]::ReadAllText($source).Trim()
    if ($sectionMatches.Count -ne 1) { throw 'Bagian <section id="galeri"> tidak ditemukan secara unik. File tidak diubah.' }
    $sectionStart = $sectionMatches[0].Index
    $sectionEnd = $original.IndexOf('</section>', $sectionStart, [System.StringComparison]::OrdinalIgnoreCase)
    if ($sectionEnd -lt 0) { throw 'Penutup </section> galeri tidak ditemukan. File tidak diubah.' }
    $sectionEnd += '</section>'.Length
    $after = $original.IndexOf($marker, $sectionEnd, [System.StringComparison]::OrdinalIgnoreCase)
    if ($after -lt 0) { throw 'Penanda bagian Ulasan tidak ditemukan. File tidak diubah.' }

    $galleryMarkup = $original.Substring($sectionStart, $sectionEnd - $sectionStart)
    if ($galleryMarkup -notmatch 'data-coverflow' -or
        $galleryMarkup -notmatch 'coverflow-slide' -or
        $galleryMarkup -notmatch 'coverflow-next' -or
        $galleryMarkup -notmatch 'coverflow-prev') {
        throw 'Struktur galeri tidak cocok. File tidak diubah.'
    }
    $oldTail = $original.Substring($sectionEnd, $after - $sectionEnd)
    if ($oldTail -notmatch 'coverflow-slide|coverflow-stage|coverflow-current') {
        throw 'Blok CSS/JS galeri yang rusak tidak terdeteksi. File tidak diubah.'
    }
    # Jangan menimpa komponen lain jika ternyata terselip di blok yang akan diganti.
    if ($oldTail -match '<section\b|@foreach\b|@include\b|@php\b') {
        throw 'Ada komponen lain di antara galeri dan ulasan. File tidak diubah.'
    }
    if ($originalTail -notmatch '<style>' -or $originalTail -notmatch '</script>') {
        throw 'Paket pemulihan tidak lengkap. File tidak diubah.'
    }

    # Pulihkan CSS/JS galeri asli. Markup dan WebP tetap persis seperti saat ini.
    $newContent = $original.Substring(0, $sectionEnd) + "`r`n" + $originalTail + "`r`n" + $original.Substring($after)
    # Hapus pemanggilan autoplay tambahan yang dipasang oleh paket sebelumnya.
    $autoplayPattern = '(?is)\s*<script\b(?=[^>]*\bdata-nulesmana-coverflow-autoplay\b)[^>]*>\s*</script>'
    $newContent = [regex]::Replace($newContent, $autoplayPattern, '')
    if ($newContent -eq $original) { throw 'Tidak ada perubahan yang diperlukan.' }

    $backupDir = Join-Path $root ('backup_galeri_asli\' + (Get-Date -Format 'yyyyMMdd_HHmmss'))
    [void](New-Item -ItemType Directory -Path $backupDir -Force)
    Copy-Item -LiteralPath $blade -Destination (Join-Path $backupDir 'welcome.blade.php')
    $bytes = [System.IO.File]::ReadAllBytes($blade)
    $hasBOM = $bytes.Length -ge 3 -and $bytes[0] -eq 239 -and $bytes[1] -eq 187 -and $bytes[2] -eq 191
    $encoding = New-Object System.Text.UTF8Encoding($hasBOM)
    [System.IO.File]::WriteAllText($blade, $newContent, $encoding)
    Write-Host 'BERHASIL: CSS/JS coverflow awal pulih; scroll mouse, drag, sentuh, dan tombol aktif.' -ForegroundColor Green
    Write-Host 'Markup, WebP, dan bagian website lain tidak diganti.' -ForegroundColor Green
    Write-Host "Backup file sebelumnya: $backupDir" -ForegroundColor Cyan
    if (Get-Command php -ErrorAction SilentlyContinue) {
        & php artisan view:clear
    } else {
        Write-Host 'PHP tidak ditemukan di PATH. Bersihkan cache view secara manual.' -ForegroundColor Yellow
    }
    exit 0
} catch {
    Write-Host "PEMULIHAN DIHENTIKAN: $($_.Exception.Message)" -ForegroundColor Red
    exit 1
}
