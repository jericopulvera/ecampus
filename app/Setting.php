<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    public $fillable = ['term_id'];

    public $timestamps = false;
    
    public function term()
    {
        return $this->belongsTo(SchoolTerm::class);
    }
}
