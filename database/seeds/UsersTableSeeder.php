<?php

use App\Key;
use App\User;
use App\Setting;
use App\Group;
use Faker\Factory as Faker;
use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    public function run()
    {

        $faker = Faker::create();

        $follow = User::create([
           'USN'       => '1300',
           'name'      => 'May D. San Pablo',
           'username'  => 'Dean',
           'email'     => 'dean@gmail.com',
           'privilege' => 'Dean',
           'password'  => bcrypt('123123'),
           'active'    => 1,
       ]);

        $user = User::create([
           'USN'       => '1400',
           'name'      => 'Geo A. Jomoc',
           'username'  => 'Geo',
           'email'     => 'geo@gmail.com',
           'privilege' => 'Professor',
           'password'  => bcrypt('123123'),
           'active'    => 1,
       ]);

        $user->following()->attach($follow);

        $term_id = Setting::first()->term_id;

        $subjects = ['CS101', 'COMP101', 'IT401', 'IT411', 'ENGL101', 'ENGL201'];

        $sections = ['CS', 'CX', 'CZ', 'ID', 'IJ', 'IK'];

        // GEO's GROUPS
        $startCount = 8; 
        $endCount = 9;
        
        for ($i = 0; $i < count($subjects); $i++) {
            

            $start = $startCount . ':00'; 
            $end = $endCount . ':00';

            $startCount++;
            $endCount++;

            $subject = $subjects[$i];

            $section = $sections[$i];

            $slug = $subject . '-' . $section . '-' . $term_id;

            $group = Group::create([
                'professor' => $user->name,
                'subject' => $subject,
                'section' => $section,
                'term_id' => $term_id,
                'start' => $start,
                'end' => $end,
                'slug' => $slug,
                'room' => '30' . $i,
                'dow' => 'a:3:{i:0;s:1:"1";i:1;s:1:"3";i:2;s:1:"5";}'
            ]);

            $user->groups()->attach($group, ['role' => 'admin', 'status' => 1]);
        }
    
        
        // PROFESSORS
        foreach(range(1,10) as $index) {
             $create = User::create([
                'usn'       => $faker->unique()->numberBetween($min = 10000000000, $max = 99999999999),
                'name'      => $faker->unique()->name,
                'username'  => $faker->unique()->username,
                'email'     => $faker->unique()->email,
                'avatar'    => $faker->imageUrl(100, 100, 'cats'),
                'privilege' => 'Professor',
                'password'  => bcrypt('123123'),
                'active'    => 1,
            ]);

             $create->following()->attach($follow);
        }



        // STUDENTS
        $cs = 1; $it = 1; $coe = 1;
        foreach (range(1, 500) as $index) {
            $course = $faker->randomElement($array = ['IT', 'COE', 'CS']);

            if ($course == 'CS') {
                $usn = 17100000000 + $cs;
                $cs++;
            } elseif ($course == 'IT') {
                $usn = 17200000000 + $it;
                $it++;
            } elseif ($course == 'COE') {
                $usn = 17300000000 + $coe;
                $coe++;
            }

            $create = User::create([
               'usn'       => "$usn",
               'name'      => $faker->unique()->name,
               'username'  => $faker->unique()->username,
               'email'     => $faker->unique()->email,
               'avatar'    => $faker->imageUrl(100, 100, 'cats'),
               'privilege' => 'Student',
               'course'    => $course,
               'password'  => bcrypt('123123'),
               'active'    => 1,
           ]);

            $create->following()->attach($follow);
            
            $usn = $usn + 1000;

            Key::create([
              'usn'            => "$usn",
              'activation_key' => 'key'.$index,
           ]);
        }
    }
}
