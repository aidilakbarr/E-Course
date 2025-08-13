<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\KrsController;
use App\Http\Controllers\LectureController;
use App\Http\Controllers\MatakuliahController;
use App\Http\Controllers\TokenSessionController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

// Auth
Route::prefix('auth')->middleware('guest')->controller(AuthController::class)->group(function () {
    Route::get('/login', 'showLoginForm')->name('auth.login');
    Route::get('/register', 'showRegisterForm')->name('auth.register');
});

Route::middleware(['auth.jwt.session'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard.index');
    Route::resource('users', UserController::class)->only(['index', 'create', 'edit']);
    Route::resource('matakuliah', MatakuliahController::class)->only(['index', 'create', 'edit']);
    Route::get('/set_krs_mhs', [KrsController::class, 'index'])->name('set_krs_mhs.index');
    Route::get('/pdf/krs/{krs}', [KrsController::class, 'krs_pdf'])->name('krs.pdf');
    // Route::get('/pdf/krs/{krs}', function ($krs) {
    //     return \App\Models\Krs::find($krs);
    // });

});

Route::post('/store-token', [TokenSessionController::class, 'store']);

Route::delete('/auth/logout', function () {
    Session::forget('jwt_token');
    Session::flush();
    return response()->json(['message' => 'Logged out successfully']);
});

Route::get('/inertia', function () {
    return Inertia::render('Home');
});