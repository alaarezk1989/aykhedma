<?php

    use App\Models\OrderProduct;
    use Faker\Factory;
    use Illuminate\Database\Seeder;

class OrderProductsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $orderProduct = factory( OrderProduct::class,100)->create();
    }
}
