<?php

    use App\Models\Category;
    use Faker\Generator as Faker;

    $factory->define( Category::class, function (Faker $faker) {
        return [
            'active' => $faker->boolean,
            'en'=> ['name' => $faker->city],
            'ar'=> ['name' => $faker->city],
        ];
    });
