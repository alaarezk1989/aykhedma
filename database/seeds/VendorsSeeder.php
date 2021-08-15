<?php

    use App\Models\Vendor;
    use Faker\Factory;
    use Illuminate\Database\Seeder;

class VendorsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $vendors = factory( Vendor::class,5)->create();
    }
}
