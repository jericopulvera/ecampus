<?php

namespace App\Events;

use App\Group;
use App\User;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Queue\SerializesModels;

class GroupUserWasKicked implements ShouldBroadcast
{
    use InteractsWithSockets, SerializesModels;

    public $group;

    public $user;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(Group $group, User $user)
    {
        $this->group = $group;
        $this->user = $user;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return Channel|array
     */
    public function broadcastOn()
    {
        return new PrivateChannel('group.'.$this->group->slug.'.'.$this->user->id);
    }
}
