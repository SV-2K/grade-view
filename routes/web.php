<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UploadController;
use App\Http\Controllers\FeedbackController;
use App\Http\Controllers\GroupController;
use App\Http\Controllers\CollegeController;
use App\Http\Controllers\SubjectController;
use Illuminate\Http\Request;

Route::get('/', [GroupController::class, 'show']);
Route::get('/group', [GroupController::class, 'show'])->name('group');

Route::get('/college', [CollegeController::class, 'show'])->name('college');

Route::get('/subject', [SubjectController::class, 'show'])->name('subject');

Route::get('/monitoring-upload', [UploadController::class, 'show'])->name('upload.page');
Route::post('/monitoring-upload', [UploadController::class, 'uploadMonitoring'])->name('monitoring.upload');

Route::get('/feedback', [FeedbackController::class, 'create'])->name('feedback');
Route::post('/feedback', [FeedbackController::class, 'store'])->name('feedback.send');

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');
});
