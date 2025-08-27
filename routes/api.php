<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\api\krsController;
use App\Http\Controllers\api\MatakuliahController;
use App\Http\Controllers\api\UserController;
use Illuminate\Support\Facades\Route;

Route::group([
    'prefix' => 'auth',
    'as' => 'api.auth.',
], function ($router) {
    Route::post('register', [AuthController::class, 'register']);
    Route::post('login', [AuthController::class, 'login']);
    Route::post('refresh', [AuthController::class, 'refresh']);
});

Route::group([
    'middleware' => ['jwt.auth'],
    'prefix' => 'auth',
    'as' => 'api.auth.',
], function () {
    Route::get('me', [AuthController::class, 'me']);
    Route::delete('logout', [AuthController::class, 'logout']);
});

Route::group([
    'as' => 'api.',
], function () {
    Route::get('show-dosen', [UserController::class, 'getDosens'])->name('show.getDosens');
    Route::put('/profile/update', [UserController::class, 'updateProfile'])->name('profile.update');
    Route::post('/import-user', [UserController::class, 'importMahasiswa']);
    Route::apiResource('users', UserController::class);
    Route::apiResource('matakuliah', MatakuliahController::class);
    Route::prefix('krs')->as('krs.')->group(function () {
        Route::get('/tersedia', [KrsController::class, 'tersedia'])->name('krs.tersedia');
        Route::get('/terpilih', [KrsController::class, 'terpilih'])->name('krs.terpilih');
        Route::post('/store', [KrsController::class, 'store'])->name('krs.store');
        Route::put('/submit', [KrsController::class, 'submit'])->name('krs.submit');
        Route::delete('/{krs}/matakuliah/{matakuliah}', [KrsController::class, 'destroy'])->name('krs.destroy');
        Route::get('/{krsId}/generate-pdf', [KrsController::class, 'krs_pdf']);
        Route::get('/{krsId}/download-pdf', [KrsController::class, 'download_pdf']);
    });
});