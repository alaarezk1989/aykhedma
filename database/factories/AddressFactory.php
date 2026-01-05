<?php

namespace Database\Factories;

use App\Models\Address;
use App\Models\User;
use App\Models\Location;
use Faker\Generator as Faker;
use Illuminate\Database\Eloquent\Factories\Factory;

class AddressFactory extends Factory
{
    protected $model = Address::class;

    public function definition(): array
    {
        $faker = $this->faker;
        $locations = Location::all();
    return [
        'user_id'     => User::factory()->create()->id,
        'location_id' => $faker->randomElement($locations)->id,
        'building'    => $faker->randomDigit,
        'street'      => $faker->text(20),
        'floor'       => $faker->randomDigit,
        'apartment'   => $faker->randomDigit,
    ];
    }
}
