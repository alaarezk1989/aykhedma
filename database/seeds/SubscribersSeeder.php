<?php
use App\Models\Subscriber;
use Faker\Factory;
use Illuminate\Database\Seeder;

class SubscribersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $subscribers = factory( Subscriber::class, 5)->create();
    }
}
