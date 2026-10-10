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

// Redirect otomatis jika ada view yang masih memanggil route('dashboard')
Route::get('/dashboard', function () {
    return redirect()->route('admin.dashboard');
})->name('dashboard');


// =====================================================================
// 2. DASHBOARD ADMIN (wajib login) - semua URL diawali /admin
// =====================================================================
Route::middleware(['auth'])->prefix('admin')->name('admin.')->group(function () {

    // Overview dashboard
    Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');

    // Modul: Kelola Anggota Banom (ACC & CRUD)
    Route::get('/members', [AdminDashboardController::class, 'membersIndex'])->name('members.index');
    Route::patch('/members/{id}/approve', [AdminDashboardController::class, 'approveMember'])->name('members.approve');
    Route::delete('/members/{id}/reject', [AdminDashboardController::class, 'rejectMember'])->name('members.reject');
    Route::put('/members/{id}', [AdminDashboardController::class, 'updateMember'])->name('members.update');
    Route::delete('/members/{id}', [AdminDashboardController::class, 'destroyMember'])->name('members.destroy');

    // Modul: Kelola Berita & Kegiatan (admin yang menambah/menghapus berita)
    Route::get('/news', [AdminDashboardController::class, 'newsIndex'])->name('news.index');
    Route::post('/news', [AdminDashboardController::class, 'storeNews'])->name('news.store');
    Route::delete('/news/{id}', [AdminDashboardController::class, 'destroyNews'])->name('news.destroy');

    // Modul: Kelola Kas & Infaq
    Route::get('/infaq', [AdminDashboardController::class, 'infaqIndex'])->name('infaq.index');
    Route::post('/infaq', [AdminDashboardController::class, 'storeInfaq'])->name('infaq.store');
    Route::delete('/infaq/{id}', [AdminDashboardController::class, 'destroyInfaq'])->name('infaq.destroy');

    // Profile
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';