<?php

namespace Database\Seeders;
use Illuminate\Database\Seeder;
use App\Models\Discount;
use Faker\Factory;
class DiscountsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $discount = Discount::factory()->count(5)->create();
    }
}
