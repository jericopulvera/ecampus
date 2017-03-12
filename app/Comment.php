<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    protected $fillable = ['user_id', 'body'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function post()
    {
        return $this->belongsTo(Post::class);
    }

    public function likes()
    {
        return $this->morphMany(Like::class, 'likeable');
    }

    public function scopeLatestFirst($query)
    {
        return $query->orderBy('created_at', 'desc');
    }

    /**
     *  Attributes.
     */
    protected $appends = [
        'user', 'readableDate', 'likesCount',
        'likedByCurrentUser',
    ];

    public function getUserAttribute()
    {
        return $this->user()->first();
    }

    public function getReadableDateAttribute()
    {
        return $this->created_at->toDayDateTimeString();
    }

    public function getLikesCountAttribute()
    {
        return $this->likes->count();
    }

    public function getLikedByCurrentUserAttribute()
    {
        return $this->likes->where('user_id', auth()->id())->count() === 1;
    }
}
