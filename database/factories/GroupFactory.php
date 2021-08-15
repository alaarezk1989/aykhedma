<?php

use Faker\Generator as Faker;
use App\Models\Group;
use Faker\Factory;

$factory->define(Group::class, function (Faker $faker) {
    $arabicFaker = Factory::create('ar_SA');

    $groups = [
        'active' => $faker->boolean,
    ];
    foreach (Config::get('app.locales') as $lang => $language) {
        $tempFaker = $lang == 'ar' ? $arabicFaker : $faker;
        $groups[$lang] = ['name' => $tempFaker->word];
    }
    return $groups;
});
