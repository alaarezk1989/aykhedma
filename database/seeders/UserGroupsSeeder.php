<?php

namespace Database\Seeders;
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
        UserGroup::factory()->create([
            'user_id' => 1,
            'group_id' => 1,
        ]);
        UserGroup::factory()->count(5)->create();
    }
}
