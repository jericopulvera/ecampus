<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class GroupGrade extends Model
{
    protected $table = 'group_grade';
    protected $fillable = ['user_id', 'group_id', 'week', 'class_standing', 'quiz_one', 'quiz_two', 'exam'];
    public $timestamps = false;

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function group()
    {
        return $this->belongsTo(Group::class);
    }

    public function getQuizTwoAttribute($value)
    {
        return (float) $value;
    }

    public function getQuizOneAttribute($value)
    {
        return (float) $value;
    }

    public function getClassStandingAttribute($value)
    {
        return (float) $value;
    }

    public function getExamAttribute($value)
    {
        return (float) $value;
    }

    protected $appends = ['totalGrade'];

    public function getTotalGradeAttribute()
    {
    }
}
