<?php

namespace App\Repositories;

use App\Models\Monitoring;
use Illuminate\Support\Facades\Auth;

class MonitoringRepository
{
    public static function getPreviousMonitoringId(Monitoring $currentMonitoring): int|null
    {
        $currentMonitoringStartDate = $currentMonitoring->start_date;

        return Monitoring::query()
            ->join('users', 'users.id', '=', 'monitorings.user_id')
            ->where('users.id', Auth::user()->id)
            ->where('monitorings.start_date', '<', $currentMonitoringStartDate)
            ->orderByDesc('start_date')
            ->value('monitorings.id');
    }
}
