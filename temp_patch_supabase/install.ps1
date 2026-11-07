param(
    [string]$ProjectRoot = (Get-Location).Path
)
$ErrorActionPreference = 'Stop'
$root = (Resolve-Path $ProjectRoot).Path
$here = Split-Path -Parent $MyInvocation.MyCommand.Path
$mig = Join-Path $root 'database\migrations'
if (-not (Test-Path (Join-Path $root 'artisan'))) { throw 'Folder ini bukan root Laravel. Jalankan dari folder MCCrud.' }
$files = @(
  @{ Name = '2026_09_06_122807_create_events_table.php'; Sha256 = '40E0A2F88A75A356FAA144BA1BEFDF44BA10C67104B447206FF7A24DDBA6D829' },
  @{ Name = '2026_10_14_000001_add_member_fields_to_users_table.php'; Sha256 = '127CE4A80B85930E2A306A55152C8031EBCB4D2537F9C780D21AB4916B9BF99C' }
)
# Periksa semua target sebelum mengubah file apa pun.
foreach ($f in $files) {
    $target = Join-Path $mig $f.Name
    if (-not (Test-Path $target)) { throw "File migrasi tidak ditemukan: $target" }
    $hash = (Get-FileHash -Algorithm SHA256 $target).Hash
    if ($hash -ne $f.Sha256) { throw "Isi $($f.Name) berbeda dari ZIP yang diaudit. Tidak diubah demi keamanan." }
}
$backup = Join-Path $root ('backup_migrasi_supabase_' + (Get-Date -Format 'yyyyMMdd_HHmmss'))
New-Item -ItemType Directory -Path $backup | Out-Null
foreach ($f in $files) {
    $target = Join-Path $mig $f.Name
    Copy-Item -LiteralPath $target -Destination (Join-Path $backup $f.Name)
}
try {
    foreach ($f in $files) {
        $source = Join-Path (Join-Path $here 'database\migrations') $f.Name
        Copy-Item -LiteralPath $source -Destination (Join-Path $mig $f.Name) -Force
        & php -l (Join-Path $mig $f.Name)
        if ($LASTEXITCODE -ne 0) { throw "PHP syntax check gagal: $($f.Name)" }
    }
} catch {
    foreach ($f in $files) { Copy-Item (Join-Path $backup $f.Name) (Join-Path $mig $f.Name) -Force }
    throw
}
Write-Host "PATCH SUKSES. Backup: $backup" -ForegroundColor Green
Write-Host 'Belum ada migrasi database yang dijalankan.'
