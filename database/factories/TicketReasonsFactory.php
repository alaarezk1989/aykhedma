<?php

namespace Database\Factories;

use App\Models\TicketReasons;
use Faker\Generator as Faker;
use Illuminate\Database\Eloquent\Factories\Factory;

class TicketReasonsFactory extends Factory
{
    protected $model = TicketReasons::class;

    public function definition(): array
    {
        $faker = $this->faker;
        $ticketCategories = ['one','two','three'];
    $index = array_rand($ticketCategories) ;

    $ticketReasons = [
        [
            'title'   => $ticketCategories[$index] ,
        ],
    ];

    return $faker->randomElement($ticketReasons);
    }
}
