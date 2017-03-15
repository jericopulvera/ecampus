<?php

namespace App\Http\Controllers;

use App\User;

class ScheduleController extends Controller
{
    public function getSchedule($usn)
    {
        $user = User::where('usn', $usn)->first();
        $schedule = $user->groups()->get();

        return view('schedule.schedule-index', compact('schedule', 'user'));
    }
}
