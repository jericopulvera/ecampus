<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Calendar extends Model
{
    protected $table = 'calendar';

    protected $fillable = ['title', 'description', 'start', 'color'];
    protected $appends = ['month', 'day'];
    protected $dates = ['start'];
    public $timestamps = false;

    public function getMonthAttribute()
    {
        return $this->start->format('M');
    }

    public function getDayAttribute()
    {
        return $this->start->day;
    }

    public function setStartAttribute($value)
    {
        $this->attributes['start'] = Carbon::createFromFormat('Y-m-d', $value)->toDateString();
    }
}
