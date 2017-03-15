<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Setting;
use App\SchoolTerm;

class AcademicTermController extends Controller
{
    public function __construct()
    {
        $this->middleware(['admin']);
    }

    public function index()
    {
        $academic_terms = SchoolTerm::all();

        return view('admin.academic-term.index', compact('academic_terms'));
    }

    public function create()
    {
        return view('admin.academic-term.create');
    }

    // public function store(Request $request)
    // {
    //     if(strtotime($request->start) > strtotime($request->end)) {
    // 		notify()->flash('End month must be greater than start month.');
    // 		return redirect()->back();
    // 	}

    // 	$this->validate($request, [
    // 		'start' => 'required',
    // 		'end' => 'required',
    // 		'year' => 'required',
    // 		'semester' => 'required',
    // 	]);

    // 	$term = new SchoolTerm;
    // 	$term->start = $request->start;
    // 	$term->end = $request->end;
    // 	$term->year = $request->year;
    // 	$term->semester = $request->semester;

    // 	$term->save();

    // 	return redirect()->back();
    // }

    public function edit($id)
    {
        $term = SchoolTerm::find($id);
        return view('admin.academic-term.edit', compact('term'));
    }

    public function update(Request $request, $id)
    {
        $term = SchoolTerm::find($id);

        $term->start = $request->start;
        $term->end = $request->end;
        $term->save();

        notify()->flash('Term details updated', 'success');
        return redirect()->route('academic-term.index');    	
    }
}
    
