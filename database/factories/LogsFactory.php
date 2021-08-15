<?php

use App\Models\Log;
use App\Models\User;

use App\Constants\ObjectTypes as ObjectTypes;
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

/** @var TYPE_NAME $factory */
$factory->define(Log::class, function (Faker $faker) {

    $user = User::query()->inRandomOrder()->first();

    $logs = [
        'user_id' => $user->id,
        'object_id' => $faker->randomElement([1, 2, 3, 4, 5, 6, 7, 8, 9]),
        'object_type' => $faker->randomElement(ObjectTypes::getKeyList()),
        'message' => $faker->text(25),
        'user' => $user->toArray()
    ];

    return $logs;
});
