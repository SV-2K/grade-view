<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PagesController;
use App\Http\Controllers\FileController;
use Illuminate\Http\Request;

Route::get('/', function () {
    return view('welcome');
});

Route::controller(PagesController::class)->group(function () {
    Route::get('/group', 'group')->name('group');
    Route::get('/college', 'college')->name('college');
    Route::get('/subject', 'subject')->name('subject');
    Route::get('/monitoring-upload', 'uploadPage')->name('upload.page');
});

Route::post('/monitoring-upload', [FileController::class, 'store']);

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');
});
