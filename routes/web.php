<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UploadController;
use App\Http\Controllers\FeedbackController;
use App\Http\Controllers\GroupController;
use App\Http\Controllers\CollegeController;
use App\Http\Controllers\SubjectController;
use App\Http\Controllers\User\RegisterController;
use App\Http\Controllers\User\LoginController;
use App\Http\Controllers\User\ProfileController;
use Illuminate\Http\Request;

Route::get('/{monitoring}/group', [GroupController::class, 'show'])->name('group');

Route::get('/{monitoring}/college', [CollegeController::class, 'show'])->name('college');

Route::get('/{monitoring}/subject', [SubjectController::class, 'show'])->name('subject');

Route::get('/monitoring-upload', [UploadController::class, 'show'])->name('upload.page');
Route::post('/monitoring-upload', [UploadController::class, 'uploadMonitoring'])->name('monitoring.upload');

Route::get('/feedback', [FeedbackController::class, 'create'])->name('feedback');
Route::post('/feedback', [FeedbackController::class, 'store'])->name('feedback.send');

Route::get('/register', [RegisterController::class, 'index'])->name('register.form');
Route::post('/register', [RegisterController::class, 'register'])->name('register.action');

Route::get('/login', [LoginController::class, 'index'])->name('login.form');
Route::post('/login', [LoginController::class, 'login'])->name('login.action');
Route::get('/logout', [LoginController::class, 'logout'])->name('logout');

Route::get('/', [ProfileController::class, 'profile']);
Route::get('/profile', [ProfileController::class, 'profile'])->name('profile');
Route::post('/monitoring-delete/{id}', [ProfileController::class, 'deleteMonitoring'])->name('monitoring.delete');

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');
});
