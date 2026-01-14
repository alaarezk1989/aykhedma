<?php

namespace Database\Factories;

use App\Models\ShippingCompany;
use Faker\Factory as FakerFactory;
use Faker\Generator as Faker;
use Illuminate\Support\Facades\Config;
use Illuminate\Database\Eloquent\Factories\Factory;

class ShippingCompanyFactory extends Factory
{
    protected $model = ShippingCompany::class;

    public function definition(): array
    {
        $faker = $this->faker;
        $arabicFaker = FakerFactory::create('ar_SA');

    $company = [
        'phone'       => $faker->phoneNumber,
        'email'       => $faker->email,
        'address'       =>$faker->address,
        'active' => $faker->boolean(),
    ];

    foreach (Config::get('app.locales') as $lang => $language) {
        $faker = $lang == 'ar' ? $arabicFaker : $faker;
        $company[$lang] = [
            'name'    => $faker->word,
        ];
    }
    return $company;
    }
}
