<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class FeedbackController extends Controller
{
    public function send(Request $request)
    {
        $request->validate([
            'email' => ['email', 'max:30'],
            'body' => ['min:10', 'max:256'],
        ]);

        return redirect(route('group'));
    }
}
