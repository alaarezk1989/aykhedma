<?php

namespace Database\Factories;

use Faker\Generator as Faker;
use App\Models\Group;
use Faker\Factory as FakerFactory;
use Illuminate\Support\Facades\Config;
use Illuminate\Database\Eloquent\Factories\Factory;

class GroupFactory extends Factory
{
    protected $model = Group::class;

    public function definition(): array
    {
        $faker = $this->faker;
        $arabicFaker = FakerFactory::create('ar_SA');

    $groups = [
        'active' => $faker->boolean(),
    ];
    foreach (Config::get('app.locales') as $lang => $language) {
        $tempFaker = $lang == 'ar' ? $arabicFaker : $faker;
        $groups[$lang] = ['name' => $tempFaker->word];
    }
    return $groups;
    }
}
