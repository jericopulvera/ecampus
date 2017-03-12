<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        $this->call(SchoolTermsTableSeeder::class);
        $this->call(UsersTableSeeder::class);
    }
}
