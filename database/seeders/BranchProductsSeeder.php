<?php

namespace Database\Seeders;
    use App\Models\BranchProduct;
    use Faker\Factory;
    use Illuminate\Database\Seeder;
class BranchProductsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $branchProduct = BranchProduct::factory()->count(10)->create();
    }
}
