<?php

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
        factory(Shipment::class, 10)->create(['parent_id' => null]);
        factory(Shipment::class, 15)->create();
    }
}
