<?php

use App\Http\Controllers\Api\AuthController;
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
    'middleware' => ['jwt.auth'],
    'as' => 'api.',
], function () {
    Route::get('show-dosen', [UserController::class, 'getDosens'])->name('show.getDosens');
    Route::put('/profile/update', [UserController::class, 'updateProfile'])->name('profile.update');
    Route::apiResource('users', UserController::class);
    Route::apiResource('matakuliah', MatakuliahController::class);
});