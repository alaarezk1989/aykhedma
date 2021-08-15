<?php
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
        $tickets = factory( Ticket::class, 10)->create();
    }
}
