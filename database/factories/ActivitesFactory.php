<?php

    use App\Models\Activity;
    use Faker\Generator as Faker;

$factory->define( Activity::class, function (Faker $faker) {

    $activities = [
        [
            'active' => $faker->boolean,
            'image' => $faker->imageUrl(),
            'en'=> ['name' => 'Drinks', 'description' => 'DrinksDrinks'],
            'ar'=> ['name' => 'أدويى', 'description' => 'أدويىأ دويى'],
        ],
        [
            'active' => $faker->boolean,
            'image' => $faker->imageUrl(),
            'en'=> ['name' => 'Meats', 'description' => 'MeatsMeatsMeatsMeats'],
            'ar'=> ['name' => 'لحوم', 'description' => 'لحوم لحوم لحوم'],
        ],
        [
            'active' => $faker->boolean,
            'image' => $faker->imageUrl(),
            'en'=> ['name' => 'Vegetables', 'description' => 'Vegetables Vegetables'],
            'ar'=> ['name' => 'خضروات', 'description' => 'خضروات خضروات خضروات'],
        ],
        [
            'active' => $faker->boolean,
            'image' => $faker->imageUrl(),
            'en'=> ['name' => 'Fruits', 'description' => 'Fruits Fruits'],
            'ar'=> ['name' => 'فواكه', 'description' => 'فواكه فواكه'],
        ],
    ];


    return $faker->randomElement($activities);
});


