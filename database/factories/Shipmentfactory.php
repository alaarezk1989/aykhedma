<?php

/* @var $factory \Illuminate\Database\Eloquent\Factory */

use App\Constants\ObjectTypes as ObjectTypes;
use App\Models\Shipment;
use App\Models\Location;
use Faker\Factory;
use Faker\Generator as Faker;

$factory->define(Shipment::class, function (Faker $faker) {
    $arabicFaker = Factory::create('ar_SA');
    $trips = Shipment::whereRaw('(`_lft`+1)', '`_rgt`')->get();
    $locations = Location::all();
    $trip = [
        'parent_id' => $trips->isEmpty() ? null : $faker->randomElement($trips)->id,
        'from' => $faker->randomElement($locations)->id,
        'to' => $faker->randomElement($locations)->id,
        'capacity' =>  $faker->numberBetween(500, 1000),
        'recurring' => $faker->randomElement([30, 4, 1]),
        'from_time' => $faker->time($format = 'H:m:s'),
        'to_time' => $faker->time($format = 'H:m:s'),
        'last_touch' => $faker->dateTime($format = 'Y-m-d'),
        'cut_off_date' => $faker->numberBetween(1, 72),
        'active' => $faker->boolean,
    ];

    $trip['load'] = $faker->numberBetween(500, $trip['capacity']);

    foreach (Config::get('app.locales') as $lang => $language) {
        $tempFaker = $lang == 'ar' ? $arabicFaker : $faker;
        $trip[$lang] = [
            'title' => $tempFaker->text(20),
        ];
    }
    return $trip;
});
