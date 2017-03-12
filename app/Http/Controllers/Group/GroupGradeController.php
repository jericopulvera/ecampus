<?php

namespace App\Http\Controllers\Group;

use App\GroupGrade;
use App\Http\Controllers\Controller;
use App\Record;
use Illuminate\Http\Request;

class GroupGradeController extends Controller
{
    public function updateGrade($group_id, $user_id)
    {
        $grade = GroupGrade::where('group_id', $group_id)->where('user_id', $user_id)
            ->where('week', request('week'))
            ->update([
                'class_standing' => request('cs'),
                'quiz_one'       => request('quiz1'),
                'quiz_two'       => request('quiz2'),
                'exam'           => request('exam'),
            ]);

        return $grade;
    }

    public function allGrades()
    {
        $records = Record::all();

        return view('grades', compact('records'));
    }
}
