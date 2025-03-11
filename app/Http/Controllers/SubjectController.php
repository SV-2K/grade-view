<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SubjectController extends Controller
{
    public function show(Request $request)
    {
        return view('pages.subject')->with([
            'subject' => $request->input('name')
        ]);
    }
}
