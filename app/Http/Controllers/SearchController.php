<?php

namespace App\Http\Controllers;

use App\User;

class SearchController extends Controller
{
    public function index(User $user)
    {
        if ($user->usn === auth()->user()->usn) {
            return view('search.profile', compact('user', 'schedule'));
        }

        $isFollowing = (bool) auth()->user()->following->where('id', $user->id)->first();
        $user->isFollowing = $isFollowing;

        $schedule = $user->groups()->get();

        return view('search.profile', compact('user', 'schedule'));
    }
}
