<?php

use App\Models\Trader;
use App\Models\User;
use Faker\Generator as Faker;


$factory->define(Trader::class, function (Faker $faker) {

$users  = User::all();

    $traders = [
        [
        
            'user_id'              => $faker->randomElement($users)->id ,
            'commercial_register'  => $faker->imageUrl(),
            'tax_card'             => $faker->imageUrl(),
            'national_id'          => $faker->randomElement([1598, 2741,9851]),
            'national_id_image'    => $faker->imageUrl(),
        ],
    ];

    return $faker->randomElement($traders);
});

