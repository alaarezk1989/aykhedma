<?php

    use App\Models\BranchZone;
    use Faker\Factory;
    use Illuminate\Database\Seeder;

class BranchZonesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $branchZone = factory(BranchZone::class, 5)->create();
    }
}
