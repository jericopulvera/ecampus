<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\User;
use Datatables;

class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware(['admin']);
    }

    public function index()
    {
        return view('admin.user.users');
    }

    public function professors()
    {
        return view('admin.user.professors');
    }

    public function students()
    {
        return view('admin.user.students');
    }

    public function create()
    {
        return view('admin.user.create');
    }

    public function store(Request $request)
    {
        $this->validate(request(), [
            'usn'      => 'required|unique:users,usn|max:11|min:11',
            'username' => 'required|alpha_dash|unique:users,username',
            'name'     => "required|min:3|max:32|regex:/^[\\p{L} .'-]+$/",
            'email'    => 'required|email|unique:users,email',
            'password' => 'required|confirmed|min:6',
         ]);

        User::create([
            'usn' => $request->usn,
            'username' => $request->username,
            'name' => $request->name,
            'email' => $request->email,
            'privilege' => 'Professor',
            'password' => bcrypt($request->usn),
        ]);

        notify()->flash('Success!', 'success', [
            'timer' => 3000,
            'text' => 'You have successfully created a professor account',
        ]);

        return redirect()->back();
    }

}
    
