<?php

namespace App\Http\Controllers\User;

use App\Facades\User;
use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;

class LoginController extends Controller
{
    public function index()
    {
        return view('pages.login');
    }

    public function login(LoginRequest $request)
    {
        if (User::auth($request->validated()))
        {
            return redirect(route('profile'));
        }
        return redirect()->back()->with('error', 'Неправильный логин или пароль');
    }

    public function logout()
    {
        auth()->logout();
        return redirect(route('login.form'));
    }
}
