<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DosenController;
use App\Http\Controllers\KrsController;
use App\Http\Controllers\MahasiswaController;
use App\Http\Controllers\MatakuliahController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::prefix('auth')->name('auth.')->middleware('guest')->controller(AuthController::class)->group(function () {
    Route::post('/login', 'login')->name('login');
    Route::get('/login', 'showLoginForm')->name('showLoginForm');
    Route::get('/register', 'showRegisterForm')->name('showRegisterForm');
    Route::post('/register', 'register')->name('register');
});

Route::middleware('auth')->group(function () {
    Route::post('/auth/logout', [AuthController::class, 'logout']);

    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard.index');
    Route::resource('matakuliah', MatakuliahController::class)->except('show');
    Route::resource('users', UserController::class)->except(['show']);

    Route::get('/dosen/jadwal', [DosenController::class, 'index']);
    Route::get('/mahasiswa/jadwal', [MahasiswaController::class, 'index']);

    Route::controller(UserController::class)->group(function () {
        Route::post('/import', 'import');
        Route::post('/edit', 'updateProfile');
    });

    Route::prefix('krs')->name('krs.')->controller(KrsController::class)->group(function () {
        Route::get('/', 'index')->name('index');
        Route::post('/store', 'store')->name('store');

        Route::get('/submitted', 'submitted');
        Route::get('/{krsId}/generate-pdf', 'krs_pdf');
        Route::get('/{krsId}/download-pdf', 'download_pdf');
        Route::put('/submit', 'submit')->name('krs.submit');
        Route::delete('/{krs}/matakuliah/{matakuliah}', 'destroy');

        Route::put('/{krsId}/accept', 'accept');
    });
});
