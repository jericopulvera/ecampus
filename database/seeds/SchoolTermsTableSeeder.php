<?php

use Illuminate\Database\Seeder;
use App\SchoolTerm as Term;
use App\Setting;

class SchoolTermsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $term = new Term;
        $term->start = '2016-10-18';
        $term->end = '2016-12-18';
        $term->year = '2016-2017';
        $term->semester = '2nd';
        $term->save();

        $term2 = new Term;
        $term2->start = '2017-01-18';
        $term2->end = '2017-03-18';
        $term2->year = '2016-2017';
        $term2->semester = '3rd';
        $term2->save();

        $term3 = new Term;
        $term3->start = '2017-04-18';
        $term3->end = '2016-07-18';
        $term3->year = '2017-2016';
        $term3->semester = '1st';
        $term3->save();

        $setting = new Setting;
        $setting->term()->associate($term->id);
        $setting->save();
    }
}
