<?php

use Illuminate\Database\Seeder;
use App\Models\Product;
use App\Models\ProductImage;

class ProductsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(Product::class, 10)->create()->each(function ($product){

            $num = random_int(2,9) ;

            for ($i =0 ; $i <= $num ; $i++){

                $product->images()->save(factory(ProductImage::class)->make());

            }

        });

    }
}
