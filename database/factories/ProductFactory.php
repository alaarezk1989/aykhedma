<?php

use Faker\Generator as Faker;
use App\Models\Product ;
use App\Models\Unit ;
use App\Models\Category ;
use Faker\Factory;

$factory->define(Product::class, function (Faker $faker) {
    $units = Unit::all() ;
    $categories = Category::all() ;
    $arabicFaker = Factory::create("ar_SA");

    $product = [
        "category_id" => $faker->randomElement($categories)->id ,
        "unit_id" => $faker->randomElement($units)->id ,
        "unit_value" => $faker->randomDigit,
        "code" => $faker->postcode ,
        "manufacturer" => $faker->company ,
        "active" => $faker->boolean ,
    ];

    foreach (Config::get('app.locales') as $lang => $language) {
        $tempFaker = $lang == 'ar' ? $arabicFaker : $faker;
        $product[$lang] = [
            "name" => $tempFaker->text(20),
            "description" => $tempFaker->text(250),
            "meta_title" => $tempFaker->text(50) ,
            "meta_description" => $tempFaker->text(500),
            "meta_keyword" => implode(" ",$tempFaker->words($tempFaker->randomDigit)),
        ];
    }

    return $product ;
});
