<?php

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
        $branches = factory( Branch::class,10)->create();
    }
}
