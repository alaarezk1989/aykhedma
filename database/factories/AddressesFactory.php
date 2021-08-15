<?php

use App\Models\Address;
use App\Models\User;
use App\Models\Location;
use Faker\Generator as Faker;

$factory->define(Address::class, function (Faker $faker) {
    $locations = Location::all();
    return [
        'user_id'     => factory(User::class)->create()->id,
        'location_id' => $faker->randomElement($locations)->id,
        'building'    => $faker->randomDigit,
        'street'      => $faker->text(20),
        'floor'       => $faker->randomDigit,
        'apartment'   => $faker->randomDigit,
    ];
});


