<?php

namespace Database\Factories;

use App\Models\Vehicle;
use App\Models\User;
use App\Models\Location;
use App\Models\ShippingCompany;
use App\Constants\UserTypes as UserTypes;
use App\Constants\VehicleStatus as VehicleStatus ;
use App\Constants\VehicleTypes as VehicleTypes ;
use Faker\Factory as FakerFactory;
use Faker\Generator as Faker;
use Illuminate\Support\Facades\Config;
use Illuminate\Database\Eloquent\Factories\Factory;

class VehicleFactory extends Factory
{
    protected $model = Vehicle::class;

    public function definition(): array
    {
        $faker = $this->faker;
        $arabicFaker = FakerFactory::create('ar_SA');
$drivers   = User::where('type',UserTypes::DRIVER)->get();
$locations = Location::get();
$vehicleStatus = VehicleStatus::getList();
$vehicleTypes  = VehicleTypes::getList();
$shippingCompanies=ShippingCompany::where('active', '=', 1)->get();



    $vehicles = [
            'type_id'    => array_rand($vehicleTypes),
            'status_id'  => array_rand($vehicleStatus) ,
            'shipping_company_id'=>$faker->randomElement($shippingCompanies)->id,
            'capacity'   => $faker->randomNumber,
            'zone_id'    => $faker->randomElement($locations)->id,
            'driver_id'  => $faker->randomElement($drivers)->id ,
            'number'     => $faker->randomNumber,
            'active'     => $faker->boolean(),
    ];

    foreach (Config::get('app.locales') as $lang => $language) {
        $faker = $lang == 'ar' ? $arabicFaker : $faker;
        $vehicles[$lang] = [
            'name'    => $faker->word,

        ];
    }
    return $vehicles;
    }
}
