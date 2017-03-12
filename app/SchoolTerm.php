<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SchoolTerm extends Model
{
    public $timestamps = false;
    
    public function setting()
    {
        return $this->hasOne(Setting::class);
    }

    public function groups()
    {
        return $this->hasMany(Group::class);
    }
}
