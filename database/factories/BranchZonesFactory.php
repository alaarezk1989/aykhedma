<?php

use App\Models\BranchZone;
use App\Models\Branch;
use App\Models\Location ;
use Faker\Factory;
use Faker\Generator as Faker;
    
    $factory->define( BranchZone::class, function (Faker $faker) {
    
    $branches = Branch::all();
    $zones = Location::all();

    $branchZone = [
        'branch_id' => $faker->randomElement($branches)->id ,
        'zone_id' => $faker->randomElement($zones)->id ,
        ];

    return $branchZone;
});


