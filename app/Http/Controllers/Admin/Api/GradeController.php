<?php

namespace App\Http\Controllers\Admin\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Grade;
use Datatables;

class GradeController extends Controller
{
    public function __construct()
    {
        $this->middleware(['admin']);
    }

    public function index()
    {
        $data = collect();
        foreach (Grade::all() as $grade) {
            $grade->usn = $grade->user->usn;
            $grade->name = $grade->user->name;
            $grade->course = $grade->user->course;
            $grade->academic_term = $grade->term->year . ' ' . $grade->term->semester . ' Trimester';
            $grade->action = '<a href="/admin/users/'.$grade->user->usn.'"> View </a>';

            $data->push($grade);
        }
        
        return response()->json([
            'data' => $data,
        ]);
    }

    public function failedGrades()
    {
        $data = collect();
        foreach (Grade::whereIn('mark', ['IC', 'F', 'D'])->get() as $grade) {
            $grade->usn = $grade->user->usn;
            $grade->name = $grade->user->name;
            $grade->course = $grade->user->course;
            $grade->academic_term = $grade->term->year . ' ' . $grade->term->semester . ' Trimester';
            $grade->action = '<a href="/admin/users/'.$grade->user->usn.'"> View </a>';

            $data->push($grade);
        }
        
        return response()->json([
            'data' => $data,
        ]);
    }
}
    
