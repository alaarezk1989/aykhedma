<?php

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
        factory( Banner::class, 5)->create();
    }
}
