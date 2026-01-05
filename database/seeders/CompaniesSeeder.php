<?php

namespace Database\Seeders;
use App\Models\Company;
use Faker\Factory;
use Illuminate\Database\Seeder;
class CompaniesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $companies = Company::factory()->count(5)->create();
    }
}
