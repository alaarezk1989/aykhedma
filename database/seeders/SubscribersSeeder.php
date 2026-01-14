<?php

namespace Database\Seeders;
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
        $subscribers = Subscriber::factory()->count(5)->create();
    }
}
