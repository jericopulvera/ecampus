<?php

namespace App\Events;

use App\Comment;
use App\User;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Queue\SerializesModels;

class CommentWasCreated implements ShouldBroadcast
{
    use InteractsWithSockets;

    public $comment;

    public $user;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(Comment $comment, User $user)
    {
        $this->comment = $comment;
        $this->user = $user;
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
        ];
    }
}
