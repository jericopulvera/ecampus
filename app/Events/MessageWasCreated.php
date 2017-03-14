<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Queue\SerializesModels;

class MessageWasCreated implements ShouldBroadcastNow
{
    use InteractsWithSockets, SerializesModels;

    public $message;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct($message)
    {
        $this->message = $message;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return Channel|array
     */
    public function broadcastOn()
    {
        return [
            new PresenceChannel('conversation.'.$this->message->conversation_id),
            new PrivateChannel('conversation.'.$this->message->conversation_id),
            // notify users that is in conversation using foreach or better.
        ];
    }

    public function broadcastWith()
    {
        return [
            'message' => array_merge($this->message->toArray(), [
                'user' => $this->message->user,
            ]),
        ];
    }
}
