<?php

    use App\Models\UserDevice;
    use Faker\Factory;
    use Illuminate\Database\Seeder;

class UserDevicesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $userDevice = factory( UserDevice::class,10)->create();
    }
}
