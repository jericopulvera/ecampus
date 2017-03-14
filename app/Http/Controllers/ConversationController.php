<?php

namespace App\Http\Controllers;

use App\Conversation;
use App\ConversationUsers;
use App\Events\MessageWasCreated;
use App\Message;
use App\User;
use Illuminate\Http\Request;

class ConversationController extends Controller
{
    public function getConversations()
    {
        $conversationsId = ConversationUsers::where('user_id', auth()->id())->pluck('conversation_id');

        $conversations = Conversation::whereIn('id', $conversationsId)->get();

        return $conversations;
    }

    public function showConversation($id)
    {
        $conversation = Conversation::find($id);

        return $conversation;
    }

    public function createConversation(Request $request)
    {
        // Get all recipient
        $users = $request->recipient;

        // Get Recipients ID's
        foreach ($users as $user) {
            $userIds[] = $user['objectID'];
        }

        // Count recipients.
        $length = count($users);

        // Check IF Request has only 1 recipient
        if ($length == 1) {
            // Get auth user conversations
             $conversations = Conversation::all();
            $myConversations = [];
            foreach ($conversations as $c) {
                $myConversations[] = $c->participants()->where('user_id', auth()->id())->get();
            }

             // loop myConversations check if the conversation has this users.
            foreach ($myConversations as $participants) {
                $check = $participants->count() === 2;
                if ($check) {
                    $notGroupMessage = $participants->whereIn('user_id', $userIds)->first();

                    // If notGroupMessage is not null return conversation.
                    if ($notGroupMessage != null) {
                        $conversation = Conversation::find($notGroupMessage->conversation_id);

                        return ['conversation' => $conversation, 'exists' => true];
                    }
                }
            }
        }

        // Add Auth user to conversation.
        $users[] = ['usn' => auth()->user()->usn, 'name' => auth()->user()->name];

        // If more than 1 user
        if ($length > 1):
            $name = $request->name; else:
            $name = null;
        endif;

        // Create Conversation
        $conversation = Conversation::create([
            'name' => $name,
        ]);

        // First Message
        $conversation->messages()->create([
            'user_id' => auth()->id(),
            'message' => $request->message,
        ]);

        // Create Conversation Users List
        foreach ($users as $user) {
            $id = User::where('usn', $user['usn'])->first()->id;
            $conversation->participants()->create([
                'conversation_id' => $conversation->id,
                'user_id'         => $id,
            ]);
        }

        // notify added in conversation

        return $conversation;
    }

    public function sendMessage(Request $request)
    {
        $message = Conversation::find($request->id)->messages()->create([
            'user_id' => auth()->id(),
            'message' => $request->message,
        ]);

        $data = $message->where('id', $message->id)->with('user')->first();

        broadcast(new MessageWasCreated($data))
            >onConnection('sync')
            ->toOthers();

        return $data;
    }
}
