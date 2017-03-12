<?php

namespace App\Http\Controllers\Group;

use App\GroupComment;
use App\Http\Controllers\Controller;

class GroupPostCommentLikeController extends Controller
{
    public function store($id)
    {
        $comment = GroupComment::find($id);

        $check = $comment->likes()->where('user_id', auth()->id())->first();

        if ($check != null) {
            $check->delete();

            return response(1, 200);
        }

        $like = $comment->likes()->firstOrNew([
            'user_id' => auth()->id(),
        ]);

        $like->save();

        return response(1, 200);
    }
}
