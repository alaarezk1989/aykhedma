<?php

namespace Database\Seeders;
use Illuminate\Database\Seeder;
use App\Models\Coupon;
use Faker\Factory;
class CouponesSeeder extends Seeder
{
    public function run()
    {
        $coupones = Coupon::factory()->count(20)->create();
    }
}
