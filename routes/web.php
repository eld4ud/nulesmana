<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PublicController;
use App\Http\Controllers\OrganizationController;
use App\Http\Controllers\Admin\AdminDashboardController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ReviewController;

/*
|--------------------------------------------------------------------------
| Web Routes - NU Lesmana
|--------------------------------------------------------------------------
*/

// 1. WEBSITE PUBLIK
Route::get('/', [PublicController::class, 'index'])->name('home');

Route::get('/profil-organisasi', fn () => redirect()->route('page.profil'))
    ->name('public.profil');

// Struktur publik: jumlah anggota berdasarkan members.status = approved.
// Pengurus yang ditampilkan berasal dari tabel organization_positions.
Route::get('/struktur-banom', [OrganizationController::class, 'index'])
    ->name('struktur.banom');

Route::redirect('/struktur-organisasi', '/struktur-banom')
    ->name('struktur.organisasi');

Route::get('/pendaftaran-anggota', fn () => redirect()->route('member.signup'))
    ->name('member.daftar.halaman');

// Link lama dipertahankan. Cetak KIA pribadi tetap dilindungi routes/member.php.
Route::redirect('/cek-kartu', '/cetak-kartu')
    ->name('public.cek-kartu');

Route::redirect('/statistik', '/cetak-kartu', 302);

// 2. BERITA DAN AGENDA PUBLIK
Route::get('/news', [PublicController::class, 'news'])
    ->name('public.news.index');

Route::get('/news/{id}', [PublicController::class, 'showNews'])
    ->whereNumber('id')
    ->name('public.news.show');

// 3. PENDAFTARAN, SARAN, DAN ULASAN
Route::post('/register-member', [PublicController::class, 'registerMember'])
    ->name('member.register');

Route::post('/send-feedback', [PublicController::class, 'sendFeedback'])
    ->name('feedback.send');

Route::post('/ulasan', [ReviewController::class, 'store'])
    ->middleware('throttle:5,10')
    ->name('reviews.store');

// 4. LOGIN DAN AKUN ANGGOTA
require __DIR__ . '/member.php';

// 5. DASHBOARD DAN PROFIL PENGGUNA
Route::middleware(['auth', 'approved.member'])->group(function () {
    Route::get('/dashboard', function () {
        return auth()->user()->role === 'admin'
            ? redirect()->route('admin.dashboard')
            : redirect()->route('member.dashboard');
    })->name('dashboard');

    Route::get('/profile', [ProfileController::class, 'edit'])
        ->name('profile.edit');

    Route::patch('/profile', [ProfileController::class, 'update'])
        ->name('profile.update');

    Route::delete('/profile', [ProfileController::class, 'destroy'])
        ->name('profile.destroy');
});

// 6. DASHBOARD ADMIN (TERLINDUNGI MIDDLEWARE)
Route::middleware(['auth', 'admin'])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {
        Route::get('/dashboard', [AdminDashboardController::class, 'index'])
            ->name('dashboard');

        // Anggota + ACC
        Route::get('/members', [AdminDashboardController::class, 'membersIndex'])
            ->name('members.index');

        Route::patch('/members/{id}/approve', [AdminDashboardController::class, 'approveMember'])
            ->name('members.approve');

        Route::delete('/members/{id}/reject', [AdminDashboardController::class, 'rejectMember'])
            ->name('members.reject');

        Route::put('/members/{id}', [AdminDashboardController::class, 'updateMember'])
            ->name('members.update');

        Route::delete('/members/{id}', [AdminDashboardController::class, 'destroyMember'])
            ->name('members.destroy');

        // Kelola struktur organisasi (hanya admin)
        Route::get('/struktur', [OrganizationController::class, 'manage'])
            ->name('struktur.index');

        Route::post('/struktur', [OrganizationController::class, 'store'])
            ->name('struktur.store');

        Route::put('/struktur/{id}', [OrganizationController::class, 'update'])
            ->whereNumber('id')
            ->name('struktur.update');

        Route::delete('/struktur/{id}', [OrganizationController::class, 'destroy'])
            ->whereNumber('id')
            ->name('struktur.destroy');

        // Berita
        Route::get('/news', [AdminDashboardController::class, 'newsIndex'])
            ->name('news.index');

        Route::post('/news', [AdminDashboardController::class, 'storeNews'])
            ->name('news.store');

        Route::delete('/news/{id}', [AdminDashboardController::class, 'destroyNews'])
            ->name('news.destroy');

        // Infaq
        Route::get('/infaq', [AdminDashboardController::class, 'infaqIndex'])
            ->name('infaq.index');

        Route::post('/infaq', [AdminDashboardController::class, 'storeInfaq'])
            ->name('infaq.store');

        Route::delete('/infaq/{id}', [AdminDashboardController::class, 'destroyInfaq'])
            ->name('infaq.destroy');

        // Profil admin
        Route::get('/profile', [ProfileController::class, 'edit'])
            ->name('profile.edit');

        Route::patch('/profile', [ProfileController::class, 'update'])
            ->name('profile.update');

        Route::delete('/profile', [ProfileController::class, 'destroy'])
            ->name('profile.destroy');
    });

// 7. AUTENTIKASI LARAVEL BREEZE
require __DIR__ . '/auth.php';
