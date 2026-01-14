<?php

namespace Database\Seeders;
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
        $userDevice = UserDevice::factory()->count(10)->create();
    }
}
