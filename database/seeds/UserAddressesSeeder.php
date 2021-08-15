<?php

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
        $addresses = factory( Address::class,100)->create();
    }
}
