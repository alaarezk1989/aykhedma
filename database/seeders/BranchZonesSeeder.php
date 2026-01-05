<?php

namespace Database\Seeders;
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
        $branchZone = BranchZone::factory()->count(5)->create();
    }
}
