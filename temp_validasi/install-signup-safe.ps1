# Nulesmana - Pasang validasi visual pendaftaran anggota.
# Hanya menyentuh pages/signup.blade.php dan menambah dua aset baru.
$ErrorActionPreference = 'Stop'
$root = (Get-Location).Path
if (!(Test-Path (Join-Path $root 'artisan'))) { throw 'Buka terminal di root Laravel (folder berisi artisan).' }
$view = Join-Path $root 'resources\views\pages\signup.blade.php'
if (!(Test-Path $view)) { throw 'File pages/signup.blade.php tidak ditemukan. Belum ada perubahan.' }

$source = [System.IO.File]::ReadAllText($view)
if ($source.Contains('data-nl-validation-kit')) {
    Write-Host 'Fitur sudah dipasang. Tidak ada file diubah.' -ForegroundColor Yellow
    exit 0
}
$checks = @("@section('content')", '@endsection', 'id="nl-signup-form"', 'id="nl-next"', 'nl-signup-step', 'firstInvalidField(number)', 'invalid.reportValidity()')
foreach ($check in $checks) {
    if (!$source.Contains($check)) { throw "Validasi gagal: tidak ada [$check]. File tidak diubah. Gunakan versi Blade lokal untuk penyesuaian." }
}
if (([regex]::Matches($source, [regex]::Escape("@section('content')"))).Count -ne 1 -or
    ([regex]::Matches($source, [regex]::Escape('@endsection'))).Count -ne 1) {
    throw 'Struktur section tidak sesuai. File tidak diubah.'
}

$head = @'
@section('content')
<link data-nl-validation-kit rel="stylesheet" href="{{ asset('css/nulesmana-signup-errors.css') }}">
'@
$footer = @'
<script data-nl-validation-kit>window.nulesmanaSignupServerErrors = @json($errors->messages());</script>
<script defer src="{{ asset('js/nulesmana-signup-errors.js') }}"></script>
@endsection
'@
$updated = $source.Replace("@section('content')", $head.TrimEnd())
$updated = $updated.Replace('@endsection', $footer.TrimEnd())

$assetCss = Join-Path $root 'public\css\nulesmana-signup-errors.css'
$assetJs = Join-Path $root 'public\js\nulesmana-signup-errors.js'
$srcCss = Join-Path $PSScriptRoot 'css\nulesmana-signup-errors.css'
$srcJs = Join-Path $PSScriptRoot 'js\nulesmana-signup-errors.js'
foreach ($path in @($srcCss,$srcJs)) {
    if (!(Test-Path $path)) { throw "Aset paket tidak ada: $path. File tidak diubah." }
}
$backup = Join-Path $root ('storage\backups\signup-ui-' + (Get-Date -Format 'yyyyMMdd-HHmmss'))
New-Item -Path $backup -ItemType Directory -Force | Out-Null
Copy-Item -LiteralPath $view -Destination (Join-Path $backup 'signup.blade.php')
$cssExisted = Test-Path $assetCss
$jsExisted = Test-Path $assetJs
if ($cssExisted) { Copy-Item $assetCss (Join-Path $backup 'previous.css') }
if ($jsExisted) { Copy-Item $assetJs (Join-Path $backup 'previous.js') }
@{ cssExisted = $cssExisted; jsExisted = $jsExisted } |
    ConvertTo-Json | Set-Content -LiteralPath (Join-Path $backup 'manifest.json') -Encoding UTF8

New-Item -Path (Split-Path $assetCss) -ItemType Directory -Force | Out-Null
New-Item -Path (Split-Path $assetJs) -ItemType Directory -Force | Out-Null
Copy-Item $srcCss $assetCss -Force
Copy-Item $srcJs $assetJs -Force
[System.IO.File]::WriteAllText($view, $updated, [System.Text.UTF8Encoding]::new($false))
Write-Host "Validasi merah + getar berhasil dipasang. Backup: $backup" -ForegroundColor Green
Write-Host 'Jalankan: php artisan view:clear'
