
<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PublicController;
use App\Http\Controllers\Admin\AdminDashboardController;
use App\Http\Controllers\ProfileController;

/*
|--------------------------------------------------------------------------
| Web Routes - Nulesmana
|--------------------------------------------------------------------------
*/

// ======================================================
// 1. WEBSITE PUBLIK
// ======================================================

Route::get('/', [PublicController::class, 'index'])
    ->name('home');

// Profil website
Route::view('/profil', 'profil')
    ->name('public.profil');

// Daftar anggota
// Form pendaftaran tetap diproses oleh PublicController.
Route::view('/daftar-anggota', 'member.daftar')
    ->name('member.daftar.halaman');

// Download / lihat KTA digital
Route::view('/kta-digital', 'member.kta')
    ->name('member.kta');

// Berita publik
Route::get('/news', [PublicController::class, 'news'])
    ->name('public.news.index');

Route::get('/news/{id}', [PublicController::class, 'showNews'])
    ->whereNumber('id')
    ->name('public.news.show');

// Proses pendaftaran anggota yang sudah ada
Route::post('/register-member', [PublicController::class, 'registerMember'])
    ->name('member.register');

// Kirim kritik dan saran
Route::post('/send-feedback', [PublicController::class, 'sendFeedback'])
    ->name('feedback.send');


// ======================================================
// 2. LOGIN DAN AKUN ANGGOTA
// ======================================================

// File ini sudah berisi rute login anggota dan akun.
// Jangan dihapus atau diganti tanpa memeriksa isinya.
require __DIR__ . '/member.php';


// ======================================================
// 3. DASHBOARD DAN PROFIL PENGGUNA LOGIN
// ======================================================

Route::middleware(['auth', 'approved.member'])->group(function () {

    Route::get('/dashboard', function () {
        $user = auth()->user();

        if ($user->role === 'admin') {
            return redirect()->route('admin.dashboard');
        }

        return redirect()->route('member.dashboard');
    })->name('dashboard');

    Route::get('/profile', [ProfileController::class, 'edit'])
        ->name('profile.edit');

    Route::patch('/profile', [ProfileController::class, 'update'])
        ->name('profile.update');

    Route::delete('/profile', [ProfileController::class, 'destroy'])
        ->name('profile.destroy');
});


// ======================================================
// 4. DASHBOARD ADMIN
// ======================================================

Route::middleware(['auth', 'admin'])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {

        // Dashboard utama admin
        Route::get('/dashboard', [
            AdminDashboardController::class,
            'index'
        ])->name('dashboard');

        // Kelola anggota
        Route::get('/members', [
            AdminDashboardController::class,
            'membersIndex'
        ])->name('members.index');

        Route::patch('/members/{id}/approve', [
            AdminDashboardController::class,
            'approveMember'
        ])->name('members.approve');

        Route::delete('/members/{id}/reject', [
            AdminDashboardController::class,
            'rejectMember'
        ])->name('members.reject');

        Route::put('/members/{id}', [
            AdminDashboardController::class,
            'updateMember'
        ])->name('members.update');

        Route::delete('/members/{id}', [
            AdminDashboardController::class,
            'destroyMember'
        ])->name('members.destroy');

        // Kelola berita
        Route::get('/news', [
            AdminDashboardController::class,
            'newsIndex'
        ])->name('news.index');

        Route::post('/news', [
            AdminDashboardController::class,
            'storeNews'
        ])->name('news.store');

        Route::delete('/news/{id}', [
            AdminDashboardController::class,
            'destroyNews'
        ])->name('news.destroy');

        // Kelola infaq
        Route::get('/infaq', [
            AdminDashboardController::class,
            'infaqIndex'
        ])->name('infaq.index');

        Route::post('/infaq', [
            AdminDashboardController::class,
            'storeInfaq'
        ])->name('infaq.store');

        Route::delete('/infaq/{id}', [
            AdminDashboardController::class,
            'destroyInfaq'
        ])->name('infaq.destroy');

        // Profil admin
        Route::get('/profile', [
            ProfileController::class,
            'edit'
        ])->name('profile.edit');

        Route::patch('/profile', [
            ProfileController::class,
            'update'
        ])->name('profile.update');

        Route::delete('/profile', [
            ProfileController::class,
            'destroy'
        ])->name('profile.destroy');
    });


// ======================================================
// 5. AUTENTIKASI BREEZE
// ======================================================

require __DIR__ . '/auth.php';
