<?php

namespace App\Http\Controllers\User;

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
        if (
            auth()->attempt([
                'email' => $request->input('email'),
                'password' => $request->input('password')
            ], true)
        )
        {
            return redirect(route('profile'));
        } else {
            return redirect()->back()->with('error', 'Неправильный логин или пароль');
        }
    }

    public function logout()
    {
        auth()->logout();

        return redirect(route('login.form'));
    }
}
