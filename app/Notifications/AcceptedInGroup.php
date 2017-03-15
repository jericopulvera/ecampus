<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Notification;

class AcceptedInGroup extends Notification implements ShouldQueue
{
    use Queueable;

    public $group;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($group)
    {
        $this->group = $group;
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
            'message' => 'You are now a student in <a href="/groups/'.$this->group->slug.'">'. $this->group->subject .'-'. $this->group->section .'</a> class group.',
            'noty_type' => 'success',
        ];
    }
}
