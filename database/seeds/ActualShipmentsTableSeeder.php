<?php

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
        factory(ActualShipment::class, 10)->create(['parent_id' => null]);
        factory(ActualShipment::class, 20)->create();
    }
}
