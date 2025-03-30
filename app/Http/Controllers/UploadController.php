<?php

namespace App\Http\Controllers;

use App\Http\Requests\UploadRequest;
use App\Models\Monitoring;
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
        $id = Monitoring::create([
            'name' => $request->input('name'),
            'user_id' => auth()->id(),
            'start_date' => $request->input('start-date'),
            'end_date' => $request->input('end-date'),
        ])->id;

        $files = $request->file('uploaded-files');
        $filePaths = [];

        foreach ($files as $key => $file) {
            $filePaths[] = $file->getRealPath();
        }

        $this->excelParser->run($filePaths, $id);

        foreach ($files as $file) {
            $file->store('/uploaded');
        }

        return redirect(route('profile'));
    }
}
