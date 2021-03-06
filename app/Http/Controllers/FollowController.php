<?php

namespace App\Http\Controllers;

use App\User;

class FollowController extends Controller
{
    public function suggestedUsers()
    {
        $users = User::all();

        $users = $users->random(5);

        $suggestedUsers = collect([]);

        foreach ($users as $user) {
            $check = auth()->user()->canFollow($user);
            if ($check) {
                $suggestedUsers->push($user);
            }
        }

        return $suggestedUsers->random($suggestedUsers->count());
    }

    public function followUser(User $user)
    {
        if (auth()->user()->canFollow($user)) {
            $user->notify(new \App\Notifications\FollowUser(auth()->user(), true));
            auth()->user()->following()->attach($user);
        } else {
            $user->notify(new \App\Notifications\FollowUser(auth()->user(), false));
            auth()->user()->following()->detach($user);
        }
    }
}
