<?php

namespace App\Events;

use App\Comment;
use App\User;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Queue\SerializesModels;

class CommentLikeUpdated implements ShouldBroadcast
{
    use InteractsWithSockets, SerializesModels;

    public $comment;

    public $user;

    public $like;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(Comment $comment, User $user, $bool)
    {
        $this->comment = $comment;
        $this->user = $user;
        $this->like = $bool;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return Channel|array
     */
    public function broadcastOn()
    {
        return new PrivateChannel('post.'.$this->comment->post_id);
    }

    public function broadcastWith()
    {
        return [
            'comment' => array_merge($this->comment->toArray(), [
                'user' => $this->comment->user,
            ]),
            'user' => $this->user,
            'like' => $this->like,
        ];
    }
}
