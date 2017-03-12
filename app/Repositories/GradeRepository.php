<?php

namespace App\Repositories;

class GradeRepository {
    public static function convertGrade($grade, $incomplete)
    {
        if ($incomplete) {
            return 'IC';
        } elseif ($grade >= 96 && $grade <=100) {
            return 'A+';
        } elseif ($grade >=91 && $grade <=95) {
            return 'A';
        } elseif ($grade >=86 && $grade <=90) {
            return 'A-';
        } elseif ($grade >=81 && $grade <=85) {
            return 'B+';
        } elseif ($grade >=75 && $grade <=80) {
            return 'B';
        } elseif ($grade >=69 && $grade <=74) {
            return 'B-';
        } elseif ($grade >=63 && $grade <=68) {
            return 'C+';
        } elseif ($grade >=57 && $grade <=62) {
            return 'C';
        } elseif ($grade >=50 && $grade <=56) {
            return 'C-';
        } else {
            return 'F';
        }
    }
}
