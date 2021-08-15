<?php

use App\Models\Point;
use App\Models\User;
use Faker\Generator as Faker;

$factory->define(Point::class, function (Faker $faker) {

    return [
        'user_id'     => factory(User::class)->create()->id,
        'amount'    => $faker->randomDigit,
        "balance" => $faker->randomDigit,
    ];
});
