<?php

use App\Models\Ticket;
use App\Models\TicketReply;
use App\Models\User;
use Faker\Generator as Faker;


$factory->define(TicketReply::class, function (Faker $faker) {

    $users         = User::all();
    $tickets       = Ticket::all();
    $ticketReply = [
        [
            'user_id'     => $faker->randomElement($users)->id ,
            'ticket_id'   => $faker->randomElement($tickets)->id ,
            'description' => $faker->realText($maxNbChars = 200, $indexSize = 2),         
        ],
    ];

    return $faker->randomElement($ticketReply);
});
