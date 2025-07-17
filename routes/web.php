<?php

use App\Http\Controllers\AssignmentController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CourseController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\EnrollmentController;
use App\Http\Controllers\LessonController;
use App\Http\Controllers\TableController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;
 
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

// Auth
Route::prefix('auth')->middleware('guest')->controller(AuthController::class)->group(function(){
    Route::get('/login',  'showLoginForm')->name('auth.login');
    Route::post('/login',  'login');
    Route::get('/register',  'showRegisterForm')->name('auth.register');
    Route::post('/register',  'register');
});

// Admin only (table + dashboard)
Route::middleware(['auth', 'admin'])->group(function () {
    Route::resource('table', TableController::class)->except(['show']);
});

// Admin + Instructor (akses lainnya)
Route::middleware(['auth', 'adminOrInstructor'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('admin.dashboard.index');
    Route::resource('courses', CourseController::class)->except(['show']);
    Route::resource('courses.lessons', LessonController::class)->except(['show']);
    Route::resource('courses.enrollments', EnrollmentController::class)->except(['show']);
    Route::resource('courses.lessons.assignments', AssignmentController::class)->only(['index']);
});

// User
Route::middleware('auth')->group(function (){
    Route::delete('/logout',[AuthController::class, 'logout'])->name('auth.logout');
});

Route::controller(UserController::class)->group(function (){
    Route::get('/',[UserController::class, 'index'])->name('user.home.index');
    Route::get('/about',[UserController::class, 'showAbout'])->name('user.about.index');
    Route::get('/course',[UserController::class, 'showCourse'])->name('user.course.index');
    Route::get('/contact',[UserController::class, 'showContact'])->name('user.contact.index');
    Route::get('/detail-course',[UserController::class, 'showDetailCourse'])->name('user.detail-course.index');
    Route::put('/profile',[UserController::class, 'updateProfile'])->name('user.profile.update');

});

