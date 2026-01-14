<?php

namespace Database\Seeders;
use App\Models\TicketReply;
use Faker\Factory;
use Illuminate\Database\Seeder;
class TicketReplySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $ticketReply = TicketReply::factory()->count(10)->create();
    }
}
