<?php

namespace Database\Factories;

use App\Models\UserDevice;
use App\Models\User;
use Faker\Factory as FakerFactory;
use Faker\Generator as Faker;
use Illuminate\Database\Eloquent\Factories\Factory;

class UserDeviceFactory extends Factory
{
    protected $model = UserDevice::class;

    public function definition(): array
    {
        $faker = $this->faker;
        $users = User::all();
        $userDevice = [
            'user_id' => $faker->randomElement($users)->id,
            'model' => $faker->text(20),
            'os' => $faker->randomElement([1, 2, 3]),
            'token' => str_random(60),
        ];

        return $userDevice;
    }
}
