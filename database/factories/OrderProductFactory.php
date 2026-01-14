<?php

namespace Database\Factories;

use App\Models\Category;
use App\Models\OrderProduct;
use App\Models\Order;
use App\Models\BranchProduct;
use App\Models\Product;
use Faker\Factory as FakerFactory;
use Faker\Generator as Faker;
use Illuminate\Database\Eloquent\Factories\Factory;

class OrderProductFactory extends Factory
{
    protected $model = OrderProduct::class;

    public function definition(): array
    {
        $faker = $this->faker;
        $orders = Order::all();
    $branchProduct = BranchProduct::all();
    $products = Product::all();
    $categories = Category::all();

    $orderProduct = [
        'order_id' => $faker->randomElement($orders)->id,
        'branch_product_id' => $faker->randomElement($branchProduct)->id,
        'product_id' => $faker->randomElement($products)->id,
        'category_id' => $faker->randomElement($categories)->id,
        "quantity" => $faker->randomDigit,

    ];

    $orderProduct["price"] = BranchProduct::where('id', $orderProduct["branch_product_id"])->first()->price;

    return $orderProduct;
    }
}
