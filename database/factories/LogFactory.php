<?php

namespace Database\Factories;

use App\Models\Log;
use App\Models\User;
use App\Constants\ObjectTypes as ObjectTypes;
use Illuminate\Support\Str;
use Faker\Generator as Faker;
use Illuminate\Database\Eloquent\Factories\Factory;

class LogFactory extends Factory
{
    protected $model = Log::class;

    public function definition(): array
    {
        $faker = $this->faker;
        $user = User::query()->inRandomOrder()->first();

    $logs = [
        'user_id' => $user->id,
        'object_id' => $faker->randomElement([1, 2, 3, 4, 5, 6, 7, 8, 9]),
        'object_type' => $faker->randomElement(ObjectTypes::getKeyList()),
        'message' => $faker->text(25),
        'user' => $user->toArray()
    ];

    return $logs;
    }
}
