<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PagesController extends Controller
{
    public function group(Request $request)
    {
        return view('pages.group', ['group' => $request->input('name')]);
    }

    public function college()
    {
        return view('pages.college');
    }

    public function subject(Request $request)
    {
        return view('pages.subject', ['subject' => $request->input('name')]);
    }

    public function uploadPage()
    {
        return view('pages.upload');
    }

    public function feedback()
    {
        return view('pages.feedback');
    }
}
