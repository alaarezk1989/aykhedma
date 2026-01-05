<?php

namespace Database\Seeders;
    use App\Models\Unit;
    use Faker\Factory;
    use Illuminate\Database\Seeder;
class UnitsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $units = Unit::factory()->count(5)->create();
    }
}
