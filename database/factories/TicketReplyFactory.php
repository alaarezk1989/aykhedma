<?php

namespace Database\Factories;

use App\Models\Ticket;
use App\Models\TicketReply;
use App\Models\User;
use Faker\Generator as Faker;
use Illuminate\Database\Eloquent\Factories\Factory;

class TicketReplyFactory extends Factory
{
    protected $model = TicketReply::class;

    public function definition(): array
    {
        $faker = $this->faker;
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
    }
}
