<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Conversation extends Model
{
    protected $fillable = ['name', 'image'];

    public function messages()
    {
        return $this->hasMany(Message::class);
    }

    public function participants()
    {
        return $this->hasMany(ConversationUsers::class);
    }

    protected $appends = ['readableDate', 'latestMessages', 'participants', 'image', 'conversationName'];

    public function getImageAttribute()
    {
        if ($this->participants()->count() === 2) {
            foreach ($this->participants as $participant) {
                if ($participant->user_id !== auth()->id()) {
                    return $participant->user()->first()->image;
                }
            }

            return auth()->user()->image;
        } else {
            return asset('dist/img/group-default.jpg');
        }
    }

    public function getReadableDateAttribute()
    {
        if (\Carbon\Carbon::now() > $this->created_at->addDays(4)) {
            return $this->created_at->toDayDateTimeString();
        } else {
            return $this->created_at->diffForHumans();
        }
    }

    public function getConversationNameAttribute()
    {
        if ($this->participants()->count() === 2) {
            foreach ($this->participants as $participant) {
                if ($participant->user_id !== auth()->id()) {
                    $p = $participant->with('user')->where('user_id', $participant->user_id)->first();

                    return $p->user()->first()->name;
                }
            }

            return auth()->user()->name;
        } else {
            return $this->name;
        }
    }

    public function getLatestMessagesAttribute()
    {
        return Message::with('user')->where('conversation_id', $this->id)->orderBy('created_at', 'desc')->take(20)->get();
    }

    public function getParticipantsAttribute()
    {
        return ConversationUsers::where('conversation_id', $this->id)->get();
    }
}
