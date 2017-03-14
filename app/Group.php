<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Group extends Model
{
    protected $fillable = [
        'professor', 'subject', 'section', 'term_id', 'slug', 
        'dow', 'room', 'start', 'end',
    ];

    protected $appends = [
        'title', 'schedule',
    ];

    public function getScheduleAttribute()
    {
        return $this->dow;
    }

    public function getTitleAttribute()
    {
        return $this->subject.'    |    ROOM:'.$this->section.' |    ROOM:'.$this->room.'    |    SEMESTER:'.$this->semester.'    |    YEAR:'.$this->year;
    }

    public function getDowAttribute($value)
    {
        return unserialize($value);
    }

    public function getRouteKeyName()
    {
        return 'slug';
    }

    public function term()
    {
        return $this->belongsTo(SchoolTerm::class);
    }

    public function users()
    {
        return $this->belongsToMany(User::class)->withPivot('role', 'status');
    }

    public function pending()
    {
        return $this->users()->wherePivot('status', 0)->get();
    }

    public function professorId()
    {
        return $this->users()->where('role', 'admin')->first()->id;
    }

    public function inGroup()
    {
        $check = $this->users->where('id', auth()->id())->first();
        if ($check != null) {
            if ($check->pivot->status == 1) {
                return true;
            }

            return false;
        }

        return false;
    }

    public function canJoin()
    {
        $check = $this->users->where('id', auth()->id());
        if ($check->isEmpty()) {
            return true;
        }

        return false;
    }

    public function getProfessorObject()
    {
        return User::find($this->professorId());
    }
}
