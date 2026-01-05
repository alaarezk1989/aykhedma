<?php

namespace Database\Factories;

use App\Models\Category;
use Illuminate\Database\Eloquent\Factories\Factory;

class CategoryFactory extends Factory
{
    protected $model = Category::class;

    public function definition(): array
    {
        $faker = $this->faker;
        return [
            'active' => $faker->boolean(),
            'en'=> ['name' => $faker->city],
            'ar'=> ['name' => $faker->city],
        ];
    }
}
