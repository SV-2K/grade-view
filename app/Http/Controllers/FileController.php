<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class FileController extends Controller
{
    public function store(Request $request)
    {
        $request->file('monitoring')->store('/uploaded');
        return redirect(route('group'));
    }
}
