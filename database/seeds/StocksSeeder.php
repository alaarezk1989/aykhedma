<?php

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
        $stocks = factory( Stock::class, 20)->create();
    }
}
