<?php

use App\Models\Group;
use App\Models\User;
use App\Models\UserGroup;
use Faker\Factory;
use Faker\Generator as Faker;

    $factory->define(UserGroup::class, function (Faker $faker) {
        $users = User::where('id', '<>', 1)->get();
        $groups = Group::where('id', '<>', 1)->get();
        $userGroups = [
            'user_id' => $faker->randomElement($users)->id,
            'group_id' => $faker->randomElement($groups)->id,
        ];

        return $userGroups;
    });
