<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Interaction extends Model
{
    protected $table = 'interactions';

    protected $fillable = [
    'user_id', 'target_id', 'affinity',
    ];

    public function user()
    {
        return $this->belongsToMany(User::class);
    }

    public function getAffinityAttribute($value)
    {
        return $value / 3;
    }
}
