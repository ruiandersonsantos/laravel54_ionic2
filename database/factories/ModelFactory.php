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

/** @var \Illuminate\Database\Eloquent\Factory $factory */
$factory->define(\CodeFlix\Models\User::class, function (Faker\Generator $faker) {
    static $password;

    return [
        'name' => $faker->name,
        'email' => $faker->unique()->safeEmail,
        'password' => $password ?: $password = bcrypt('secret'),
        'remember_token' => str_random(10),
    ];
});

$factory->state(\CodeFlix\Models\User::class,'admin',function (Faker\Generator $faker) {
   return [
        'role' => \CodeFlix\Models\User::ROLE_ADMIN,
    ];
});

$factory->define(\CodeFlix\Models\Category::class, function (Faker\Generator $faker) {
    static $password;

    return [
        'name' => $faker->word,

    ];
});

$factory->define(\CodeFlix\Models\Serie::class, function (Faker\Generator $faker) {
    static $password;

    return [
        'title' => $faker->sentence(3),
        'description' => $faker->sentence(10),
        'thumb' => 'thumb.jpg'
    ];
});

$factory->define(\CodeFlix\Models\Video::class, function (Faker\Generator $faker) {
    static $password;

    return [
        'title' => $faker->sentence(3),
        'description' => $faker->sentence(10),
        'duration' => rand(1,30),
        'thumb' => 'thumb.jpg',
        'file' => 'file.jpg',
        'published'=> rand(0,1),
        'completed'=> 0
    ];
});

//---------------------------------//-------------------------------------------------//

$factory->define(\CodeFlix\Models\Plan::class, function (Faker\Generator $faker) {

    return [
        'name' => $faker->name,
        'description' => $faker->sentence(10),
        'value' => $faker->randomFloat(2,50,100)
    ];
});

$factory->state(\CodeFlix\Models\Plan::class,\CodeFlix\Models\Plan::DURATION_MOTHLY,function (Faker\Generator $faker) {
    return [
        'duration' => \CodeFlix\Models\Plan::DURATION_MOTHLY,
    ];
});

$factory->state(\CodeFlix\Models\Plan::class,\CodeFlix\Models\Plan::DURATION_YEARLY,function (Faker\Generator $faker) {
    return [
        'duration' => \CodeFlix\Models\Plan::DURATION_YEARLY,
    ];
});