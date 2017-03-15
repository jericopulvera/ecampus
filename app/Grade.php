<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Grade extends Model
{
    protected $fillable = [
        'user_id', 'prof_id', 'term_id',
        'subject', 'section', 'grade',
        'mark'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function prof()
    {
        return $this->belongsTo(User::class);
    }

    public function term()
    {
        return $this->belongsTo(SchoolTerm::class);
    }
}
