<?php

namespace Database\Factories;

use App\Models\Banner;
use App\Models\Branch;
use Illuminate\Support\Str;
use Faker\Generator as Faker;
use Illuminate\Database\Eloquent\Factories\Factory;

class BannerFactory extends Factory
{
    protected $model = Banner::class;

    public function definition(): array
    {
        $faker = $this->faker;
        $branches = Branch::all();
    $banner = [
        'type' => $faker->randomElement([1, 2]),
        'url' => $faker->url,
        'date_from' => $faker->date($format = 'Y-m-d', $max = 'now'),
        'date_to' => $faker->date($format = 'Y-m-d', $max = 'now'),
        'branch_id' => $faker->randomElement($branches)->id,
        'image' => $faker->imageUrl(),
        'active' => $faker->boolean(),
    ];

    return $banner;
    }
}
