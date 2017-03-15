<?php

namespace App;

use Laravel\Socialite\Contracts\User as ProviderUser;

class SocialAccountService
{
    public function createOrGetUser(ProviderUser $providerUser)
    {
        $account = SocialAccount::whereProvider('facebook')
            ->whereProviderUserId($providerUser->getId())
            ->first();

        if ($account) {
            return $account->user;
        } else {
            $account = new SocialAccount([
                'provider_user_id' => $providerUser->getId(),
                'provider'         => 'facebook',
            ]);

            $user = User::whereEmail($providerUser->getEmail())->first();

            if (!$user) {
                $user = User::create([
                    'usn'        => null,
                    'privilege'  => 'Student',
                    'avatar'     => $providerUser->getAvatar(),
                    'email'      => $providerUser->getEmail(),
                    'name'       => $providerUser->getName(),
                    'active'     => 0,
                    'login_type' => 'facebook',
                ]);
            }

            $account->user()->associate($user);
            $account->save();

            return $user;
        }
    }
}
