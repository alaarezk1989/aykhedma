<?php

namespace Database\Factories;

use App\Models\Segmentation;
use App\Models\Location;
use App\Models\Company;
use App\Models\Vendor;
use App\Models\Branch;
use App\Models\Activity;
use Faker\Factory as FakerFactory;
use Faker\Generator as Faker;
use Illuminate\Support\Facades\Config;
use Illuminate\Database\Eloquent\Factories\Factory;

class SegmentationFactory extends Factory
{
    protected $model = Segmentation::class;

    public function definition(): array
    {
        $faker = $this->faker;
        $arabicFaker = FakerFactory::create('ar_SA');

    $locations = Location::all();
    $companies = Company::all();

    $segmentation = [
        'class' => $faker->randomElement([1, 2, 3]),
        'location_id' => $faker->randomElement($locations)->id ,
        'company_id' => $faker->randomElement($companies)->id ,
    ];

    foreach (Config::get('app.locales') as $lang => $language) {
        $faker = $lang == 'ar' ? $arabicFaker : $faker;
        $segmentation[$lang] = [
            'title'    => $faker->name,
        ];
    }

    return $segmentation;
    }
}
