<?php

use App\Http\Controllers\Member\AkunController;
use App\Http\Controllers\Member\AuthController;
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
