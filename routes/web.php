<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\KrsController;
use App\Http\Controllers\MatakuliahController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

// Auth
Route::prefix('auth')->middleware('guest')->controller(AuthController::class)->group(function () {
    Route::post('/login', 'login')->name('auth.login');
    Route::get('/login', 'showLoginForm')->name('auth.showLoginForm');
    Route::get('/register', 'showRegisterForm')->name('auth.showRegisterForm');
    Route::post('/register', 'register')->name('auth.register');
});

Route::middleware(['auth'])->group(function () {
    Route::post('/import-user', [userController::class, 'importMahasiswa']);
    Route::post('/edit-user', [userController::class, 'updateProfile']);
    Route::resource('users', UserController::class)->except(['show']);
    Route::prefix('krs')->as('krs.')->group(function () {
        Route::get('/set_krs_mhs', [KrsController::class, 'index'])->name('set_krs_mhs.index');
        Route::post('/store', [KrsController::class, 'store'])->name('krs.store');
        Route::put('/submit', [KrsController::class, 'submit'])->name('krs.submit');
        Route::delete('/{krs}/matakuliah/{matakuliah}', [KrsController::class, 'destroy'])->name('krs.destroy');
        Route::get('/{krsId}/generate-pdf', [KrsController::class, 'krs_pdf']);
        Route::get('/{krsId}/download-pdf', [KrsController::class, 'download_pdf']);
        Route::get('/submitted', [KrsController::class, 'submitted']);
        Route::put('/{krsId}/accept', [KrsController::class, 'accept']);
    });
    Route::resource('matakuliah', MatakuliahController::class)->except('show');
    Route::post('/auth/logout', [AuthController::class, 'logout'])->name('auth.logout');
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard.index');
});
