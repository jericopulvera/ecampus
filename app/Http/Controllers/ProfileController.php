<?php

namespace App\Http\Controllers;

use App\User;

class ProfileController extends Controller
{
    public function updateName()
    {
        $this->validate(request(), [
            'name' => "required|min:3|max:32|regex:/^[\\p{L} .'-]+$/",
        ]);

        auth()->user()->update([
            'name' => request('name'),
        ]);

        return request('name');
    }
}
