<?php

use App\Product;
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
        Product::truncate();
        $product1 = new Product();

        $product1->name = 'Mackbook Pro 1';
        $product1->slug = 'macbook-pro 1';
        $product1->details = '15 inch, 1 TB SSD, 32 GB';
        $product1->price =  2499;
        $product1->description = 'lorem asderwsewrsdfdfgdvxsdfw';
        $product1->category =  1;

        $product1->save();

        $product2 = new Product();

        $product2->name = 'Mackbook Pro 2';
        $product2->slug = 'macbook-pro 2';
        $product2->details = '15 inch, 1 TB SSD, 32 GB';
        $product2->price =  2499;
        $product2->description = 'lorem asderwsewrsdfdfgdvxsdfw';
        $product2->category =  1;

        $product2->save();

        $product3 = new Product();

        $product3->name = 'Mackbook Pro 3';
        $product3->slug = 'macbook-pro 3';
        $product3->details = '15 inch, 1 TB SSD, 32 GB';
        $product3->price =  2499;
        $product3->description = 'lorem asderwsewrsdfdfgdvxsdfw';
        $product3->category =  1;

        $product3->save();

        $product4 = new Product();

        $product4->name = 'Mackbook Pro 4';
        $product4->slug = 'macbook-pro 4';
        $product4->details = '15 inch, 1 TB SSD, 32 GB';
        $product4->price =  2499;
        $product4->description = 'lorem asderwsewrsdfdfgdvxsdfw';
        $product4->category =  1;

        $product4->save();

        $product5 = new Product();

        $product5->name = 'Mackbook Pro 5';
        $product5->slug = 'macbook-pro 5';
        $product5->details = '15 inch, 1 TB SSD, 32 GB';
        $product5->price =  2499;
        $product5->description = 'lorem asderwsewrsdfdfgdvxsdfw';
        $product5->category =  1;

        $product5->save();

        $product6 = new Product();

        $product6->name = 'Mackbook Pro 6';
        $product6->slug = 'macbook-pro 6';
        $product6->details = '15 inch, 1 TB SSD, 32 GB';
        $product6->price =  2499;
        $product6->description = 'lorem asderwsewrsdfdfgdvxsdfw';
        $product6->category =  1;

        $product6->save();

        $product7 = new Product();

        $product7->name = 'Mackbook Pro 7';
        $product7->slug = 'macbook-pro 7';
        $product7->details = '15 inch, 1 TB SSD, 32 GB';
        $product7->price =  2499;
        $product7->description = 'lorem asderwsewrsdfdfgdvxsdfw';
        $product7->category =  1;

        $product7->save();
    }
}
