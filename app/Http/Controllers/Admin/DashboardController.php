<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\User;
use App\Grade;
use App\Setting;

class DashboardController extends Controller
{
    public $term_id;

    public function __construct(Setting $setting)
    {
        $this->term_id = $setting->first()->term_id;
        $this->middleware(['admin']);
    }

    public function index()
    {
        $professors = count(User::where('privilege', 'professor')->get());
        $students = count(User::where('privilege', 'student')->get());
        $total = $professors + $students;
        $failAndIc = count(Grade::whereIn('mark', ['IC','F'])->where('term_id', $this->term_id)->get());
        return view('admin.dashboard', compact('professors', 'students', 'total', 'failAndIc'));
    }

}
    
