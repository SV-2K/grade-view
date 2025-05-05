<?php

namespace App\Services;

use App\Models\Monitoring;
use App\Repositories\MonitoringRepository;
use App\Repositories\Subject\SubjectChartRepository;
use App\Repositories\Subject\SubjectStatsRepository;

class SubjectService
{
    private SubjectStatsRepository $statsRepository;
    private SubjectChartRepository $chartRepository;

    public function __construct()
    {
        $this->statsRepository = new SubjectStatsRepository();
        $this->chartRepository = new SubjectChartRepository();
    }

    public function getSubjectPageData(
        Monitoring  $monitoring,
        string      $subjectName,
        int         $subjectId
    ): array
    {
        $this->statsRepository->setSubjectId($subjectId);
        $this->chartRepository->setSubjectId($subjectId);

        return [
            'isEmpty' => false,
            'monitoring' => $monitoring,
            'subject' => $subjectName,
            'averageGrade' => $this->statsRepository->getAverageGrade(),
            'groupsAmount' => $this->statsRepository->getGroupsAmount(),
            'absolutePerformance' => $this->statsRepository->getAbsolutePerformance(),
            'qualityPerformance' => $this->statsRepository->getQualityPerformance(),
            'studentsAmount' => $this->statsRepository->getStudentsAmount(),
            'sideMenuStats' => $this->getSideMenuStats($monitoring, $subjectId),
            'averageGradesData' => $this->getAverageGradesData(),
            'gradeDistributionData' => $this->getGradeDistributionData(),
            'gradesRatioData' => $this->getGradesRatioData()
        ];
    }

    private function getSideMenuStats(Monitoring $currentMonitoringId, int $subjectId): array|null
    {
        $previousMonitoringId = MonitoringRepository::getPreviousMonitoringId($currentMonitoringId);
        $previousSubjectId = MonitoringRepository::getPreviousSubjectId($currentMonitoringId, $subjectId);

        if (is_null($previousMonitoringId) || is_null($previousSubjectId)) {
            return null;
        }

        $currentAverageGrade = round($this->statsRepository->getAverageGrade(), 2);
        $currentAbsolutePerformance = round($this->statsRepository->getAbsolutePerformance(), 2);
        $currentQualityPerformance = round($this->statsRepository->getQualityPerformance(), 2);

        $this->statsRepository->setSubjectId($previousSubjectId);

        $previousAverageGrade = round($this->statsRepository->getAverageGrade(), 2);
        $previousAbsolutePerformance = round($this->statsRepository->getAbsolutePerformance(), 2);
        $previousQualityPerformance = round($this->statsRepository->getQualityPerformance(), 2);

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

    private function getAverageGradesData(): array
    {
        $collection = $this->chartRepository->getAverageGrades()
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

    private function getGradesRatioData(): array
    {
        $gradesRatio = $this->chartRepository->getGradesRatio();

        return [
            ['5', $gradesRatio->grade_5],
            ['4', $gradesRatio->grade_4],
            ['3', $gradesRatio->grade_3],
            ['2', $gradesRatio->grade_2]
        ];
    }

    private function getGradeDistributionData(): array
    {
        $collection = $this->chartRepository->getGradeDistribution()
            ->sortByDesc(['grade_5', 'grade_4', 'grade_3', 'grade_2']);

        $groups = [];
        $grades = [
            ['5'], ['4'], ['3'], ['2']
        ];

        foreach ($collection as $item) {
            $groups[] = $item->group_name;
            $grades[0][] = $item->grade_5;
            $grades[1][] = $item->grade_4;
            $grades[2][] = $item->grade_3;
            $grades[3][] = $item->grade_2;
        }

        return [
            'grades' => $grades,
            'categories' => $groups
        ];
    }
}
