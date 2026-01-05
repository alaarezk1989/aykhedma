<?php

namespace Database\Factories;

use Faker\Generator as Faker;
use App\Models\Product ;
use App\Models\Unit ;
use App\Models\Category ;
use Faker\Factory as FakerFactory;
use Illuminate\Support\Facades\Config;
use Illuminate\Database\Eloquent\Factories\Factory;

class ProductFactory extends Factory
{
    protected $model = Product::class;

    public function definition(): array
    {
        $faker = $this->faker;
        $units = Unit::all() ;
    $categories = Category::all() ;
    $arabicFaker = FakerFactory::create("ar_SA");

    $product = [
        "category_id" => $faker->randomElement($categories)->id ,
        "unit_id" => $faker->randomElement($units)->id ,
        "unit_value" => $faker->randomDigit,
        "code" => $faker->postcode ,
        "manufacturer" => $faker->company ,
        "active" => $faker->boolean() ,
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
    }
}
