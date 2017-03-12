<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Notification;

class CommentLike extends Notification implements ShouldQueue
{
    use Queueable;

    public $comment;

    public $user;

    public $post;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($comment, $post, $user)
    {
        $this->comment = $comment;
        $this->user = $user;
        $this->post = $post;
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
            'user'    => $this->user,
            'comment' => $this->comment,
            'post'    => $this->post,
        ];
    }
}
