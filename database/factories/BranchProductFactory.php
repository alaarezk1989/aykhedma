<?php

namespace Database\Factories;

use App\Models\BranchProduct;
use App\Models\Branch;
use App\Models\Product ;
use App\Models\User ;
use Faker\Factory as FakerFactory;
use Faker\Generator as Faker;
use Illuminate\Database\Eloquent\Factories\Factory;

class BranchProductFactory extends Factory
{
    protected $model = BranchProduct::class;

    public function definition(): array
    {
        $faker = $this->faker;
        $branches = Branch::all();
    $products = Product::all();
    $users = User::all();

    $branchProduct = [
        'branch_id' => $faker->randomElement($branches)->id ,
        'product_id' => $faker->randomElement($products)->id ,
        'price' => $faker->randomDigit,
        'discount' => $faker->randomDigit,
        'discount_till' => date("Y-m-d"),
        "active" => $faker->boolean() ,
    ];
    
    $branchProduct["category_id"] = Product::where('id',$branchProduct["product_id"])->first()->category_id;

    return $branchProduct;
    }
}
