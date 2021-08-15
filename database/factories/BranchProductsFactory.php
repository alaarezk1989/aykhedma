<?php

use App\Models\BranchProduct;
use App\Models\Branch;
use App\Models\Product ;
use App\Models\User ;
use Faker\Factory;
use Faker\Generator as Faker;
    
    $factory->define( BranchProduct::class, function (Faker $faker) {
    
    $branches = Branch::all();
    $products = Product::all();
    $users = User::all();

    $branchProduct = [
        'branch_id' => $faker->randomElement($branches)->id ,
        'product_id' => $faker->randomElement($products)->id ,
        'price' => $faker->randomDigit,
        'discount' => $faker->randomDigit,
        'discount_till' => date("Y-m-d"),
        "active" => $faker->boolean ,
    ];
    
    $branchProduct["category_id"] = Product::where('id',$branchProduct["product_id"])->first()->category_id;

    return $branchProduct;
});


