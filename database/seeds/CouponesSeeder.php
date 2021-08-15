<?php

use Illuminate\Database\Seeder;
use App\Models\Coupon;
use Faker\Factory;

class CouponesSeeder extends Seeder
{

    public function run()
    {
        $coupones = factory(Coupon::class, 20)->create();
    }

}
