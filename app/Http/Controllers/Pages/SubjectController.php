<?php

namespace App\Http\Controllers\Pages;

use App\Facades\PageData;
use App\Http\Controllers\Controller;
use App\Models\Monitoring;
use App\Repositories\ChartsDataRepository;
use App\Repositories\SubjectRepository;
use Illuminate\Http\Request;

class SubjectController extends Controller
{
    public function __construct(
        private ChartsDataRepository $dataRepository,
        private SubjectRepository $subjectRepository
    )
    {}

    public function show(Request $request, Monitoring $monitoring)
    {
        $subjectName = $request->input('name');
        $subjectId = $this->subjectRepository->getSubjectId($monitoring->id, $subjectName);

        if (is_null($subjectName) || is_null($subjectId)) {
            return view('pages.subject')->with([
                'isEmpty' => true,
                'monitoring' => $monitoring
            ]);
        }

        return view('pages.subject')
            ->with(
                PageData::getSubjectPageData($monitoring, $subjectName, $subjectId)
            );
    }
}
