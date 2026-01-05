<?php

namespace Database\Seeders;
use App\Models\ShippingCompany;
use Faker\Factory;
use Illuminate\Database\Seeder;
class ShippingCompaniesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $companies = ShippingCompany::factory()->count(10)->create();
    }
}
