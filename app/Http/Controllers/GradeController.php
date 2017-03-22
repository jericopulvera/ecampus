<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Repositories\GradeRepository;
use App\Grade;
use App\Setting;

class GradeController extends Controller
{
    public function store(Request $request)
    {
        $request->mark = GradeRepository::convertGrade($request->grade, $request->mark);
        
        $request->term_id = Setting::first()->term_id;

        $exists = Grade::where('user_id', $request->student_id)
            ->where('subject', $request->subject)
            ->where('term_id', $request->term_id)
            ->first();

        if ($exists) {

            $exists->update([
                'grade' => $request->grade,
                'mark' => $request->mark,
            ]);
            
            return response(200);
        } 

        $grade = new Grade;

        $grade->grade = $request->grade;
        $grade->mark = $request->mark;
        $grade->subject = $request->subject;
        $grade->section = $request->section;
        $grade->term()->associate($request->term_id);
        $grade->user()->associate($request->student_id);
        $grade->prof()->associate($request->prof_id);

        $grade->save();
    }
}
