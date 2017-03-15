<?php

namespace App\Http\Controllers\Api\Group;

use App\Http\Controllers\Controller;
use App\Events\GroupPostWasCreated;
use App\Group;
use App\GroupComment;
use App\GroupPost;
use App\User;
use Auth;
use Illuminate\Http\Request;

class GroupPostController extends Controller
{
    public function index(Group $group)
    {
        return GroupPost::where('group_id', $group->id)->orderBy('created_at', 'dsc')->paginate(15);
    }

    public function store(Request $request, Group $group)
    {
        $check = Auth::user()->groups()->where('group_id', $group->id)->where('user_id', Auth::id())->first();

        if ($check != null) {
            $post = GroupPost::create([
                'group_id' => $group->id,
                'user_id'  => Auth::id(),
                'body'     => $request->body,
            ]);

            return $post;
        }

        return response(null, 403);
    }

    public function destroy($id)
    {
        $post = GroupPost::find($id);
        $post->delete();
    }

}
