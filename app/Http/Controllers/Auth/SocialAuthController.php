<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Key;
use App\SocialAccountService;
use App\User;
use Illuminate\Http\Request;
use Socialite;

class SocialAuthController extends Controller
{
    /**
     * Redirect the user to the GitHub authentication page.
     *
     * @return Response
     */
    public function redirectToProvider()
    {
        return Socialite::driver('facebook')->redirect();
    }

    /**
     * Obtain the user information from GitHub.
     *
     * @return Response
     */
    public function handleProviderCallback(SocialAccountService $service)
    {
        $user = $service->createOrGetUser(Socialite::driver('facebook')->user());

        if ($user->active == 0) {
            return redirect()->back()->with('facebook-id', $user->id);
        }

        auth()->login($user);

        return redirect()->to('/');
    }

    public function createAccount(Request $request)
    {
        $this->validate(request(), [
            'usn'      => 'required|max:11|min:11',
            'username' => 'required|min:3|max:20|alpha|unique:users,username',
            'key'      => 'required|min:4',
        ]);

        $check = Key::where('usn', request('usn'))->where('activation_key', request('key'))->where('used', 0)->first();

        if ($check == null) {
            return 1;
        }

        $check->update(['used' => 1]);

        User::find(request('id'))->update([
            'usn'      => request('usn'),
            'username' => request('username'),
            'course'   => request('course'),
            'active'   => 1,
        ]);

        $user = User::find(request('id'));

        auth()->login($user);

        return 0;
    }
}
