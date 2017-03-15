<?php

namespace App\Http\Controllers\Admin\Api;

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
        $users = User::query();
        return Datatables::of($users)
            ->addColumn('action', function ($user) {
                return "<a class='text-center' href='".url('/admin/users', $user->usn)."'>View</a>";
            })
            ->make(true);
    }

    public function professors()
    {
        $users = User::query();
        $users->where('privilege', 'Professor')->get();
        return Datatables::of($users)
            ->addColumn('action', function ($user) {
                return "<a class='text-center' href='".url('/admin/users', $user->usn)."'>View</a>";
            })
            ->make(true);
    }

    public function students()
    {
        $users = User::query();
        $users->where('privilege', 'Student')->get();
        return Datatables::of($users)
            ->addColumn('action', function ($user) {
                return "<a class='text-center' href='".url('/admin/users', $user->usn)."'>View</a>";
            })
            ->make(true);
    }

}
    
