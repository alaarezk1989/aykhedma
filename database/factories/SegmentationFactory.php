<?php

use App\Models\Segmentation;
use App\Models\Location;
use App\Models\Company;
use App\Models\Vendor;
use App\Models\Branch;
use App\Models\Activity;
use Faker\Factory;
use Faker\Generator as Faker;

$factory->define(Segmentation::class, function (Faker $faker) {
    $arabicFaker = Factory::create('ar_SA');

    $locations = Location::all();
    $companies = Company::all();

    $segmentation = [
        'class' => $faker->randomElement([1, 2, 3]),
        'location_id' => $faker->randomElement($locations)->id ,
        'company_id' => $faker->randomElement($companies)->id ,
    ];

    foreach (Config::get('app.locales') as $lang => $language) {
        $faker = $lang == 'ar' ? $arabicFaker : $faker;
        $segmentation[$lang] = [
            'title'    => $faker->name,
        ];
    }

    return $segmentation;
});
