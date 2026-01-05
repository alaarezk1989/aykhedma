<?php

namespace Database\Factories;

use App\Models\Activity;
use Illuminate\Database\Eloquent\Factories\Factory;

class ActivityFactory extends Factory
{
    protected $model = Activity::class;

    public function definition(): array
    {
        $faker = $this->faker;
        $activities = [
        [
            'active' => $faker->boolean(),
            'image' => $faker->imageUrl(),
            'en'=> ['name' => 'Drinks', 'description' => 'DrinksDrinks'],
            'ar'=> ['name' => 'أدويى', 'description' => 'أدويىأ دويى'],
        ],
        [
            'active' => $faker->boolean(),
            'image' => $faker->imageUrl(),
            'en'=> ['name' => 'Meats', 'description' => 'MeatsMeatsMeatsMeats'],
            'ar'=> ['name' => 'لحوم', 'description' => 'لحوم لحوم لحوم'],
        ],
        [
            'active' => $faker->boolean(),
            'image' => $faker->imageUrl(),
            'en'=> ['name' => 'Vegetables', 'description' => 'Vegetables Vegetables'],
            'ar'=> ['name' => 'خضروات', 'description' => 'خضروات خضروات خضروات'],
        ],
        [
            'active' => $faker->boolean(),
            'image' => $faker->imageUrl(),
            'en'=> ['name' => 'Fruits', 'description' => 'Fruits Fruits'],
            'ar'=> ['name' => 'فواكه', 'description' => 'فواكه فواكه'],
        ],
    ];


    return $faker->randomElement($activities);
    }
}
