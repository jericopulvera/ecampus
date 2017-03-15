<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Key extends Model
{
    protected $fillable = ['usn', 'used'];
    protected $table = 'activation_key';
    public $timestamps = false;
}
