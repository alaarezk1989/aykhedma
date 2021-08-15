<?php

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
        $groups = factory(Group::class, 5)->create();
    }
}
