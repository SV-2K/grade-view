<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class FileController extends Controller
{
    public function upload(Request $request)
    {
        $request->validate([
            'monitoring' => ['required', 'extensions:xlsx,xls,xml']
        ]);
        $request->file('monitoring')->store('/uploaded');
        return redirect(route('group'));
    }
}
