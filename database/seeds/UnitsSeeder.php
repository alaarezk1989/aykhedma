<?php

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
        $units = factory( Unit::class, 5)->create();
    }
}
