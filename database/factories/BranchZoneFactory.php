<?php

namespace Database\Factories;

use App\Models\BranchZone;
use App\Models\Branch;
use App\Models\Location ;
use Faker\Factory as FakerFactory;
use Faker\Generator as Faker;
use Illuminate\Database\Eloquent\Factories\Factory;

class BranchZoneFactory extends Factory
{
    protected $model = BranchZone::class;

    public function definition(): array
    {
        $faker = $this->faker;
        $branches = Branch::all();
    $zones = Location::all();

    $branchZone = [
        'branch_id' => $faker->randomElement($branches)->id ,
        'zone_id' => $faker->randomElement($zones)->id ,
        ];

    return $branchZone;
    }
}
