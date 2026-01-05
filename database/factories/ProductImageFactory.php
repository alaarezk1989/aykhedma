<?php

namespace Database\Factories;

use Faker\Generator as Faker;
use App\Models\ProductImage ;
use Illuminate\Database\Eloquent\Factories\Factory;

class ProductImageFactory extends Factory
{
    protected $model = ProductImage::class;

    public function definition(): array
    {
        $faker = $this->faker;
        return [
        "image" => $faker->imageUrl()
    ];
    }
}
