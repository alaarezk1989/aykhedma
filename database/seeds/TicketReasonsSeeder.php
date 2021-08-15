<?php

use App\Models\TicketReasons;
use Faker\Factory;
use Illuminate\Database\Seeder;

class TicketReasonsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $ticketReasons= factory( TicketReasons::class, 5)->create();
    }
}
