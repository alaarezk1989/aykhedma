<?php

use App\Models\Company;
use Faker\Factory;
use Faker\Generator as Faker;

$factory->define(Company::class, function (Faker $faker) {
    $arabicFaker = Factory::create('ar_SA');

    $company = [

    ];

    foreach (Config::get('app.locales') as $lang => $language) {
        $faker = $lang == 'ar' ? $arabicFaker : $faker;
        $company[$lang] = [
            'name'    => $faker->word,
        ];
    }
    return $company;
});
