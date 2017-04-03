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
        return view('admin.user.user-index');
    }

    public function edit(User $user)
    {
        return view('admin.user.edit', compact('user'));
    }

    public function update(User $user)
    {
        $this->validate(request(), [
            'usn'      => 'required|numeric',
            'username' => 'required|alpha_dash',
            'name'     => "required|min:3|max:32|regex:/^[\\p{L} .'-]+$/",
            'privilege'=> 'required',
            'password' => 'confirmed|min:6',
         ]);

        if ( ! request('password')) {
            $user->update([
                'usn' => request('usn'),
                'username' => request('username'),
                'name' => request('name'),
                'email' => request('email'),
                'privilege' => request('privilege'),
            ]);
        } else {
            $user->update([
                'usn' => request('usn'),
                'username' => request('username'),
                'name' => request('name'),
                'email' => request('email'),
                'privilege' => request('privilege'),
                'password' => bcrypt(request('password')),
             ]);
        }
        
        notify()->flash('Success!', 'success', [
            'timer' => 3000,
            'text' => 'You have successfully updated ' . request('name'),
        ]);

        return redirect()->route('admin-edit-user', request('usn'));
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
            'privilege'=> 'required',
            'password' => 'required|confirmed|min:6',
         ]);

        User::create([
            'usn' => $request->usn,
            'username' => $request->username,
            'name' => $request->name,
            'email' => $request->email,
            'privilege' => $request->privilege,
            'password' => bcrypt($request->usn),
        ]);

        notify()->flash('Success!', 'success', [
            'timer' => 3000,
            'text' => 'You have successfully created a professor account',
        ]);

        return redirect()->back();
    }

    public function show(User $user)
    {
        $schedule = $user->groups()->get();
        return view('admin.user.user-show', compact('user', 'schedule'));
    }

    public function block(User $user)
    {
        $user->update([
            'active' => 0,
        ]);

        notify()->flash( $user->name, 'success', [
            'timer' => 3000,
            'text' => 'Is now blocked from this site.',
        ]);

        return redirect()->back();
    }

    public function unblock(User $user)
    {
        $user->update([
            'active' => 1,
        ]);

        notify()->flash( $user->name, 'success', [
            'timer' => 3000,
            'text' => 'can now access this site again.',
        ]);

        return redirect()->back();
    }

}
    
