<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Notification;

class GroupUserWasKicked extends Notification implements ShouldQueue
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
            'message' => 'You have been kicked out in <a href="/groups/'.$this->group->slug.'">'. $this->group->subject .'-'. $this->group->section .'</a> class group.',
            'noty_type' => 'error',
        ];
    }
}
