<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PagesController;
use App\Http\Controllers\FileController;
use App\Http\Controllers\FeedbackController;
use Illuminate\Http\Request;

Route::controller(PagesController::class)->group(function () {
    Route::get('/', 'group');
    Route::get('/group', 'group')->name('group');
    Route::get('/college', 'college')->name('college');
    Route::get('/subject', 'subject')->name('subject');
    Route::get('/monitoring-upload', 'uploadPage')->name('upload.page');
    Route::get('/feedback', 'feedback')->name('feedback');
});

Route::post('/monitoring-upload', [FileController::class, 'upload'])->name('monitoring.upload');

Route::post('/feedback', [FeedbackController::class, 'send'])->name('feedback.send');

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');
});
