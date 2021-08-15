<?php
use App\Models\Vehicle;
use Faker\Factory;
use Illuminate\Database\Seeder;

class VehiclesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $vehicles = factory( Vehicle::class, 5)->create();
    }
}
