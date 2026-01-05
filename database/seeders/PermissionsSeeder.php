<?php

namespace Database\Seeders;
use Illuminate\Database\Seeder;
use App\Models\Permission;
use Faker\Factory;
class PermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Permission::factory()->count(10)->create();
    }
}
