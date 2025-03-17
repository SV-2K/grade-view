<?php

namespace App\Http\Controllers;

use App\Repositories\ChartsDataRepository;
use App\Repositories\CollegeRepository;
use Illuminate\Http\Request;

class CollegeController extends Controller
{
    public function __construct(
        private ChartsDataRepository $dataRepository,
        private CollegeRepository $collegeRepository
    )
    {}

    public function show()
    {
        return view('pages.college')->with([
            'averageGrade' => $this->collegeRepository->getAverageGrade(),
            'absolutePerformance' => $this->collegeRepository->getAbsolutePerformance(),
            'qualityPerformance' => $this->collegeRepository->getQualityPerformance(),
            'groupsAmount' => $this->collegeRepository->getGroupsAmount(),
            'studentsAmount' => $this->collegeRepository->getStudentsAmount(),
            'performance' => $this->dataRepository->getQualityPerformance(),
            'qualityPerformanceCategories' => $this->dataRepository->getCategories('subjects'),
            'averageGradesCategories' => $this->dataRepository->getCategories('groups'),
            'averageGrades' => $this->dataRepository->getAverageGrades('groups'),
            'attendance' => $this->dataRepository->getAttendance(),
            'gradesAmount' => $this->dataRepository->getGradesAmount(),
        ]);
    }
}
