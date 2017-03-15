<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    protected $fillable = ['body', 'weight', 'time'];

    public function getWeightAttribute($value)
    {
        return ($value + $this->getLikesCountAttribute() + $this->commentValue()) / 2;
    }

    public function humanCreatedAt()
    {
        return $this->created_at->diffForHumans();
    }

    /*
     * Relationships
     */
    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    public function likes()
    {
        return $this->morphMany(Like::class, 'likeable');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /*
     * Helpers
     */
    public function userId()
    {
        return $this->user()->first()->id;
    }

    public function commentValue()
    {   
        $count = 0;
        foreach ($this->comments as $comment) {
            $count++;
        }
        return $count;
    }

    /*
     * Attributes
     */
    protected $appends = [
        'link', 'readableDate', 'likedByCurrentUser',
        'likesCount', 'lastEdited', 'user', 
        'comments', 'commentsCount',
    ];

    public function getCommentsAttribute()
    {
        $skip = $this->comments()->count() - 4;

        return $this->comments()->skip($skip)->take(4)->get();
    }

    public function getCommentsCountAttribute()
    {
        return $this->comments()->count();
    }

    public function getUserAttribute()
    {
        return $this->user()->first();
    }

    public function getLinkAttribute()
    {
        return asset('/').'/ajax/single-post/';
    }

    public function getReadableDateAttribute()
    {
        if (\Carbon\Carbon::now() > $this->created_at->addDays(4)) {
            return $this->created_at->toDayDateTimeString();
        } else {
            return $this->created_at->diffForHumans();
        }
    }

    public function getLastEditedAttribute()
    {
        if (\Carbon\Carbon::now() > $this->updated_at->addDays(4)) {
            return $this->updated_at->toDayDateTimeString();
        } else {
            return $this->updated_at->diffForHumans();
        }
    }

    public function getLikesCountAttribute()
    {
        return $this->likes->count();
    }

    public function getLikedByCurrentUserAttribute()
    {
        return $this->likes->where('user_id', auth()->id())->count() == 1;
    }
}
