<?php

namespace Database\Factories;

use App\Constants\UserTypes;
use App\Models\User;
use App\Models\Activity;
use Illuminate\Support\Str;
use Faker\Generator as Faker;
use Illuminate\Support\Carbon;
use Illuminate\Database\Eloquent\Factories\Factory;

class UserFactory extends Factory
{
    protected $model = User::class;

    public function definition(): array
    {
        $faker = $this->faker;
        $activities = Activity::all();

    $user = [
        'first_name'        => $faker->firstName,
        'last_name'         => $faker->lastName,
        'birthdate'         => $faker->date($format = 'Y-m-d', $max = 'now'),
        'phone'             => $faker->phoneNumber,
        'image'             => $faker->imageUrl(),
        'gender'            => $faker->boolean(),
        'type'              => $faker->randomElement([1, 2, 3, 4, 6]),
        'active'            => $faker->boolean(),
        'email'             => $faker->unique()->safeEmail,
        'email_verified_at' => now(),
        'password'          => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi',
        'remember_token'    => Str::random(10),
    ];

    return $user;
    }
}
