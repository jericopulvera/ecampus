<?php

namespace App\Http\Controllers;

class NotificationController extends Controller
{
    public function index()
    {
        auth()->user()->unreadNotifications
            ->where('type', '!=', 'App\Notifications\UserMessage')
            ->markAsRead();

        return view('notifications-page');
    }

    public function getAll()
    {
        return auth()->user()->notifications;
    }

    public function getUnread()
    {
        return auth()->user()->unreadNotifications
            ->where('type', '!=', 'App\Notifications\UserMessage');
    }
}
