<?php

namespace App\Events;

use App\Group;
use App\User;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Queue\SerializesModels;

class JoinGroupRequested implements ShouldBroadcast
{
    use InteractsWithSockets, SerializesModels;

    public $group;

    public $user;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct($group_id, User $user)
    {
        $this->group = Group::find($group_id)->first();
        $this->user = $user;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return Channel|array
     */
    public function broadcastOn()
    {
        return new PrivateChannel('join-requests.'.$this->group->slug);
    }
}
