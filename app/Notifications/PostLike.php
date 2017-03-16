<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Notification;

class PostLike extends Notification implements ShouldQueue
{
    use Queueable;

    public $post;

    public $user;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($post, $user)
    {
        $this->post = $post;
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
        $body = str_limit($this->post->body, 15);
        $message = sprintf('<a href="/%s">%s</a> likes your post <a href="/posts/%s">%s</a>,', $this->user->usn, $this->user->name, $this->post->id, $body);
        return [
            'user' => $this->user,
            'post' => $this->post,
            'message' => $message,
        ];
    }
}
