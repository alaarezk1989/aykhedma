<?php

use App\Models\Address;
use App\Models\Order;
use App\Models\User;
use App\Models\Branch;
use Faker\Generator as Faker;

$factory->define(Order::class, function (Faker $faker) {

    $user = factory(User::class)->create();
    $branch = factory(Branch::class)->create();
    $order = [
        "user_id" => $user->id,
    ];

    $order["address_id"] = factory(Address::class)->create(['user_id' => $user->id])->first()->id;

    return $order;

});


