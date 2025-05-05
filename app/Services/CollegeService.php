<?php

namespace App\Services;

use App\Models\Monitoring;
use App\Repositories\College\CollegeChartRepository;
use App\Repositories\College\CollegeStatsRepository;
use App\Repositories\MonitoringRepository;

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
            'sideMenuStats' => $this->getSideMenuStats($monitoring),
            'qualityPerformanceData' => $this->getQualityPerformanceData(),
            'attendanceData' => $this->getAttendanceData(),
            'gradesRatioData' => $this->getGradesRatioData(),
            'averageGradesData' => $this->getAverageGradesData(),
        ];
    }

    private function getSideMenuStats(Monitoring $currentMonitoringId): array|null
    {
        $previousMonitoringId = MonitoringRepository::getPreviousMonitoringId($currentMonitoringId);

        if (is_null($previousMonitoringId)) {
            return null;
        }

        $currentAverageGrade = round($this->collegeStatsRepository->getAverageGrade(), 2);
        $currentAbsolutePerformance = round($this->collegeStatsRepository->getAbsolutePerformance(), 2);
        $currentQualityPerformance = round($this->collegeStatsRepository->getQualityPerformance(), 2);

        $this->collegeStatsRepository->setMonitoringId($previousMonitoringId);

        $previousAverageGrade = round($this->collegeStatsRepository->getAverageGrade(), 2);
        $previousAbsolutePerformance = round($this->collegeStatsRepository->getAbsolutePerformance(), 2);
        $previousQualityPerformance = round($this->collegeStatsRepository->getQualityPerformance(), 2);

        return [
            'avgGrade' => [
                'before' => $previousAverageGrade,
                'after' => $currentAverageGrade,
                'percentage' => round(percentageDifference($previousAverageGrade, $currentAverageGrade), 2)
            ],
            'absolutePerf' => [
                'before' => $previousAbsolutePerformance,
                'after' => $currentAbsolutePerformance,
                'percentage' => round(percentageDifference($previousAbsolutePerformance, $currentAbsolutePerformance), 2)
            ],
            'qualityPerf' => [
                'before' => $previousQualityPerformance,
                'after' => $currentQualityPerformance,
                'percentage' => round(percentageDifference($previousQualityPerformance, $currentQualityPerformance), 2)
            ]
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
