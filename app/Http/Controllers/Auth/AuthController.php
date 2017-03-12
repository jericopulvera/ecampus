<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Key;
use App\User;
use Auth;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function index()
    {
        if (Auth::check()):
            return view('home-page'); else:
            return view('auth.login');
        endif;
    }

    public function login(Request $request)
    {
        if (Auth::attempt(['usn' => $request->usn, 'password' => $request->pass])) {
            return 0;
        }

        return 1;
    }

    public function register()
    {
        $this->validate(request(), [
            'usn'      => 'required|max:11|min:11',
            'username' => 'required|alpha_dash|unique:users,username',
            'name'     => "required|min:3|max:32|regex:/^[\\p{L} .'-]+$/",
            'email'    => 'required|email|unique:users,email',
            'password' => 'required|confirmed|min:6',
            'key'      => 'required',
         ]);

        $check = Key::where('usn', request('usn'))->where('activation_key', request('key'))->where('used', 0)->first();

        if ($check == null) {
            return 0;
        }

        $check->update(['used' => 1]);

        $user = User::create([
             'usn'        => request('usn'),
             'username'   => request('username'),
             'privilege'  => 'Student',
             'email'      => request('email'),
             'name'       => request('name'),
             'course'     => request('course'),
             'password'   => bcrypt(request('password')),
             'status'     => 1,
             'login_type' => 'normal',
         ]);

        $user->following()->attach(User::where('privilege', 'Dean')->first());

        auth()->login($user);

        return 1;
    }

    public function logout()
    {
        Auth::logout();
        
        return redirect()->to('/');
    }

    public function admin()
    {
        return view('admin.login');
    }

    public function demo()
    {
        return view('demo');
    }
}
