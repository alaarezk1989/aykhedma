<?php

use App\Models\Ticket;
use App\Models\User;
use App\Models\TicketReasons;
use App\Constants\UserTypes as UserTypes;
use Faker\Generator as Faker;


$factory->define(Ticket::class, function (Faker $faker) {

    $admins = User::where('type', UserTypes::ADMIN)->get();
    $users  = User::all();
    $reasons= TicketReasons::all();
    $tickets = [
        [
            'title'       => $faker->name,
            'status'      => $faker->randomElement([1, 2]),
            'description' => $faker->realText($maxNbChars = 200, $indexSize = 2),
            'user_id'     => $faker->randomElement($users)->id ,
            'ticketReason_id'     => $faker->randomElement($reasons)->id ,
            'assignee_id'     => $faker->randomElement($admins)->id ,
        ],
    ];

    return $faker->randomElement($tickets);
});
