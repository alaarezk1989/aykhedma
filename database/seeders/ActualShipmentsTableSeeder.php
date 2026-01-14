<?php

namespace Database\Seeders;
use Illuminate\Database\Seeder;
use \App\Models\ActualShipment;
class ActualShipmentsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        ActualShipment::factory()->count(10)->create(['parent_id' => null]);
        ActualShipment::factory()->count(20)->create();
    }
}
