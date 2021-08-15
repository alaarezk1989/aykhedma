<?php

use App\Models\Subscriber;
use Faker\Generator as Faker;

$factory->define(Subscriber::class, function (Faker $faker) {

    $subscribers = [
        [
            'active' => $faker->boolean,
            'email'  => $faker->unique()->safeEmail,
        ],       
    ];

    return $faker->randomElement($subscribers);
});


