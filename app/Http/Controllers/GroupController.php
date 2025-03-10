<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class GroupController extends Controller
{
    public function show(Request $request)
    {
        return view('pages.group', ['group' => $request->input('name')]);
    }
}
