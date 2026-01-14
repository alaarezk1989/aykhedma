<?php

namespace Database\Factories;

use Faker\Generator as Faker;
use App\Models\Permission;
use Faker\Factory as FakerFactory;
use Illuminate\Support\Facades\Config;
use Illuminate\Database\Eloquent\Factories\Factory;

class PermissionFactory extends Factory
{
    protected $model = Permission::class;

    public function definition(): array
    {
        $faker = $this->faker;
        $arabicFaker = FakerFactory::create("ar_SA");

    $permission = [
        "identifier" => str_replace(' ', '.', $faker->word),
        "active" => $faker->boolean(),
    ];

    foreach (Config::get('app.locales') as $lang => $language) {
        $tempFaker = $lang == 'ar' ? $arabicFaker : $faker;
        $permission [$lang] = [
            "name" => $tempFaker->text(20)
        ];
    }

    return $permission;
    }
}
