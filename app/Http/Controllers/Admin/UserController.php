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

}
    
