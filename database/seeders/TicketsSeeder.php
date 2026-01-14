<?php

namespace Database\Seeders;
use App\Models\Ticket;
use Faker\Factory;
use Illuminate\Database\Seeder;
class TicketsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $tickets = Ticket::factory()->count(10)->create();
    }
}
