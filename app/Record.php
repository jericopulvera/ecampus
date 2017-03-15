<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Record extends Model
{
    protected $fillable = ['user_id', 'subject', 'status', 'semester', 'year'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
