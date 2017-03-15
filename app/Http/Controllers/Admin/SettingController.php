<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Setting;
use App\SchoolTerm;

class SettingController extends Controller
{

    public function __construct()
    {
        $this->middleware(['admin']);
    }

    public function index()
    {
        $setting = Setting::with('term')->first();
        $academic_terms = SchoolTerm::all();

        return view('admin.setting.index', compact('setting', 'academic_terms'));
    }

    public function update(Request $request)
    {
    	$setting = new Setting;
    	
    	$setting->first()->update([
    		'term_id' => $request->term_id,
    	]);

    	notify()->flash('Current Academic Term Has Been Updated', 'success');
    	return redirect()->back();
    }
}
    
