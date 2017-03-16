<?php

namespace App\Http\Controllers;

use App\User;
use App\Setting;

class ScheduleController extends Controller
{
    public function getSchedule($usn)
    {
        $user = User::where('usn', $usn)->first();
        $term_id = Setting::first()->term_id;
        $schedule = $user->groups()->where('term_id', $term_id)->get();

        return view('schedule.schedule-index', compact('schedule', 'user'));
    }
}
