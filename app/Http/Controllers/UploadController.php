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

        $filePath = $request->file('uploaded-files')->getRealPath();

        $this->excelParser->run($filePath, $id);

        $request->file('uploaded-files')->store('/uploaded');

        return redirect(route('group'));
    }
}
