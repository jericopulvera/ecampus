<?php

namespace App\Providers;

use App\Conversation;
use Illuminate\Support\Facades\Broadcast;
use Illuminate\Support\ServiceProvider;

class BroadcastServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Broadcast::routes();

        /*
         * Authenticate the user's personal channel...
         */

        Broadcast::channel('user.{id}', function ($user, $userId) {
            return (int) $user->id === (int) $userId;
        });

        Broadcast::channel('App.User.{id}', function ($user, $userId) {
            return (int) $user->id === (int) $userId;
        });

        Broadcast::channel('conversation.{id}', function ($user, $conversationId) {
            return $user->isInConversation(Conversation::find($conversationId));
        });

        // GROUP

        Broadcast::channel('group-presence.{id}', function ($user, $roomId) {
            if (true) { // Replace with real authorization
                return [
                    'id'   => $user->id,
                    'usn'  => $user->usn,
                    'name' => $user->name,
                ];
            }
        });

        Broadcast::channel('group.{id}', function ($user) {
            return true;
        });

        Broadcast::channel('join-requests.{id}', function ($user, $userId) {
            return true;
        });

        Broadcast::channel('group-post.{id}', function ($user) {
            return true;
        });

        // ViewPost
        Broadcast::channel('post.{id}', function ($user) {
            return true;
        });

        // NEWSFEED
        Broadcast::channel('likes.{id}', function ($user, $userId) {
            return (int) $user->id === (int) $userId;
        });

        Broadcast::channel('comments.{id}', function ($user, $userId) {
            return (int) $user->id === (int) $userId;
        });

        Broadcast::channel('posts', function ($user) {
            return true;
        });

        Broadcast::channel('likes', function ($user) {
            return true;
        });

        Broadcast::channel('unlike', function ($user) {
            return true;
        });

        Broadcast::channel('comments', function () {
            return true;
        });
    }
}
