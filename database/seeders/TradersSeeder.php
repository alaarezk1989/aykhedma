<?php

namespace Database\Seeders;
use App\Models\Trader;
use Faker\Factory;
use Illuminate\Database\Seeder;
class TradersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $traders = Trader::factory()->count(5)->create();
    }
}
