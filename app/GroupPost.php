<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class GroupPost extends Model
{
    protected $table = 'group_post';
    protected $fillable = ['user_id', 'group_id', 'body'];

    public function likes()
    {
        return $this->morphMany(Like::class, 'likeable');
    }

    public function groupComments()
    {
        return $this->hasMany(GroupComment::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function group()
    {
        return $this->belongsTo(Group::class);
    }

    protected $appends = [
        'readableDate', 'commentCount',
        'comments', 'likedByCurrentUser',
        'likesCount', 'user',
    ];

    public function getUserAttribute()
    {
        return $this->user()->first();
    }

    public function getReadableDateAttribute()
    {
        return $this->created_at->diffForHumans();

        return $this->created_at->toDayDateTimeString();
    }

    public function getCommentCountAttribute()
    {
        return $this->groupComments()->count();
        // return Comment::where('post_id', $this->id)->count();
    }

    public function getCommentsAttribute()
    {
        return $this->groupComments()->get();
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
