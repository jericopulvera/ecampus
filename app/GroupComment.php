<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class GroupComment extends Model
{
    protected $table = 'group_comment';
    protected $fillable = ['user_id', 'post_id', 'body'];

    public function notifies()
    {
        return $this->morphMany(Notification::class, 'notifiable');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function groupPost()
    {
        return $this->belongsTo(GroupPost::class);
    }

    public function likes()
    {
        return $this->morphMany(Like::class, 'likeable');
    }

    /**
     *  Attributes.
     */
    protected $appends = [
            'readableDate', 'name', 'postUserId', 'groupId', 'image',
            'likedByCurrentUser', 'likesCount',
        ];

    public function getReadableDateAttribute()
    {
        return $this->created_at->toDayDateTimeString();
    }

    public function getImageAttribute()
    {
        return $this->user->image;
    }

    public function getNameAttribute()
    {
        return $this->user()->first()->name;
    }

    public function getGroupIdAttribute()
    {
        return $this->groupPost()->first()->group_id;
    }

    public function getPostUserIdAttribute()
    {
        return $this->groupPost()->first()->user()->first()->id;
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
