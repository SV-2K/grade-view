<?php

namespace App\Services;

use App\Models\Monitoring;

class UserService
{

    public function auth(array $data): bool
    {
        return auth()->attempt($data, true);
    }

    public function getMonitorings():array
    {
        return Monitoring::whereUserId(auth()->id())
            ->get()
            ->toArray();
    }
}
