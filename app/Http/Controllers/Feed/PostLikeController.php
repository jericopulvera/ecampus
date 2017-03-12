<?php

namespace App\Http\Controllers\Feed;

use App\Events\PostLikeUpdated;
use App\Http\Controllers\Controller;
use App\Like;
use App\Notifications\PostLike;
use App\Post;
use App\User;
use Auth;
use Carbon\Carbon;

class PostLikeController extends Controller
{
    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\Response
     */
    public function store(Post $post)
    {

        // create likes
        $like = $post->likes()->firstOrNew([
            'user_id' => auth()->id(),
        ]);

        if ($like->exists) {
            return response(null, 409);
        }

        $like->save();

        // if you just like a while ago
        $previousLike = Like::withTrashed()
                            ->where('likeable_id', $post->id)
                            ->where('deleted_at', '!=', null)
                            ->where('user_id', auth()->id())
                            ->orderBy('created_at', 'desc')
                            ->first();

        if (is_null($previousLike)):
            // notify
            if (auth()->user()->id != $post->user->id):
                User::find($post->user_id)->notify(new PostLike($post, auth()->user()));
        endif; else:

            if (Carbon::now() > $previousLike->deleted_at->addSeconds(10)):
                // notify
                if (auth()->user()->id != $post->user->id):
                    User::find($post->user_id)->notify(new PostLike($post, auth()->user()));
        endif;

        endif;

        endif;

        // broadcast like
        broadcast(new PostLikeUpdated($post, auth()->user(), true))->toOthers();

        return response(1, 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy(Post $post)
    {
        $user_id = $post->user()->first()->id;

        Like::where('likeable_id', $post->id)->where('user_id', auth()->id())->delete();

        broadcast(new PostLikeUpdated($post, auth()->user(), false))->toOthers();

        return response(null, 200);
    }
}
