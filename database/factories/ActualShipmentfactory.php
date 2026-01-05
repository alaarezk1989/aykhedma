<?php

namespace Database\Factories;

use App\Models\ActualShipment;
use App\Models\Location;
use App\Constants\ActualShipmentStatus;
use Faker\Factory as FakerFactory;
use Faker\Generator as Faker;
use Illuminate\Support\Facades\Config;
use Illuminate\Database\Eloquent\Factories\Factory;

class ActualShipmentFactory extends Factory
{
    protected $model = ActualShipment::class;

    public function definition(): array
    {
        $faker = $this->faker;
        $arabicFaker = FakerFactory::create('ar_SA');
    $actualShipments = ActualShipment::whereRaw('(`_lft`+1)', '`_rgt`')->get();
    $locations = Location::all();
    $shipments = Location::all();

    $actualShipment = [
        'shipment_id' => $faker->randomElement($shipments)->id,
        'parent_id' => $actualShipments->isEmpty() ? null : $faker->randomElement($actualShipments)->id,
        'from' => $faker->randomElement($locations)->id,
        'to' => $faker->randomElement($locations)->id,
        'from_time' => $faker->date($format = 'Y-m-d', $max = 'now'),
        'to_time' => $faker->date($format = 'Y-m-d', $max = 'now'),
        'cutoff' => $faker->date($format = 'Y-m-d', $max = 'now'),
        'capacity' =>  $faker->numberBetween(500, 1000),
        'status' =>  $faker->randomElement(ActualShipmentStatus::getStatusesValues()),
        'active' => $faker->boolean(),
    ];

    $actualShipment['load'] = $faker->numberBetween(500, $actualShipment['capacity']);

    foreach (Config::get('app.locales') as $lang => $language) {
        $tempFaker = $lang == 'ar' ? $arabicFaker : $faker;
        $actualShipment[$lang] = [
            'title' => $tempFaker->text(20),
        ];
    }

    return $actualShipment;
    }
}
