<?php

namespace Database\Factories;

use App\Models\Vendor;
use App\Models\Activity;
use App\Constants\VendorTypes ;
use Faker\Factory as FakerFactory;
use Faker\Generator as Faker;
use Illuminate\Support\Facades\Config;
use Illuminate\Database\Eloquent\Factories\Factory;

class VendorFactory extends Factory
{
    protected $model = Vendor::class;

    public function definition(): array
    {
        $faker = $this->faker;
        $arabicFaker = FakerFactory::create('ar_SA');
    $activities = Activity::all();
    $vendor = [
        'activity_id' => $faker->randomElement($activities)->id ,
        'logo' => $faker->imageUrl(),
        'active'    => $faker->boolean(),
        'type'    => $faker->randomElement(VendorTypes::getTypeValue()),
    ];

    foreach (Config::get('app.locales') as $lang => $language) {
        $faker = $lang == 'ar' ? $arabicFaker : $faker;
        $vendor[$lang] = [
            'name'    => $faker->name,
        ];
    }

    return $vendor;
    }
}
