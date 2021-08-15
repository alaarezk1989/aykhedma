<?php

use App\Models\UserDevice;
use App\Models\User;
use Faker\Factory;
use Faker\Generator as Faker;

    $factory->define(UserDevice::class, function (Faker $faker) {
        $users = User::all();
        $userDevice = [
            'user_id' => $faker->randomElement($users)->id,
            'model' => $faker->text(20),
            'os' => $faker->randomElement([1, 2, 3]),
            'token' => str_random(60),
        ];

        return $userDevice;
    });
