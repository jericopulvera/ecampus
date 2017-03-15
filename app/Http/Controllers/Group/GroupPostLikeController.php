<?php

namespace App\Http\Controllers\Group;

use App\GroupPost;
use App\Http\Controllers\Controller;

class GroupPostLikeController extends Controller
{
    public function store($id)
    {
        $post = GroupPost::find($id);

        $check = $post->likes()->where('user_id', auth()->id())->first();

        if ($check != null) {
            $check->delete();

            return response(1, 200);
        }

        $like = $post->likes()->firstOrNew([
            'user_id' => auth()->id(),
        ]);

        $like->save();

        return response(1, 200);
    }
}
