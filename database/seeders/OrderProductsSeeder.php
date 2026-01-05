<?php

namespace Database\Seeders;
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
        $orderProduct = OrderProduct::factory()->count(100)->create();
    }
}
