<?php

use App\Models\Coupon;
use App\Models\Vendor;
use App\Models\Branch;
use App\Models\Activity ;
use Faker\Factory;
use Faker\Generator as Faker;

    $factory->define( Coupon::class, function (Faker $faker) {

    $vendors = Vendor::all();
    $branches = Branch::all();
    $activities = Activity::all();

    $coupones = [
        'vendor_id'           => $faker->randomElement($vendors)->id ,
        'branch_id'           => $faker->randomElement($branches)->id ,
        'activity_id'         => $faker->randomElement($activities)->id,
        'minimum_order_price' => $faker->randomElement([100,200,300,400,500]),
        'code'                => $faker->postcode,
        'active'              => $faker->boolean,
        'type'                => $faker->randomElement([1,2]),
        'value'               => $faker-> randomElement([1,2,3,4,5,6,7,8,9,10]),
        'expire_date'         => $faker->date(),
    ];
    return $coupones;
});
