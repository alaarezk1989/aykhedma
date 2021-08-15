<?php


use App\Models\Banner;
use App\Models\Branch;
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

$factory->define(Banner::class, function (Faker $faker) {
    $branches = Branch::all();
    $banner = [
        'type' => $faker->randomElement([1, 2]),
        'url' => $faker->url,
        'date_from' => $faker->date($format = 'Y-m-d', $max = 'now'),
        'date_to' => $faker->date($format = 'Y-m-d', $max = 'now'),
        'branch_id' => $faker->randomElement($branches)->id,
        'image' => $faker->imageUrl(),
        'active' => $faker->boolean,
    ];

    return $banner;
});
