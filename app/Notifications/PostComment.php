<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Notification;

class PostComment extends Notification implements ShouldQueue
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
    public function __construct($comment, $user, $post)
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
        $body = str_limit($this->post->body, 15);

        $message = sprintf('<a href="/%s">%s</a> replied on your post <a href="/posts/%s">%s</a>,', $this->user->usn, $this->user->name, $this->post->id, $body);

        return [
            'user' => $this->user,
            'post' => $this->post,
            'message' => $message,
        ];
    }
}
