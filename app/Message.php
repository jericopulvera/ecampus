<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    protected $fillable = ['user_id', 'message'];

    public function conversation()
    {
        return $this->belongsTo(Conversation::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    protected $appends = ['showName', 'readableDate'];

    public function getShowNameAttribute()
    {
        return false;
    }

    public function getReadableDateAttribute()
    {
        return $this->created_at->toDayDateTimeString();
    }
}
