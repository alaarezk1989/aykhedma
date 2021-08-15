<?php

use App\Models\Branch;
use App\Models\Vendor;
use App\Constants\BranchTypes  ;
use Faker\Factory;
use Faker\Generator as Faker;

$factory->define(Branch::class, function (Faker $faker) {
    $arabicFaker = Factory::create('ar_SA');

    $branch = [
        "vendor_id" => factory(Vendor::class)->create()->id,
        'lat'       => $faker->latitude,
        'lng'       => $faker->longitude,
        'active'    => $faker->boolean,
        'type'    => $faker->randomElement(BranchTypes::getTypeValue()),
    ];

    foreach (Config::get('app.locales') as $lang => $language) {
        $faker = $lang == 'ar' ? $arabicFaker : $faker;
        $branch[$lang] = [
            'name'    => $faker->name,
            'address' => $faker->country."/".$faker->city,
        ];
    }

    return $branch;

});


