<?php

use App\Models\Stock;
use App\Models\BranchProduct;
use Faker\Generator as Faker;

$factory->define(Stock::class, function (Faker $faker) {

    $products = BranchProduct::all();

    return [
        "product_id" => $faker->randomElement($products)->id ,
        "in_amount" => $faker->randomDigit,
        "out_amount" => $faker->randomDigit,
        "balance" => $faker->randomDigit,
        'created_by' => 1
    ];
});
