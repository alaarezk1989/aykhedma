<?php

namespace Database\Factories;

use App\Models\Point;
use App\Models\User;
use Faker\Generator as Faker;
use Illuminate\Database\Eloquent\Factories\Factory;

class PointFactory extends Factory
{
    protected $model = Point::class;

    public function definition(): array
    {
        $faker = $this->faker;
        return [
        'user_id'     => User::factory()->create()->id,
        'amount'    => $faker->randomDigit,
        "balance" => $faker->randomDigit,
    ];
    }
}
