<?php

namespace App\Http\Controllers;

use App\Models\Monitoring;
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

    public function show(Monitoring $monitoring)
    {
        return view('pages.college')->with([
            'monitoring' => $monitoring,
            'averageGrade' => $this->collegeRepository->getAverageGrade($monitoring->id),
            'absolutePerformance' => $this->collegeRepository->getAbsolutePerformance($monitoring->id),
            'qualityPerformance' => $this->collegeRepository->getQualityPerformance($monitoring->id),
            'groupsAmount' => $this->collegeRepository->getGroupsAmount($monitoring->id),
            'studentsAmount' => $this->collegeRepository->getStudentsAmount($monitoring->id),
            'gradesAmount' => $this->collegeRepository->getGradesAmount($monitoring->id),
            'performance' => $this->dataRepository->getQualityPerformance(monitoringId: $monitoring->id),
            'qualityPerformanceCategories' => $this->dataRepository->getCategories('subjects', monitoringId: $monitoring->id),
            'averageGradesCategories' => $this->dataRepository->getCategories('groups', monitoringId: $monitoring->id),
            'averageGrades' => $this->dataRepository->getAverageGrades('groups', monitoringId: $monitoring->id),
            'attendance' => $this->dataRepository->getAttendance(monitoringId: $monitoring->id),
            'gradesAmounts' => $this->dataRepository->getGradesAmounts(monitoringId: $monitoring->id),
        ]);
    }
}
