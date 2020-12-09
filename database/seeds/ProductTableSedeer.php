<?php

use App\Entities\Product;
use Illuminate\Database\Seeder;

class ProductTableSedeer extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(Product::class, 100)->create()->each(function (Product $product) {

            $product->tags()->attach([
                rand(1, 5),
                rand(6, 12),
                rand(13, 20)
            ]);

        });
    }
}
