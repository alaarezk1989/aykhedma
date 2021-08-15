<?php

    use App\Models\Order;
    use Faker\Factory;
    use Illuminate\Database\Seeder;

class OrdersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $orders = factory( Order::class,30)->create();
    }
}
