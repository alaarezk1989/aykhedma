<?php

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
        $discount = factory( Discount::class, 5)->create();
    }
}
