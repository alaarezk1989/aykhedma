<?php

namespace Database\Factories;

use App\Models\Unit;
use Illuminate\Database\Eloquent\Factories\Factory;

class UnitFactory extends Factory
{
    protected $model = Unit::class;

    public function definition(): array
    {
        $faker = $this->faker;
        $units = [
        [
            'active' => $faker->boolean(),
            'en'=> ['name' => 'Kilogram', 'acronym' => 'kg'],
            'ar'=> ['name' => 'كيلوجرام', 'acronym' => 'ك'],
        ],
        [
            'active' => $faker->boolean(),
            'en'=> ['name' => 'Piece', 'acronym' => 'P'],
            'ar'=> ['name' => 'قطعة', 'acronym' => 'ق'],
        ],
        [
            'active' => $faker->boolean(),
            'en'=> ['name' => 'Litre', 'acronym' => 'L'],
            'ar'=> ['name' => 'لتر', 'acronym' => 'ل'],
        ],
        [
            'active' => $faker->boolean(),
            'en'=> ['name' => 'Box', 'acronym' => 'B'],
            'ar'=> ['name' => 'عبوة', 'acronym' => 'ع'],
        ],
    ];


    return $faker->randomElement($units);
    }
}
