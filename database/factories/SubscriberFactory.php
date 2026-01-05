<?php

namespace Database\Factories;

use App\Models\Subscriber;
use Faker\Generator as Faker;
use Illuminate\Database\Eloquent\Factories\Factory;

class SubscriberFactory extends Factory
{
    protected $model = Subscriber::class;

    public function definition(): array
    {
        $faker = $this->faker;
        $subscribers = [
        [
            'active' => $faker->boolean(),
            'email'  => $faker->unique()->safeEmail,
        ],       
    ];

    return $faker->randomElement($subscribers);
    }
}
