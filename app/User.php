<?php

namespace App;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Scout\Searchable;
use Storage;

class User extends Authenticatable
{
    use Notifiable, Searchable;

    protected $fillable = [
        'usn', 'username', 'name', 'email', 'course', 'password', 'privilege', 'avatar',
        'active', 'login_type',
    ];

    protected $hidden = [
        'password', 'remember_token',
    ];

    public function getRouteKeyName()
    {
        return 'USN';
    }

    public function toSearchableArray()
    {
        $array = [
            'id'      => $this->id,
            'usn'      => $this->usn,
            'username' => $this->username,
            'avatar'   => $this->image,
            'name'     => $this->name,
            'email'    => $this->email,
        ];

        return $array;
    }

    /*
     * Relationships
     */

    public function conversations()
    {
        return $this->belongsToMany(Conversation::class)->whereNull('parent_id')->orderBy('last_reply', 'desc');
    }

    public function isInConversation(Conversation $conversation)
    {
        return $this->conversations->contains($conversation);
    }

    public function posts()
    {
        return $this->hasMany(Post::class);
    }

    public function groups()
    {
        return $this->belongsToMany(Group::class)->withPivot('role', 'status');
    }

    public function likes()
    {
        return $this->hasMany(Like::class);
    }

    public function grade()
    {
        return $this->hasMany(Grade::class);
    }

    public function grades()
    {
        return $this->hasMany(GroupGrade::class);
    }

    public function interaction()
    {
        return $this->hasMany(Interaction::class);
    }

    public function subjects()
    {
        return $this->belongsToMany(Subject::class, 'grades')->withPivot('grade');
    }

    public function followers()
    {
        return $this->belongsToMany(self::class, 'follows', 'user_id', 'follower_id');
    }

    public function following()
    {
        return $this->belongsToMany(self::class, 'follows', 'follower_id', 'user_id');
    }

    /*
     * Attributes
     */

    protected $appends = [
        'image', 'followerCount', 'followCount',
        'postCount', 'likesCount', 'userGroups',
    ];

    public function getImageAttribute()
    {
        $exists = Storage::disk('local')->exists('/public/avatars/'.$this->usn.'.jpg');

        if ( ! $exists) {
            if ( ! $this->avatar) {
                return asset('/dist/img/default.jpg');
            }
            return $this->avatar;
        }

        return asset('storage/avatars/'.$this->usn.'.jpg');
    }

    public function getLikesCountAttribute()
    {
        return $this->likes()->count();
    }

    public function getFollowerCountAttribute()
    {
        return $this->followers()->count();
    }

    public function getFollowCountAttribute()
    {
        return $this->following()->count();
    }

    public function getPostCountAttribute()
    {
        return $this->posts()->count();
    }

    public function getUserGroupsAttribute()
    {
        $term_id = \App\Setting::first()->term_id;
        return $this->groups()->where('term_id', $term_id)->get();
    }

    /*
     * Query Helper
     */

    public function isNot(User $user)
    {
        return $this->id !== $user->id;
    }

    public function isFollowing(User $user)
    {
        return (bool) $this->following->where('id', $user->id)->count();
    }

    public function canFollow(User $user)
    {
        if (!$this->isNot($user)) {
            return false;
        }

        return !$this->isFollowing($user);
    }

    public function canUnfollow(User $user)
    {
        return $this->isFollowing($user);
    }
}
