<?php

namespace Database\Seeders;
use App\Models\Banner;
use Illuminate\Database\Seeder;
use Faker\Factory;
class BannersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Banner::factory()->count(5)->create();
    }
}
