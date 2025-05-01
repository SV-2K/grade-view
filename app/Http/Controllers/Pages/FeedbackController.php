<?php

namespace App\Http\Controllers\Pages;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class FeedbackController extends Controller
{
    public function create()
    {
        return view('pages.feedback');
    }

    public function store(Request $request)
    {
        $request->validate([
            'email' => ['email', 'max:30'],
            'body' => ['min:10', 'max:256'],
        ]);

        return redirect(route('group'));
    }
}
