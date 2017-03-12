<?php

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| Here you may define all of your model factories. Model factories give
| you a convenient way to create models for testing and seeding your
| database. Just tell the factory how a default model should look.
|
*/

$factory->define(App\User::class, function (Faker\Generator $faker) {
    static $password;

    return [
        'usn'            => $str_random(10),
        'email'          => $faker->safeEmail,
        'password'       => $password ?: $password = bcrypt('secret'),
        'remember_token' => str_random(10),
    ];
});

$factory->define(App\Key::class, function (Faker\Generator $faker) {
    return [
        'activation_key' => str_random(5),
    ];
});

$autoIncrement = autoIncrement();

$factory->define(App\Post::class, function (Faker\Generator $faker) use ($autoIncrement) {
    $autoIncrement->next();

    return [
        'user_id' => 1,
        'body'    => $faker->sentences(5, true),
        'weight'  => $autoIncrement->current(),
        'time'    => $autoIncrement->current(),
    ];
});

$factory->define(App\Comment::class, function (Faker\Generator $faker) use ($autoIncrement) {
    return [
        'body'    => $faker->sentences(3, true),
        'post_id' => $autoIncrement->current(),
    ];
});

function autoIncrement()
{
    for ($i = 1; $i < 999999; $i++) {
        yield $i;
    }
}
