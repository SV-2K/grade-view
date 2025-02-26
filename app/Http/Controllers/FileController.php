<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\ExcelParser;

class FileController extends Controller
{
    public function __construct(
        protected ExcelParser $excelParser
    )
    {}

    public function uploadMonitoring(Request $request)
    {
        $request->validate([
            'monitoring' => ['required', 'extensions:xlsx,xls,xml']
        ]);

        $this->excelParser->run($request->file('monitoring')->getRealPath());

        $request->file('monitoring')->store('/uploaded');

        return redirect(route('group'));
    }
}
