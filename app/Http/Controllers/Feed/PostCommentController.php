<?php

namespace App\Http\Controllers\Feed;

use App\Comment;
use App\Events\CommentWasCreated;
use App\Http\Controllers\Controller;
use App\Notifications\PostComment;
use App\Post;
use App\User;
use Illuminate\Http\Request;

class PostCommentController extends Controller
{
    public function index(Post $post, $counter)
    {
        $count = $post->comments()->count();

        if ($count < 30):
            $posts = $post->comments()->latestFirst()->skip(4)->take($count - 4)->get(); else:

            $skip = -30;
        if ($counter === 1):
                $posts = $post->comments()->latestFirst()->skip($skip)->take(30)->get(); else:
                $total = $counter * 30;
        $posts = $post->comments()->skip($total)->take(30)->get();
        endif;

        endif;

        return $posts;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\Response
     */
    public function store(Post $post)
    {
        // create comment
        $comment = $post->comments()->create([
            'user_id' => auth()->id(),
            'body'    => request('body'),
        ]);

        // Notify
        if (auth()->user()->id != $post->user->id):
            User::find($post->user_id)->notify(new PostComment($comment, auth()->user(), $post));
        endif;

        // broadcast
        broadcast(new CommentWasCreated($comment, auth()->user()))->toOthers();

        return $comment;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int                      $id
     *
     * @return \Illuminate\Http\Response
     */
    public function update(Comment $comment)
    {
        $comment->update(['body' => request('body')]);
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
        $comment->delete();
    }

    public function updateTime(Comment $comment)
    {
        return $comment;
    }
}
