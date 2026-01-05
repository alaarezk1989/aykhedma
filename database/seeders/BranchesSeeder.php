<?php

namespace Database\Seeders;
    use App\Models\Branch;
    use Faker\Factory;
    use Illuminate\Database\Seeder;
class BranchesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $branches = Branch::factory()->count(10)->create();
    }
}
