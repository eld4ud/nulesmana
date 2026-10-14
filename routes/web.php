<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PublicController;
use App\Http\Controllers\Admin\AdminDashboardController;
use App\Http\Controllers\ProfileController;

/*
|--------------------------------------------------------------------------
| Web Routes - Ranting NU Lesmana
|--------------------------------------------------------------------------
*/

// =====================================================================
// 1. WEBSITE PUBLIK (diakses warga tanpa login, hanya membaca)
// =====================================================================
Route::get('/', [PublicController::class, 'index'])->name('home');

// Berita: daftar semua berita & detail satu berita
Route::get('/news', [PublicController::class, 'news'])->name('public.news.index');
Route::get('/news/{id}', [PublicController::class, 'showNews'])->whereNumber('id')->name('public.news.show');

// Form di landing page
Route::post('/register-member', [PublicController::class, 'registerMember'])->name('member.register');
Route::post('/send-feedback', [PublicController::class, 'sendFeedback'])->name('feedback.send');


// =====================================================================
// 2. ROUTE LOGIN & AKUN ANGGOTA (/login-anggota dan /akun/*)
// =====================================================================
require __DIR__.'/member.php';


// =====================================================================
// 3. PINTU MASUK SETELAH LOGIN (Breeze mengarahkan ke route "dashboard")
//    Admin ke dashboard admin, anggota ke /akun.
//    Route profil lama dibiarkan dulu sampai diganti menu Data Saya / Pengaturan.
// =====================================================================
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


// =====================================================================
// 4. DASHBOARD ADMIN (wajib login & rolenya admin) - semua URL diawali /admin
// =====================================================================
Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {

    // Overview dashboard admin
    Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');

    // Modul: Kelola Anggota Banom (ACC & CRUD)
    Route::get('/members', [AdminDashboardController::class, 'membersIndex'])->name('members.index');
    Route::patch('/members/{id}/approve', [AdminDashboardController::class, 'approveMember'])->name('members.approve');
    Route::delete('/members/{id}/reject', [AdminDashboardController::class, 'rejectMember'])->name('members.reject');
    Route::put('/members/{id}', [AdminDashboardController::class, 'updateMember'])->name('members.update');
    Route::delete('/members/{id}', [AdminDashboardController::class, 'destroyMember'])->name('members.destroy');

    // Modul: Kelola Berita & Kegiatan
    Route::get('/news', [AdminDashboardController::class, 'newsIndex'])->name('news.index');
    Route::post('/news', [AdminDashboardController::class, 'storeNews'])->name('news.store');
    Route::delete('/news/{id}', [AdminDashboardController::class, 'destroyNews'])->name('news.destroy');

    // Modul: Kelola Kas & Infaq
    Route::get('/infaq', [AdminDashboardController::class, 'infaqIndex'])->name('infaq.index');
    Route::post('/infaq', [AdminDashboardController::class, 'storeInfaq'])->name('infaq.store');
    Route::delete('/infaq/{id}', [AdminDashboardController::class, 'destroyInfaq'])->name('infaq.destroy');

    // Profile Admin
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
