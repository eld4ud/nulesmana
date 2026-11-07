$ErrorActionPreference = 'Stop'
$root = (Get-Location).Path
if (!(Test-Path -LiteralPath (Join-Path $root 'artisan'))) { throw 'Buka folder utama Laravel dulu.' }
$view = Join-Path $root 'resources\views\welcome.blade.php'
if (!(Test-Path -LiteralPath $view)) { throw 'welcome.blade.php tidak ditemukan.' }
$text = [System.IO.File]::ReadAllText($view)
function Status($name,$cond) { Write-Host ('{0}: {1}' -f $name, $(if ($cond) {'YA'} else {'TIDAK'})) }
Status 'Skeleton overlay ada' ($text -match '<div\s+id=["'']nu-skeleton["'']')
Status 'Patch skeleton aman aktif' ($text -match 'NU_SAFE_SKELETON_BEGIN')
Status 'Tailwind Play CDN dipanggil' ($text -match 'cdn\.tailwindcss\.com')
Status 'Phosphor unpkg dipanggil' ($text -match 'unpkg\.com/@phosphor-icons')
Status 'Vite CSS utama dipanggil' ($text -match '@vite\(')
Status 'Galeri coverflow tersedia' ($text -match 'data-coverflow')
Status 'TechText ada' ($text -match 'nulesmana-techtext')
$fonts = ([regex]::Matches($text, 'fonts\.googleapis\.com/css2\?')).Count
Write-Host "Jumlah pemanggilan stylesheet Google Fonts di landing page: $fonts"
Write-Host 'Pemeriksaan selesai (read-only).'
