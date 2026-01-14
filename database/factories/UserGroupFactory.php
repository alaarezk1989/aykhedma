<?php

namespace Database\Factories;

use App\Models\Group;
use App\Models\User;
use App\Models\UserGroup;
use Faker\Factory as FakerFactory;
use Faker\Generator as Faker;
use Illuminate\Database\Eloquent\Factories\Factory;

class UserGroupFactory extends Factory
{
    protected $model = UserGroup::class;

    public function definition(): array
    {
        $faker = $this->faker;
        $users = User::where('id', '<>', 1)->get();
        $groups = Group::where('id', '<>', 1)->get();
        $userGroups = [
            'user_id' => $faker->randomElement($users)->id,
            'group_id' => $faker->randomElement($groups)->id,
        ];

        return $userGroups;
    }
}
