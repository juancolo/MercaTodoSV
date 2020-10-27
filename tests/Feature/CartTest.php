<?php


namespace Tests\Feature;


use App\Entities\Product;

class CartTest
{
    public static function createCart($user, $product){
       \Cart::session($user)->add(array(
                'id' => $product->id,
                'name' => $product->name,
                'price' => $product->actual_price,
                'quantity' => 1,
                'attributes' => array($product->file),
                'associateModel' => Product::class
            ));
    }
}
