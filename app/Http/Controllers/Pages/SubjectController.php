<?php

namespace App\Http\Controllers\Pages;

use App\Http\Controllers\Controller;
use App\Models\Monitoring;
use App\Repositories\Subject\SubjectStatsRepository;
use App\Services\SubjectService;
use Illuminate\Http\Request;

class SubjectController extends Controller
{
    public function __construct(
        private SubjectStatsRepository $subjectRepository
    )
    {}

    public function show(
        Request         $request,
        Monitoring      $monitoring,
        SubjectService  $service
    )
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
                $service->getSubjectPageData($monitoring, $subjectName, $subjectId)
            );
    }
}
