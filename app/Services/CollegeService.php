<?php

namespace App\Services;

use App\Models\Monitoring;
use App\Repositories\College\CollegeChartRepository;
use App\Repositories\College\CollegeStatsRepository;

class CollegeService
{
    private CollegeStatsRepository $collegeStatsRepository;
    private CollegeChartRepository $collegeChartRepository;

    public function __construct()
    {
        $this->collegeStatsRepository = new CollegeStatsRepository();
        $this->collegeChartRepository = new CollegeChartRepository();
    }

    public function getCollegePageData(Monitoring $monitoring): array
    {
        $this->collegeStatsRepository->setMonitoringId($monitoring->id);
        $this->collegeChartRepository->setMonitoringId($monitoring->id);

        return [
            'monitoring' => $monitoring,
            'averageGrade' => $this->collegeStatsRepository->getAverageGrade(),
            'absolutePerformance' => $this->collegeStatsRepository->getAbsolutePerformance(),
            'qualityPerformance' => $this->collegeStatsRepository->getQualityPerformance(),
            'groupsAmount' => $this->collegeStatsRepository->getGroupsAmount(),
            'studentsAmount' => $this->collegeStatsRepository->getStudentsAmount(),
            'gradesAmount' => $this->collegeStatsRepository->getGradesAmount(),
            'qualityPerformanceData' => $this->getQualityPerformanceData(),
            'attendanceData' => $this->getAttendanceData(),
            'gradesRatioData' => $this->getGradesRatioData(),
            'averageGradesData' => $this->getAverageGradesData(),
        ];
    }

    private function getQualityPerformanceData(): array
    {
        $collection = $this->collegeChartRepository->getQualityPerformance()
            ->sortByDesc('quality_performance');

        $subjectPerformances = [];
        $teacherNames = [];

        foreach ($collection as $item) {
            $subjectPerformances[] = $item->quality_performance;
            $teacherNames[] = $item->teacher_name;
        }

        return [
            'performance' => $subjectPerformances,
            'categories' => $teacherNames,
        ];
    }

    private function getAttendanceData(): array
    {
        $attendance = $this->collegeChartRepository->getAttendance();

        return [
            ['Ув', $attendance->valid_hours],
            ['Н/ув', $attendance->invalid_hours],
        ];
    }

    private function getGradesRatioData(): array
    {
        $gradesRatio = $this->collegeChartRepository->getGradesRatio();

        return [
            ['5', $gradesRatio->grade_5],
            ['4', $gradesRatio->grade_4],
            ['3', $gradesRatio->grade_3],
            ['2', $gradesRatio->grade_2]
        ];
    }

    private function getAverageGradesData(): array
    {
        $collection = $this->collegeChartRepository->getAverageGrades()
            ->sortByDesc('average_grade');

        $averageGrades = [''];
        $groupNames = [];

        foreach ($collection as $item) {
            $averageGrades[] = $item->average_grade;
            $groupNames[] = $item->group_name;
        }

        return [
            'averageGrades' => $averageGrades,
            'groupNames' => $groupNames
        ];
    }
}
