<?php
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
        $ticketReply = factory( TicketReply::class, 10)->create();
    }
}
