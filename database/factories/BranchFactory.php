<?php

namespace Database\Factories;

use App\Models\Branch;
use App\Models\Vendor;
use App\Constants\BranchTypes  ;
use Faker\Factory as FakerFactory;
use Faker\Generator as Faker;
use Illuminate\Support\Facades\Config;
use Illuminate\Database\Eloquent\Factories\Factory;

class BranchFactory extends Factory
{
    protected $model = Branch::class;

    public function definition(): array
    {
        $faker = $this->faker;
        $arabicFaker = FakerFactory::create('ar_SA');

    $branch = [
        "vendor_id" => Vendor::factory()->create()->id,
        'lat'       => $faker->latitude,
        'lng'       => $faker->longitude,
        'active'    => $faker->boolean(),
        'type'    => $faker->randomElement(BranchTypes::getTypeValue()),
    ];

    foreach (Config::get('app.locales') as $lang => $language) {
        $faker = $lang == 'ar' ? $arabicFaker : $faker;
        $branch[$lang] = [
            'name'    => $faker->name,
            'address' => $faker->country."/".$faker->city,
        ];
    }

    return $branch;
    }
}
