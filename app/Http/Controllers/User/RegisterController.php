<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\RegisterRequest;
use App\Models\User;

class RegisterController extends Controller
{
    public function index()
    {
        return view('pages.register');
    }

    public function register(RegisterRequest $request)
    {
        User::create($request->validated());
    }
}
