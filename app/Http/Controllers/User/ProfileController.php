<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Monitoring;
use Illuminate\Http\Request;
use App\Facades\User;

class ProfileController extends Controller
{
    public function profile()
    {
        $monitorings = User::getMonitorings();

        return view('pages.profile')
            ->with('monitorings', $monitorings);
    }

    public function deleteMonitoring(int $id)
    {
        $monitoring = Monitoring::findOrFail($id);
        $monitoring->delete();
        return redirect()->route('profile');
    }
}
