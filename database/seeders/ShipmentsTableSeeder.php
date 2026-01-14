<?php

namespace Database\Seeders;
use Illuminate\Database\Seeder;
use \App\Models\Shipment;
class ShipmentsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Shipment::factory()->count(10)->create(['parent_id' => null]);
        Shipment::factory()->count(15)->create();
    }
}
