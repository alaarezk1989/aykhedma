<?php

use App\Models\ShippingCompany;
use Faker\Factory;
use Faker\Generator as Faker;

$factory->define(ShippingCompany::class, function (Faker $faker) {
    $arabicFaker = Factory::create('ar_SA');

    $company = [
        'phone'       => $faker->phoneNumber,
        'email'       => $faker->email,
        'address'       =>$faker->address,
        'active' => $faker->boolean,
    ];

    foreach (Config::get('app.locales') as $lang => $language) {
        $faker = $lang == 'ar' ? $arabicFaker : $faker;
        $company[$lang] = [
            'name'    => $faker->word,
        ];
    }
    return $company;
});
