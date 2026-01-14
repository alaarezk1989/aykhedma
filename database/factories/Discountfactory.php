<?php

namespace Database\Factories;

use App\Models\Discount;
use App\Models\Activity;
use App\Models\Branch;
use App\Models\Vendor;
use App\Constants\PromotionTypes;
use Faker\Generator as Faker;
use Faker\Factory as FakerFactory;
use Illuminate\Support\Facades\Config;
use Illuminate\Database\Eloquent\Factories\Factory;

class DiscountFactory extends Factory
{
    protected $model = Discount::class;

    public function definition(): array
    {
        $faker = $this->faker;
        $arabicFaker = FakerFactory::create("ar_SA");

    $discount = [
        "from_date" => $faker->date($format = 'Y-m-d', $max = 'now'),
        "to_date" => $faker->date($format = 'Y-m-d', $max = 'now'),
        "value" => $faker->randomDigit,
        "type" => array_rand(PromotionTypes::getList()),
        "minimum_order_price" => $faker->randomDigit,
        "usage_no" => $faker->randomDigit,
        "created_at" => $faker->date($format = 'Y-m-d', $max = 'now'),
        "activity_id" => $faker->randomElement(Activity::all())->id,
        "vendor_id" => $faker->randomElement(Vendor::all())->id,
        "branch_id" => $faker->randomElement(Branch::all())->id,
        "active" => $faker->boolean(),
    ];

    foreach (Config::get('app.locales') as $lang => $language) {
        $tempFaker = $lang == 'ar' ? $arabicFaker : $faker;
        $discount[$lang] = [
            "title" => $tempFaker->text(20)
        ];
    }

    return $discount;
    }
}
