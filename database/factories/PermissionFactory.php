<?php

use Faker\Generator as Faker;
use App\Models\Permission;
use Faker\Factory;

$factory->define(Permission::class, function (Faker $faker) {

    $arabicFaker = Factory::create("ar_SA");

    $permission = [
        "identifier" => str_replace(' ', '.', $faker->word),
        "active" => $faker->boolean,
    ];

    foreach (Config::get('app.locales') as $lang => $language) {
        $tempFaker = $lang == 'ar' ? $arabicFaker : $faker;
        $permission [$lang] = [
            "name" => $tempFaker->text(20)
        ];
    }

    return $permission;
});
