<?php

namespace Database\Seeders;
use App\Models\Activity;
use Faker\Factory;
use Illuminate\Database\Seeder;
class ActivitiesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $activities = Activity::factory()->count(2)->create();
    }
}
