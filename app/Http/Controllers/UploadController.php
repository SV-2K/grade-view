<?php

namespace App\Http\Controllers;

use App\Http\Requests\UploadRequest;
use Illuminate\Http\Request;
use App\Services\ExcelParser;

class UploadController extends Controller
{
    public function __construct(
        protected ExcelParser $excelParser
    )
    {}

    public function show()
    {
        return view('pages.upload');
    }

    public function uploadMonitoring(UploadRequest $request)
    {
        $this->excelParser->run($request->file('uploadFiles')->getRealPath());

        $request->file('uploadFiles')->store('/uploaded');

        return redirect(route('group'));
    }
}
