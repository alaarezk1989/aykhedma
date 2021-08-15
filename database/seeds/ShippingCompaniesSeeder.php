<?php

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
        $companies = factory(ShippingCompany::class,10)->create();
    }
}


