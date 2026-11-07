# Read-only smoke test of public pages and authentication redirects.
$ErrorActionPreference = 'Continue'
$urls = @('/', '/news', '/login', '/login-anggota', '/daftar-anggota', '/admin/dashboard', '/admin/news')
Write-Host 'Pastikan php artisan serve aktif di http://127.0.0.1:8000' -ForegroundColor Cyan
foreach ($route in $urls) {
    $url = 'http://127.0.0.1:8000' + $route
    try {
        $response = Invoke-WebRequest -Uri $url -MaximumRedirection 0 -UseBasicParsing -ErrorAction Stop
        $code = [int]$response.StatusCode
    } catch {
        if ($_.Exception.Response -and $_.Exception.Response.StatusCode) {
            $code = [int]$_.Exception.Response.StatusCode
        } else { $code = 'ERR' }
    }
    Write-Host ("{0,-24} {1}" -f $route, $code)
}
Write-Host '200 = berhasil; 302 = redirect (normal untuk admin); 403 = ditolak; 404/500/ERR = perlu dicek.'
Write-Host 'Tes CRUD/form harus dilakukan secara manual dengan akun uji, tidak diuji oleh script ini.'
