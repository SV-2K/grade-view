<?php

namespace App\Http\Controllers;

use App\Models\Subject;
use App\Repositories\ChartsDataRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SubjectController extends Controller
{
    public function __construct(
        private ChartsDataRepository $dataRepository
    )
    {}

    public function show(Request $request)
    {
        $subjectName = $request->input('name');

        if(is_null($subjectName)) {
            return view('pages.subject')->with('isEmpty', true);
        }

        $subjectId = $this->dataRepository->getSubjectId($subjectName);

        return view('pages.subject')->with([
            'isEmpty' => false,
            'subject' => $subjectName,
            'categories' => $this->dataRepository->getGroups($subjectId),
            'grades' => $this->dataRepository->getGradesForEachGroup($subjectId),
            'averageGrades' => $this->dataRepository->getAverageGrades($subjectId),
            'gradesAmount' => $this->dataRepository->getGradesAmount($subjectId),
        ]);
    }
}
