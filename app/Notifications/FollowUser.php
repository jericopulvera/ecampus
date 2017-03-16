<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Notification;

class FollowUser extends Notification implements ShouldQueue
{
    use Queueable;

    public $user;
    public $follow;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($user, $follow)
    {
        $this->user = $user;
        $this->follow = $follow;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param mixed $notifiable
     *
     * @return array
     */
    public function via($notifiable)
    {
        return ['broadcast', 'database'];
    }

    /**
     * Get the array representation of the notification.
     *
     * @param mixed $notifiable
     *
     * @return array
     */
    public function toArray($notifiable)
    {
        $message = sprintf('<a href="/%s">%s</a> ', $this->user->usn, $this->user->name);     
        if ($this->follow) { $message .= "followed you"; } else { $message .= "unfollowed you"; }
        return [
            'user'   => $this->user,
            'message' => $message,
        ];
    }
}
