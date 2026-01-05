<?php

namespace Database\Seeders;
use App\Models\Permission;
use Illuminate\Database\Seeder;
use App\Models\Group;
use Faker\Factory;
class GroupsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $groups = Group::factory()->count(5)->create();
    }
}
