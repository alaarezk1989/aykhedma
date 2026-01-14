<?php

namespace Database\Seeders;
    use App\Models\Address;
    use Faker\Factory;
    use Illuminate\Database\Seeder;
class UserAddressesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $addresses = Address::factory()->count(100)->create();
    }
}
