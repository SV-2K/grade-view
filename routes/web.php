<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/group', function (Request $request) {
    return view('pages.group', ['group' => $request->get('name')]);
})->name('group');

Route::get('/college', function () {
    return view('pages.college');
})->name('college');

Route::get('/subject', function (Request $request) {
    return view('pages.subject', ['subject' => $request->get('name')]);
})->name('subject');

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');
});
