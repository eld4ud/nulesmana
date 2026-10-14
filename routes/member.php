<?php

use App\Http\Controllers\Member\AkunController;
use App\Http\Controllers\Member\AuthController;
use App\Http\Controllers\PageController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Route anggota
| Dipanggil dari routes/web.php dengan: require __DIR__.'/member.php';
|--------------------------------------------------------------------------
*/

Route::middleware('guest')->group(function () {
    Route::get('/login-anggota', [AuthController::class, 'create'])->name('member.login');
    Route::post('/login-anggota', [AuthController::class, 'store'])
        ->middleware('throttle:20,1')
        ->name('member.login.store');
});

Route::middleware(['auth', 'approved.member', 'role:member'])
    ->prefix('akun')
    ->name('member.')
    ->group(function () {
        Route::get('/', [AkunController::class, 'dashboard'])->name('dashboard');

        foreach (['kia', 'data', 'infaq', 'notifikasi', 'pengaturan'] as $slug) {
            Route::get('/'.$slug, [AkunController::class, 'page'])
                ->defaults('page', $slug)
                ->name($slug);
        }
    });

/*
|--------------------------------------------------------------------------
| Halaman tujuan 4 tombol hero + verifikasi NIA (publik)
|--------------------------------------------------------------------------
*/
Route::get('/daftar-anggota', [PageController::class, 'signup'])->name('member.signup');
Route::get('/kia', [PageController::class, 'kia'])->name('kia.info');
Route::get('/kia/cek', [PageController::class, 'kiaCheck'])->name('kia.cek');
Route::get('/verifikasi/{nia}', [PageController::class, 'verify'])
    ->where('nia', '[A-Za-z0-9-]+')
    ->name('kia.verify');
Route::get('/profil', [PageController::class, 'profil'])->name('page.profil');
