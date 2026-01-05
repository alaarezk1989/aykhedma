<?php

namespace Database\Factories;

use App\Models\Address;
use App\Models\Order;
use App\Models\User;
use App\Models\Branch;
use Faker\Generator as Faker;
use Illuminate\Database\Eloquent\Factories\Factory;

class OrderFactory extends Factory
{
    protected $model = Order::class;

    public function definition(): array
    {
        $faker = $this->faker;
        $user = User::factory()->create();
    $branch = Branch::factory()->create();
    $order = [
        "user_id" => $user->id,
    ];

    $order["address_id"] = Address::factory()->create(['user_id' => $user->id])->first()->id;

    return $order;
    }
}
