<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
    protected $appends = ['readableDate'];

    public function getReadableDateAttribute($value)
    {
        if (\Carbon\Carbon::now() > $value->addDays(4)) {
            return $value->toDayDateTimeString();
        } else {
            return $value->diffForHumans();
        }
    }
}
