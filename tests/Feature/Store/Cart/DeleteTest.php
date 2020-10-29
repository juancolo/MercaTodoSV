<?php

namespace Tests\Feature\Store\Cart;

use Tests\TestCase;
use Illuminate\Support\Facades\Auth;

class DeleteTest extends TestCase
{
    /**
     * @test
     */

    public function auth_client_can_see_the_cart()
    {
        $this->withoutExceptionHandling();
        //Arrange
        $this->actingAs($this->ActingAsClient());
        $product = $this->CreateProduct
        (
            $this->CreateCategory(),
            $this->CreateTag()
        );

        $this->actingAs($this->ActingAsClient());
        $response = $this->from(route('client.product.specs', $product))
            ->post(route('cart.store', $product));
        $this->assertCount(1, \Cart::getContent());

        //When
        $user = Auth::id();
        $response = $this->get(route('cart.index'));
        $response->assertSee($product->name);
        $response->assertSee(\Cart::session($user)->getTotal());
        $response->assertSee('Modify');
        $response->assertSee('Pay');
        $response->assertOk();

    }
}
