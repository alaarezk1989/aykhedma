<?php

/* @var $factory \Illuminate\Database\Eloquent\Factory */

use App\Models\Setting;
use Faker\Generator as Faker;
use Faker\Factory;

$factory->define(Setting::class, function (Faker $faker) {
    $arabicFaker = Factory::create('ar_SA');

    $setting = [
        "key" => "key #" . random_int(2, 99),
        'active'    => $faker->boolean,
    ];

    foreach (Config::get('app.locales') as $lang => $language) {
        $faker = $lang == 'ar' ? $arabicFaker : $faker;
        $setting[$lang] = [
            'value'    => $faker->text(20),
        ];
    }

    return $setting;
});
