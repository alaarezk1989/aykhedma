<?php

namespace Database\Seeders;
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
        $vendors = Vendor::factory()->count(5)->create();
    }
}
