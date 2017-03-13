<?php

namespace App\Http\Controllers\Api\Group;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Group;

class GroupSettingController extends Controller
{
    public function updateSettings(Group $group)
    {
        $this->validate(request(), [
            'room'     => 'required',
            'schedule' => 'required',
        ]);

        $group->update([
            'room'  => request('room'),
            'dow'   => serialize(request('schedule')),
            'start' => request('start'),
            'end'   => request('end'),
        ]);

        return 1;
    }
}
