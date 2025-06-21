<?php

namespace App\Repositories;

use App\Models\Monitoring;
use App\Models\Subject;
use Illuminate\Support\Facades\Auth;

class MonitoringRepository
{
    public static function getPreviousMonitoringId(Monitoring $currentMonitoring): int|null
    {
        $currentMonitoringStartDate = $currentMonitoring->start_date;

        return Monitoring::query()
            ->join('users', 'users.id', '=', 'monitorings.user_id')
            ->where('users.id', $currentMonitoring->user_id)
            ->where('monitorings.start_date', '<', $currentMonitoringStartDate)
            ->orderByDesc('start_date')
            ->value('monitorings.id');
    }

    public static function getPreviousGroupId(Monitoring $monitoring, string $groupName): int|null
    {
        $currentMonitoringStartDate = $monitoring->start_date;

        return Monitoring::query()
            ->join('groups', 'monitorings.id', '=', 'groups.monitoring_id')
            ->join('users', 'users.id', '=', 'monitorings.user_id')
            ->where('users.id', $monitoring->user_id)
            ->where('groups.name', $groupName)
            ->where('monitorings.start_date', '<', $currentMonitoringStartDate)
            ->orderByDesc('start_date')
            ->value('groups.id');
    }

    public static function getPreviousSubjectId(Monitoring $monitoring, int $subjectId): int|null
    {
        $subject = Subject::find($subjectId);

        return Monitoring::query()
            ->join('subjects', 'monitorings.id', '=', 'subjects.monitoring_id')
            ->join('users', 'users.id', '=', 'monitorings.user_id')
            ->where('users.id', $monitoring->user_id)
            ->where('subjects.name', $subject->name)
            ->where('subjects.teacher_name', $subject->teacher_name)
            ->where('monitorings.start_date', '<', $monitoring->start_date)
            ->orderByDesc('start_date')
            ->value('subjects.id');
    }
}
