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

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($comment, $user)
    {
        $this->comment = $comment;
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
        $body = str_limit($this->comment->body, 15);
        $message = sprintf('<a href="/%s">%s</a> likes your comment <a href="/comments/%s">%s</a>,', $this->user->usn, $this->user->name, $this->comment->id, $body);
        return [
            'user' => $this->user,
            'comment' => $this->comment,
            'message' => $message,
        ];
    }
}
