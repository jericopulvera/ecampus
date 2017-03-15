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

        $term = new Term;
        $term->start = '2017-01-18';
        $term->end = '2017-03-18';
        $term->year = '2016-2017';
        $term->semester = '3rd';
        $term->save();

        $term = new Term;
        $term->start = '2018-04-18';
        $term->end = '2018-07-18';
        $term->year = '2017-2018';
        $term->semester = '1st';
        $term->save();

        $term = new Term;
        $term->start = '2018-08-18';
        $term->end = '2018-11-18';
        $term->year = '2017-2018';
        $term->semester = '2nd';
        $term->save();

        $term = new Term;
        $term->start = '2019-01-18';
        $term->end = '2019-04-18';
        $term->year = '2017-2018';
        $term->semester = '3rd';
        $term->save();

        // $start = ;
        // $end = ;
        // for ($i = 0; $i < 10; $i++) {
        //     $term= new Term;
        //     $term>start = '2016-10-18';
        //     $term>end = '2016-12-18';
        //     $term>year = '2016-2017';
        //     $term>semester = '2nd';
        //     $term>save();
        // }

        $setting = new Setting;
        $setting->term()->associate($term->id);
        $setting->save();
    }
}
