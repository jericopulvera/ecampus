<?php

namespace App\Repositories;

class GradeRepository {
    public static function convertGrade($grade, $incomplete)
    {
        if ($incomplete) {
            return 'IC';
        } elseif ($grade >=  100) {
            return 'A+';
        } elseif ($grade >= 95) {
            return 'A';
        } elseif ($grade >= 90) {
            return 'A-';
        } elseif ($grade >= 85) {
            return 'B+';
        } elseif ($grade >= 80) {
            return 'B';
        } elseif ($grade >= 74) {
            return 'B-';
        } elseif ($grade >= 68) {
            return 'C+';
        } elseif ($grade >= 62) {
            return 'C';
        } elseif ($grade >= 50) {
            return 'C-';
        } else {
            return 'F';
        }
    }
}
