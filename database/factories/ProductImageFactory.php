<?php

use Faker\Generator as Faker;
use App\Models\ProductImage ;
$factory->define(ProductImage::class, function (Faker $faker) {
    return [
        "image" => $faker->imageUrl()
    ];
});
