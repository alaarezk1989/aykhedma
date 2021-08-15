<?php

    use App\Models\Unit;
    use Faker\Generator as Faker;

$factory->define( Unit::class, function (Faker $faker) {

    $units = [
        [
            'active' => $faker->boolean,
            'en'=> ['name' => 'Kilogram', 'acronym' => 'kg'],
            'ar'=> ['name' => 'كيلوجرام', 'acronym' => 'ك'],
        ],
        [
            'active' => $faker->boolean,
            'en'=> ['name' => 'Piece', 'acronym' => 'P'],
            'ar'=> ['name' => 'قطعة', 'acronym' => 'ق'],
        ],
        [
            'active' => $faker->boolean,
            'en'=> ['name' => 'Litre', 'acronym' => 'L'],
            'ar'=> ['name' => 'لتر', 'acronym' => 'ل'],
        ],
        [
            'active' => $faker->boolean,
            'en'=> ['name' => 'Box', 'acronym' => 'B'],
            'ar'=> ['name' => 'عبوة', 'acronym' => 'ع'],
        ],
    ];


    return $faker->randomElement($units);
});


