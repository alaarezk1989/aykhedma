<?php

namespace Database\Seeders;
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
        $ticketReasons= TicketReasons::factory()->count(5)->create();
    }
}
