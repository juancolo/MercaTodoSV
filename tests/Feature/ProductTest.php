<?php

namespace Tests\Feature;

use App\Entities\Product;

class ProductTest
{
    public static function createProduct($category)
    {
        return factory(Product::class)->create(
            [
                'name'=>'ProductTest',
                'slug'=>'producttest',
                'details'=>'ProductDetail',
                'description'=>'ProductDescription',
                'actual_price'=> 1000,
                'category_id' => $category->id,
                'stock' => 10,
            ]
        );
    }
    public static function EditProduct(Product $product)
    {
        $product->name = 'ProdcutEditName';
        $product->slug = Str::slug($product->name);
        $product->save();
        return $product;
    }
}
