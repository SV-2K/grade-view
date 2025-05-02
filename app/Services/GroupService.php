<?php

namespace App\Services;

use App\Models\Monitoring;
use App\Repositories\Group\GroupChartRepository;
use App\Repositories\Group\GroupStatsRepository;

class GroupService
{
    private GroupStatsRepository $statsRepository;
    private GroupChartRepository $chartRepository;

    public function __construct()
    {
        $this->statsRepository = new GroupStatsRepository();
        $this->chartRepository = new GroupChartRepository();
    }

    public function getGroupPageData(
        Monitoring  $monitoring,
        string      $groupName,
        int         $groupId
    ): array
    {
        $this->statsRepository->setGroupId($groupId);
        $this->chartRepository->setGroupId($groupId);

        return [
            'isEmpty' => false,
            'monitoring' => $monitoring,
            'group' => $groupName,
            'averageGrade' => $this->statsRepository->getAverageGrade(),
            'absolutePerformance' => $this->statsRepository->getAbsolutePerformance(),
            'qualityPerformance' =>$this->statsRepository->getQualityPerformance(),
            'studentsAmount' =>$this->statsRepository->getStudentsAmount(),
            'gradesAmount' => $this->statsRepository->getGradesAmount(),
            'gradesRatioData' => $this->getGradesRatioData(),
            'qualityPerformanceData' => $this->getQualityPerformanceData(),
            'attendanceData' => $this->getAttendanceData(),
            'gradeDistributionData' => $this->getGradeDistributionData(),
        ];
    }

    private function getGradesRatioData(): array
    {
        $gradesAmounts = $this->chartRepository->getGradesRatio();

        return [
            ['5', $gradesAmounts->grade_5],
            ['4', $gradesAmounts->grade_4],
            ['3', $gradesAmounts->grade_3],
            ['2', $gradesAmounts->grade_2]
        ];
    }

    private function getQualityPerformanceData(): array
    {
        $collection = $this->chartRepository->getQualityPerformance()
            ->sortBy('quality_performance');

        $subjects = [];
        $performances = [''];

        foreach ($collection as $item) {
            $performances[] = $item->quality_performance;
            $subjects[] = $item->subject_name;
        }

        return [
            'categories' => $subjects,
            'performance' => $performances,
        ];
    }

    private function getAttendanceData(): array
    {
        $attendance = $this->chartRepository->getAttendance();

        return [
            ['Ув', $attendance->valid_hours],
            ['Н/ув', $attendance->invalid_hours],
        ];
    }

    private function getGradeDistributionData(): array
    {
        $collection = $this->chartRepository->getGradeDistribution()
            ->sortBy(['grade_5', 'grade_4', 'grade_3', 'grade_2']);

        $subjects = [];
        $grades = [
            ['5'], ['4'], ['3'], ['2']
        ];

        foreach ($collection as $item) {
            $subjects[] = $item->subject_name;
            $grades[0][] = $item->grade_5;
            $grades[1][] = $item->grade_4;
            $grades[2][] = $item->grade_3;
            $grades[3][] = $item->grade_2;
        }

        return [
            'grades' => $grades,
            'categories' => $subjects
        ];
    }
}
