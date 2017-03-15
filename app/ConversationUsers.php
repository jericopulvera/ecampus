<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ConversationUsers extends Model
{
    protected $fillable = ['user_id', 'conversation_id'];

    public $timestamps = false;

    public function conversations()
    {
        return $this->belongsTo(Conversation::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

     // protected $appends = ['user'];

     // public function getUserAttribute()
     // {
     // 	return $this->user()->first();
     // }
}
