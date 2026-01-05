<?php

namespace Database\Seeders;
    use App\Models\Stock;
    use Faker\Factory;
    use Illuminate\Database\Seeder;
class StocksSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $stocks = Stock::factory()->count(20)->create();
    }
}
