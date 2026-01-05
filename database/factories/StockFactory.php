<?php

namespace Database\Factories;

use App\Models\Stock;
use App\Models\BranchProduct;
use Faker\Generator as Faker;
use Illuminate\Database\Eloquent\Factories\Factory;

class StockFactory extends Factory
{
    protected $model = Stock::class;

    public function definition(): array
    {
        $faker = $this->faker;
        $products = BranchProduct::all();

    return [
        "product_id" => $faker->randomElement($products)->id ,
        "in_amount" => $faker->randomDigit,
        "out_amount" => $faker->randomDigit,
        "balance" => $faker->randomDigit,
        'created_by' => 1
    ];
    }
}
