# Nulesmana V6: hero responsive + TechText ringan + font publik.
# Jalankan dari ROOT Laravel (ada artisan). Mengubah: welcome.blade.php dan 3 aset publik.
$ErrorActionPreference = 'Stop'
$root = (Get-Location).Path
$welcome = Join-Path $root 'resources\views\welcome.blade.php'
$utf8 = [System.Text.UTF8Encoding]::new($false)
if (!(Test-Path -LiteralPath (Join-Path $root 'artisan'))) { throw 'Buka folder utama proyek Laravel dulu (harus ada artisan).' }
if (!(Test-Path -LiteralPath $welcome)) { throw 'resources/views/welcome.blade.php tidak ditemukan.' }

$assets = @{
    'public\js\nulesmana-techtext.js' = (Join-Path $PSScriptRoot 'assets\nulesmana-techtext.js')
    'public\css\nulesmana-techtext.css' = (Join-Path $PSScriptRoot 'assets\nulesmana-techtext.css')
    'public\css\nulesmana-public-type.css' = (Join-Path $PSScriptRoot 'assets\nulesmana-public-type.css')
}
foreach ($file in $assets.Values) {
    if (!(Test-Path -LiteralPath $file)) { throw "File paket hilang: $file" }
}
$before = [System.IO.File]::ReadAllText($welcome, [System.Text.Encoding]::UTF8)
if ($before -notmatch '(?i)</head>' -or $before -notmatch '(?i)</body>') { throw 'Head/body tidak ditemukan: batal.' }

# Ganti hanya H1 pada hero. Kompatibel dengan hero awal repo maupun TechText V2/V4/V5.
$newH1 = @'
<h1 class="nu-tech-hero-title" aria-label="Portal Resmi NU Lesmana.">
    <span class="nu-tech-line nu-tech-line--sans" data-nu-tech-text="Portal Resmi"><span class="nu-tech-fallback" aria-hidden="true">Portal Resmi</span></span>
    <span class="nu-tech-line nu-tech-line--serif" data-nu-tech-text="NU Lesmana."><span class="nu-tech-fallback" aria-hidden="true">NU Lesmana.</span></span>
</h1>
'@
$newHeroRx = [regex]::new('(?is)<h1\b(?=[^>]*\bnu-tech-hero-title\b)[^>]*>.*?</h1>')
$oldHeroRx = [regex]::new('(?is)<h1\b(?=[^>]*\bfont-display\b)[^>]*>\s*PORTAL\s+RESMI\s*<br\s*/?>\s*<span\b[^>]*>\s*LESMANA\.?\s*</span>\s*</h1>')
if ($newHeroRx.IsMatch($before)) { $after = $newHeroRx.Replace($before, $newH1, 1) }
elseif ($oldHeroRx.IsMatch($before)) { $after = $oldHeroRx.Replace($before, $newH1, 1) }
else { throw 'Hero H1 tidak cocok dengan versi Nulesmana yang diketahui. Tidak ada file diubah.' }

# Tambahkan ID hanya pada main pertama yang menampung hero, bukan pada halaman lain.
if ($after -notmatch 'id="nu-home-hero"') {
    $mainRx = [regex]::new('(?is)<main\b(?=[^>]*\bclass=")[^>]*>')
    if (!$mainRx.IsMatch($after)) { throw 'Main hero tidak ditemukan. Tidak ada file diubah.' }
    $main = $mainRx.Match($after)
    $newMain = $main.Value.Replace('<main', '<main id="nu-home-hero"')
    $after = $after.Substring(0, $main.Index) + $newMain + $after.Substring($main.Index + $main.Length)
}
if ($after -notmatch 'nu-public-v6') {
    $bodyRx = [regex]::new('(?i)(<body\b[^>]*\bclass=")')
    if (!$bodyRx.IsMatch($after)) { throw 'Body class tidak ditemukan. Tidak ada file diubah.' }
    $after = $bodyRx.Replace($after, '${1}nu-public-v6 ', 1)
}
# Tambahkan selector rapi pada elemen yang sudah ada tanpa mengubah link/route/teks.
if ($after -notmatch 'nu-v6-hero-copy') {
    $copyRx = [regex]::new('(?i)(<div\b(?=[^>]*\bdata-hero-enter\b)[^>]*\bclass=")')
    if ($copyRx.IsMatch($after)) { $after = $copyRx.Replace($after, '${1}nu-v6-hero-copy ', 1) }
}
if ($after -notmatch 'nu-v6-greeting') {
    $greetRx = [regex]::new('(?i)(<div\s+class=")(?=mb-6\s+text-center\s+lg:text-left")')
    if ($greetRx.IsMatch($after)) { $after = $greetRx.Replace($after, '${1}nu-v6-greeting ', 1) }
}
if ($after -notmatch 'nu-v6-hero-actions') {
    $buttonsRx = [regex]::new('(?i)(<div\s+class=")(?=flex\s+w-full\s+flex-wrap\s+items-center\s+justify-center\s+gap-3\.5)')
    if ($buttonsRx.IsMatch($after)) { $after = $buttonsRx.Replace($after, '${1}nu-v6-hero-actions ', 1) }
}
if ($after -notmatch 'nu-v6-description') {
    $descRx = [regex]::new('(?is)<p\b[^>]*>\s*Pusat informasi kegiatan majelis,')
    $match = $descRx.Match($after)
    if (!$match.Success) { throw 'Deskripsi hero tidak ditemukan. Tidak ada file diubah.' }
    $opening = [regex]::Match($match.Value, '(?is)^<p\b[^>]*>').Value
    if ($opening -match '(?i)\bclass\s*=\s*"') {
        $newOpen = ([regex]::new('(?i)(\bclass\s*=\s*")')).Replace($opening, '${1}nu-v6-description ', 1)
    } else { $newOpen = $opening.Insert(2, ' class="nu-v6-description"') }
    $after = $after.Substring(0, $match.Index) + $newOpen + $after.Substring($match.Index + $opening.Length)
}

# Singkirkan duplikasi paket lama pada welcome saja, tidak menyentuh layout admin.
$after = [regex]::Replace($after, '(?im)^\s*<link\b(?=[^\r\n>]*fonts\.googleapis\.com/css2\?)[^\r\n>]*>\s*(?:\r?\n)?', '')
$after = [regex]::Replace($after, '(?im)^\s*<link\b(?=[^\r\n>]*rel=["'']preconnect["''])(?=[^\r\n>]*fonts\.(?:googleapis|gstatic)\.com)[^\r\n>]*>\s*(?:\r?\n)?', '')
$after = [regex]::Replace($after, '(?im)^\s*<link\b(?=[^\r\n>]*nulesmana-(?:techtext|public-type)\.css)[^\r\n>]*>\s*(?:\r?\n)?', '')
$after = [regex]::Replace($after, '(?im)^\s*<script\b(?=[^\r\n>]*nulesmana-techtext\.js)[^\r\n>]*>\s*</script>\s*(?:\r?\n)?', '')

$styles = @'
    <!-- Nulesmana V6: satu permintaan font publik + tipografi responsif -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link data-nu-v6-fonts rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Amiri:wght@400;700&amp;family=Bebas+Neue&amp;family=Instrument+Serif:ital@1&amp;family=Manrope:wght@500;600;700&amp;display=swap">
    <link rel="stylesheet" href="{{ asset('css/nulesmana-public-type.css') }}?v=6">
    <link rel="stylesheet" href="{{ asset('css/nulesmana-techtext.css') }}?v=6">
'@
$script = @'
    <script defer src="{{ asset('js/nulesmana-techtext.js') }}?v=6"></script>
'@
$after = ([regex]::new('(?i)</head>')).Replace($after, ($styles + "`r`n</head>"), 1)
$after = ([regex]::new('(?i)</body>')).Replace($after, ($script + "`r`n</body>"), 1)

# Preflight: jangan overwrite bila data penting hilang atau terjadi duplikasi.
if (([regex]::Matches($after, 'data-nu-tech-text="Portal Resmi"')).Count -ne 1 -or
    ([regex]::Matches($after, 'nulesmana-techtext\.js')).Count -ne 1 -or
    ([regex]::Matches($after, 'nulesmana-techtext\.css')).Count -ne 1 -or
    ([regex]::Matches($after, 'nu-home-hero')).Count -lt 1 -or
    $after -notmatch 'Pusat informasi kegiatan majelis' -or
    $after -notmatch 'nu-hero-image') {
    throw 'Validasi gagal; tidak ada file diubah. Kirim potongan hero terbaru.'
}

$stamp = Get-Date -Format 'yyyyMMdd_HHmmss'
$backup = Join-Path $root "backup_nulesmana_v6_$stamp"
New-Item -ItemType Directory -Path $backup -Force | Out-Null
$absent = New-Object System.Collections.Generic.List[string]
$paths = @('resources\views\welcome.blade.php') + @($assets.Keys)
foreach ($r in $paths) {
    $source = Join-Path $root $r
    if (Test-Path -LiteralPath $source) {
        $destination = Join-Path $backup $r
        New-Item -ItemType Directory -Force -Path (Split-Path -Parent $destination) | Out-Null
        Copy-Item -LiteralPath $source -Destination $destination -Force
    } else { $absent.Add($r) }
}
[System.IO.File]::WriteAllLines((Join-Path $backup 'previously-absent.txt'), [string[]]$absent, $utf8)

[System.IO.File]::WriteAllText($welcome, $after, $utf8)
foreach ($r in $assets.Keys) {
    $dest = Join-Path $root $r
    New-Item -ItemType Directory -Force -Path (Split-Path -Parent $dest) | Out-Null
    Copy-Item -LiteralPath $assets[$r] -Destination $dest -Force
}
php artisan optimize:clear
if ($LASTEXITCODE -ne 0) { Write-Warning 'Cache Laravel belum berhasil dibersihkan, tapi file sudah dipasang. Jalankan php artisan optimize:clear.' }
Write-Host ''
Write-Host 'NULESMANA V6 TERPASANG' -ForegroundColor Green
Write-Host "Backup: $backup"
Write-Host 'Diubah: welcome.blade.php + 3 file CSS/JS publik. Admin, database, gambar, dan route tetap.'
Write-Host 'Buka http://127.0.0.1:8000 dan tekan Ctrl+Shift+R.'
