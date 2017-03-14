<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Notification;

class GroupUserRequest extends Notification implements ShouldQueue
{
    use Queueable;

    public $group;
    public $user;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($group, $user)
    {
        $this->group = $group;
        $this->user = $user;
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
        return [
            'group' => $this->group,
            'message' => '<a href="/'.$this->user->usn.'"> Requested to join <a href="'.$this->group->slug.'">'.$this->group->slug.'</a>',
            'noty_type' => 'success',
        ];
    }
}
