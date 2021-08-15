<?php

use App\Models\TicketReasons;
use Faker\Generator as Faker;


$factory->define(TicketReasons::class, function (Faker $faker) {

    $ticketCategories = ['one','two','three'];
    $index = array_rand($ticketCategories) ;

    $ticketReasons = [
        [
            'title'   => $ticketCategories[$index] ,
        ],
    ];

    return $faker->randomElement($ticketReasons);
});
