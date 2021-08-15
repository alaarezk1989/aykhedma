<?php

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
        $branchProduct = factory( BranchProduct::class,10)->create();
    }
}
