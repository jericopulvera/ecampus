<?php

namespace App\Http\Controllers\Feed;

use App\Comment;
use App\Events\CommentLikeUpdated;
use App\Http\Controllers\Controller;
use App\Like;
use App\Notifications\CommentLike;
use App\Post;
use App\User;
use Auth;
use Carbon\Carbon;

class PostCommentLikeController extends Controller
{
    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\Response
     */
    public function store(Comment $comment, Post $post)
    {
        // create likes
        $like = $comment->likes()->firstOrNew([
            'user_id' => auth()->id(),
        ]);

        if ($like->exists) {
            return response(null, 409);
        }

        $like->save();

        // if you just like a while ago
        // $previousLike = Like::withTrashed()
        //                     ->where('likeable_id', $comment->id)
        //                     ->where('deleted_at', '!=', null)
        //                     ->where('user_id', auth()->id())
        //                     ->orderBy('created_at', 'desc')
        //                     ->first();

        // if (is_null($previousLike)):
        //     // notify
        //     if (auth()->user()->id != $comment->user->id):
        //         User::find($comment->user_id)->notify(new PostLike($comment, auth()->user()));
        //     endif;

        // else:

        //     if (Carbon::now() > $previousLike->deleted_at->addSeconds(10)):
        //         // notify
        //         if (auth()->user()->id != $comment->user->id):
        //             User::find($comment->user_id)->notify(new PostLike($comment, auth()->user()));
        //         endif;

        //     endif;

        // endif;

        if (auth()->user()->id != $comment->user->id):
            User::find($comment->user_id)->notify(new CommentLike($comment, auth()->user()));
        endif;

        // broadcast like
        broadcast(new CommentLikeUpdated($comment, auth()->user(), true))->toOthers();

        return response(1, 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy(Comment $comment)
    {
        $user_id = $comment->user()->first()->id;

        Like::where('likeable_id', $comment->id)->where('user_id', auth()->id())->delete();

        broadcast(new CommentLikeUpdated($comment, auth()->user(), false))->toOthers();

        return response(null, 200);
    }
}
