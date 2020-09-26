<?php

namespace Tests\Feature\Store\Cart;

use App\Category;
use App\Product;
use App\User;
use Darryldecode\Cart\Cart;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class AddProductToCartTest extends TestCase
{
    use WithFaker, RefreshDatabase;
    /**
     * @test
     */
    public function AnUserCanAddAProductToTheCart()
    {
        $this->withoutExceptionHandling();
    //Arrange
        $category = factory(Category::class)->create(['name' => 'categoryTest']);
        factory(Product::class, 10)->create(['category_id' => $category->id]);

        $product = Product::where(['id' => '3'])->first();

        $user = $this->ActingAsClient();
    //When
        $this->post(route('cart.store', $product));

        $this->assertCount(1, \Cart::getContent());

    }


    /**
     * @test
     */

    public function aCartProductNeedAQuantity()
    {
        $this->withoutExceptionHandling();
        $this->ActingAsClient();

        $category = factory(Category::class)->create(['name' => 'categoryTest']);
        factory(Product::class, 10)->create([
            'category_id' => $category->id,
            'actualPrice' => 0
        ]);

        $product = Product::where(['id' => '3'])->first();
dd($product);
        //When
        $this->post(route('cart.addProduct', [$product->id]));

        $this->assertCount(1, \Cart::getContent());


    }
        private function ActingAsClient(){
        $user = factory(User::class)->create(['role' => 'Cliente']);
        $this->actingAs($user);
        return $user;
    }
}
