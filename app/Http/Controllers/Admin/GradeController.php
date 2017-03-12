<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Grade;

class GradeController extends Controller
{
    public function __construct()
    {
        $this->middleware(['admin']);
    }

    public function index()
    {
        return view('admin.grade.grades');
    }

    public function failedGrades()
    {
        return view('admin.grade.failed-grades');
    }

}
    
