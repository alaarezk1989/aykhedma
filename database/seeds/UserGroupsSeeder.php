<?php

use App\Models\UserGroup;
use Faker\Factory;
use Illuminate\Database\Seeder;

class UserGroupsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(UserGroup::class)->create([
            'user_id' => 1,
            'group_id' => 1,

        ]);
        factory(UserGroup::class, 5)->create();
    }
}
