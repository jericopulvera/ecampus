<?php

namespace App\Transformers;

use App\User;

class UserTransformer extends \League\Fractal\TransformerAbstract
{
    public function transform(User $user)
    {
        $scope = $this->getCurrentScope()->getIdentifier();

        return [
            'id'     => $user->id,
            'name'   => $user->name,
            'usn'    => $user->usn,
            'avatar' => $user->image,
        ];
    }
}
