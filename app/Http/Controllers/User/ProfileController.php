<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Monitoring;
use Illuminate\Http\Request;

class ProfileController extends Controller
{
    public function profile()
    {
        $monitorings = $this->getMonitorings();
        return view('pages.profile')->with('monitorings', $monitorings);
    }

    private function getMonitorings():array
    {
        return Monitoring::whereUserId(auth()->id())->get()->toArray();
    }

    public function deleteMonitoring(int $id)
    {
        $monitoring = Monitoring::findOrFail($id);
        $monitoring->delete();
        return redirect()->route('profile');
    }
}
