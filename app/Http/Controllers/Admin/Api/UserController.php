<?php

namespace App\Http\Controllers\Admin\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\User;
use App\Grade;
use Datatables;

class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware(['admin']);
    }

    public function index()
    {
        $data = collect();
        
        $users = User::all();

        foreach ($users as $user) {
            $user->usn = $user->usn;
            $user->name = $user->name;
            $user->follower = $user->followerCount;
            $user->following = $user->followCount;
            $user->posts = $user->postCount;
            $user->action = "<a class='text-center btn btn-primary btn-xs' target='_blank' href='".url('/admin/users', $user->usn)."'><i class='fa fa-search'> View</a>";

            $data->push($user);
        }
        
        return response()->json([
            'data' => $data,
        ]);
    }

    public function professors()
    {
        $users = User::query();
        $users->where('privilege', 'Professor')->get();
        return Datatables::of($users)
            ->addColumn('action', function ($user) {
                return "<a class='text-center btn btn-primary btn-xs' target='_blank' href='".url('/admin/users', $user->usn)."'><i class='fa fa-search'> View</a>";
            })
            ->make(true);
    }

    public function students()
    {
        $users = User::query();
        $users->where('privilege', 'Student')->get();
        return Datatables::of($users)
            ->addColumn('action', function ($user) {
                return "<a class='text-center btn btn-primary btn-xs' target='_blank' href='".url('/admin/users', $user->usn)."'><i class='fa fa-search'> View</a>";
            })
            ->make(true);
    }

    public function grades(User $user)
    {
        $data = collect();
        
        $grades = Grade::where('user_Id',$user->id)->get();

        foreach ($grades as $grade) {
            $grade->usn = $grade->user->usn;
            $grade->name = $grade->user->name;
            $grade->course = $grade->user->course;
            $grade->academic_term = $grade->term->year . ' ' . $grade->term->semester . ' Trimester';

            $data->push($grade);
        }
        
        return response()->json([
            'data' => $data,
        ]);
    }

}
    
