<?php

namespace Tests\Feature\Store\Cart;

use App\Category;
use App\Product;
use App\User;
use Darryldecode\Cart\Cart;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class StoreCartProducts extends TestCase
{
    use WithFaker, RefreshDatabase;
    /**
     * @test
     */
    public function AnAuthenticatedUserCanAddAProductToTheCart()
    {
    //Arrange
        $category = factory(Category::class)->create(['name' => 'categoryTest']);
        factory(Product::class, 10)->create(['category_id' => $category->id]);

        $product = Product::where(['id' => '3'])->first();

       $this->ActingAsClient();
    //When
        $this->post(route('cart.store', $product));

        $this->assertCount(1, \Cart::getContent());

    }

    /**
     * @test
     */
    public function AnUnAuthenticatedUserCantStoreAProductIntoTheCart(){

        //Arrange
        $category = factory(Category::class)->create(['name' => 'categoryTest']);
        factory(Product::class, 10)->create(['category_id' => $category->id]);

        $product = Product::where(['id' => '3'])->first();
        //When
        $response = $this->post(route('cart.store', $product));

        $response
            ->assertRedirect(route('login'))
            ->assertStatus(302);

    }
        private function ActingAsClient(){
        $user = factory(User::class)->create(['role' => 'Cliente']);
        $this->actingAs($user);
        return $user;
    }
}
