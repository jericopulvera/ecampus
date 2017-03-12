<?php

namespace App\Http\Controllers\Group;

use App\GroupComment;
use App\GroupPost;
use App\Http\Controllers\Controller;
use Auth;
use Illuminate\Http\Request;

class GroupPostCommentController extends Controller
{
    public function store(Request $request, $id)
    {
        $post = GroupPost::find($id);

        $check = Auth::user()->groups()->where('group_id', $post->group_id)->where('user_id', Auth::id())->first();

        if ($check != null) {
            $comment = $post->groupComments()->create([
                'user_id' => Auth::id(),
                'body'    => $request->body,
            ]);

            return $comment;
        }
    }

    public function destroy($id, $group_id)
    {
        $check = Auth::user()->groups()->where('group_id', $group_id)->where('user_id', Auth::id())->first();
        if ($check != null) {
            $comment = GroupComment::find($id);
            $comment->delete();

            return $comment;
        }

        return response(null, 403);
    }
}
