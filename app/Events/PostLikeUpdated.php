<?php

namespace App\Events;

use App\Post;
use App\User;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Queue\SerializesModels;

class PostLikeUpdated implements ShouldBroadcast
{
    use InteractsWithSockets, SerializesModels;

    public $post;

    public $user;

    public $like;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(Post $post, User $user, $bool)
    {
        $this->post = $post;
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
        return new PrivateChannel('post.'.$this->post->id);
    }

    public function broadcastWith()
    {
        return [
            'post' => array_merge($this->post->toArray(), [
                'user' => $this->post->user,
            ]),
            'user' => $this->user,
            'like' => $this->like,
        ];
    }
}
