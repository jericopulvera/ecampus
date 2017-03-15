<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SchoolTerm extends Model
{
    public $timestamps = false;
    
    protected $dates = [
        'start', 'end'
    ];

    public function setting()
    {
        return $this->hasOne(Setting::class);
    }

    public function groups()
    {
        return $this->hasMany(Group::class);
    }
}
