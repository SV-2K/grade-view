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
use App\Http\Middleware\EnsureUserIsAuth;
use App\Http\Middleware\EnsureUserIsGuest;
use Illuminate\Http\Request;

Route::get('/{monitoring}/group', [GroupController::class, 'show'])->name('group');
Route::get('/{monitoring}/college', [CollegeController::class, 'show'])->name('college');
Route::get('/{monitoring}/subject', [SubjectController::class, 'show'])->name('subject');

Route::controller(UploadController::class)->middleware(EnsureUserIsAuth::class)->group(function (){
    Route::get('/monitoring-upload', 'show')->name('upload.page');
    Route::post('/monitoring-upload', 'uploadMonitoring')->name('monitoring.upload');
});

Route::controller(FeedbackController::class)->middleware(EnsureUserIsAuth::class)->group(function (){
    Route::get('/feedback', 'create')->name('feedback');
    Route::post('/feedback', 'store')->name('feedback.send');
});

Route::controller(RegisterController::class)->middleware(EnsureUserIsGuest::class)->group(function (){
    Route::get('/register','index')->name('register.form');
    Route::post('/register', 'register')->name('register.action');
});

Route::controller(LoginController::class)->middleware(EnsureUserIsGuest::class)->group(function (){
    Route::get('/login', 'index')->name('login.form');
    Route::post('/login', 'login')->name('login.action');
    Route::get('/logout', 'logout')->withoutMiddleware(EnsureUserIsGuest::class)->name('logout');
});

Route::controller(ProfileController::class)->middleware(EnsureUserIsAuth::class)->group(function (){
    Route::get('/', [ProfileController::class, 'profile']);
    Route::get('/profile', [ProfileController::class, 'profile'])->name('profile');
    Route::post('/monitoring-delete/{id}', [ProfileController::class, 'deleteMonitoring'])->name('monitoring.delete');
});
