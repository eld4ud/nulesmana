
<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PublicController;
use App\Http\Controllers\PublicNewsController;
use App\Http\Controllers\OrganizationController;
use App\Http\Controllers\Admin\AdminDashboardController;
use App\Http\Controllers\Admin\ReviewManagementController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ReviewController;

// WEBSITE PUBLIK
Route::get('/', [PublicController::class, 'index'])->name('home');
Route::get('/profil-organisasi', function () {
    return redirect()->route('page.profil');
})->name('public.profil');
Route::get('/struktur-banom', [OrganizationController::class, 'index'])->name('struktur.banom');
Route::redirect('/struktur-organisasi', '/struktur-banom')->name('struktur.organisasi');
Route::get('/pendaftaran-anggota', function () {
    return redirect()->route('member.signup');
})->name('member.daftar.halaman');
Route::redirect('/cek-kartu', '/cetak-kartu')->name('public.cek-kartu');
Route::redirect('/statistik', '/cetak-kartu', 302);

// BERITA DAN AGENDA PUBLIK
Route::get('/news', [PublicNewsController::class, 'index'])->name('public.news.index');
Route::get('/news/{id}', [PublicController::class, 'showNews'])
    ->whereNumber('id')
    ->name('public.news.show');

// PENDAFTARAN ANGGOTA
Route::post('/register-member', [PublicController::class, 'registerMember'])->name('member.register');

// SARAN DAN ULASAN WARGA
Route::post('/send-feedback', [PublicController::class, 'sendFeedback'])->name('feedback.send');
Route::post('/ulasan', [ReviewController::class, 'store'])
    ->middleware('throttle:5,10')
    ->name('reviews.store');
Route::delete('/ulasan/{review}', [ReviewController::class, 'destroyOwn'])
    ->whereNumber('review')
    ->middleware('throttle:10,1')
    ->name('reviews.destroy');

// LOGIN DAN AKUN ANGGOTA
require __DIR__ . '/member.php';

// DASHBOARD DAN PROFIL PENGGUNA
Route::middleware(['auth', 'approved.member'])->group(function () {
    Route::get('/dashboard', function () {
        return auth()->user()->role === 'admin'
            ? redirect()->route('admin.dashboard')
            : redirect()->route('member.dashboard');
    })->name('dashboard');
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// DASHBOARD ADMIN
Route::middleware(['auth', 'admin'])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {
        // DASHBOARD UTAMA
        Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');

        // KELOLA ANGGOTA
        Route::get('/members', [AdminDashboardController::class, 'membersIndex'])->name('members.index');
        Route::patch('/members/{id}/approve', [AdminDashboardController::class, 'approveMember'])
            ->whereNumber('id')
            ->name('members.approve');
        Route::delete('/members/{id}/reject', [AdminDashboardController::class, 'rejectMember'])
            ->whereNumber('id')
            ->name('members.reject');
        Route::put('/members/{id}', [AdminDashboardController::class, 'updateMember'])
            ->whereNumber('id')
            ->name('members.update');
        Route::delete('/members/{id}', [AdminDashboardController::class, 'destroyMember'])
            ->whereNumber('id')
            ->name('members.destroy');

        // KELOLA STRUKTUR ORGANISASI
        Route::get('/struktur', [OrganizationController::class, 'manage'])->name('struktur.index');
        Route::post('/struktur', [OrganizationController::class, 'store'])->name('struktur.store');
        Route::put('/struktur/{id}', [OrganizationController::class, 'update'])
            ->whereNumber('id')
            ->name('struktur.update');
        Route::delete('/struktur/{id}', [OrganizationController::class, 'destroy'])
            ->whereNumber('id')
            ->name('struktur.destroy');

        // KELOLA BERITA DAN AGENDA
        Route::get('/news', [AdminDashboardController::class, 'newsIndex'])->name('news.index');
        Route::post('/news', [AdminDashboardController::class, 'storeNews'])->name('news.store');
        Route::delete('/news/{id}', [AdminDashboardController::class, 'destroyNews'])
            ->whereNumber('id')
            ->name('news.destroy');

        // KELOLA INFAQ DAN KAS
        Route::get('/infaq', [AdminDashboardController::class, 'infaqIndex'])->name('infaq.index');
        Route::post('/infaq', [AdminDashboardController::class, 'storeInfaq'])->name('infaq.store');
        Route::delete('/infaq/{id}', [AdminDashboardController::class, 'destroyInfaq'])
            ->whereNumber('id')
            ->name('infaq.destroy');

        // KELOLA ULASAN WARGA
        Route::get('/ulasan', [ReviewManagementController::class, 'index'])->name('reviews.index');
        Route::patch('/ulasan/{review}/visibility', [ReviewManagementController::class, 'toggleVisibility'])
            ->whereNumber('review')
            ->name('reviews.visibility');
        Route::delete('/ulasan/{review}', [ReviewManagementController::class, 'destroy'])
            ->whereNumber('review')
            ->name('reviews.destroy');

        // PROFIL ADMIN
        Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
        Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
        Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    });

// AUTENTIKASI LARAVEL BREEZE
require __DIR__ . '/auth.php';
