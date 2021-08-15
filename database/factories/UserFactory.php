<?php

use App\Constants\UserTypes;
use App\Models\User;
use App\Models\Activity;
use Illuminate\Support\Str;
use Faker\Generator as Faker;

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| This directory should contain each of the model factory definitions for
| your application. Factories provide a convenient way to generate new
| model instances for testing / seeding your application's database.
|
*/

$factory->define(User::class, function (Faker $faker) {
    $activities = Activity::all();

    $user = [
        'first_name'        => $faker->firstName,
        'last_name'         => $faker->lastName,
        'birthdate'         => $faker->date($format = 'Y-m-d', $max = 'now'),
        'phone'             => $faker->phoneNumber,
        'image'             => $faker->imageUrl(),
        'gender'            => $faker->boolean,
        'type'              => $faker->randomElement([1, 2, 3, 4, 6]),
        'active'            => $faker->boolean,
        'email'             => $faker->unique()->safeEmail,
        'email_verified_at' => now(),
        'password'          => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi',
        'remember_token'    => Str::random(10),
    ];

    return $user;
});
