<?php

namespace Tests\Feature\Store\Cart;

use Tests\TestCase;
use App\Entities\User;
use App\Entities\Category;
use Tests\Feature\ProductTest;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class DeleteTest extends TestCase
{
    use RefreshDatabase;
    use WithFaker;

    protected $product;
    protected $category;

    protected function setUp(): void
{
    parent::setUp();

    $this->category = factory(Category::class)->create();
    $this->product = ProductTest::createProduct($this->category);
}

    /**
     * @test
     */
    public function auth_client_can_delete_the_cart()
    {
        $this->ActingAsClient();
        $this->post(route('cart.store', $this->product));
        $this->assertCount(1, \Cart::getContent());

        $this->from(route('cart.index'))
            ->delete(route('cart.destroy', $this->product->id))
            ->assertStatus(302)
            ->assertRedirect(route('cart.index'))
            ->assertSessionHas('status', 'Producto eliminado del carrito adecuadamente');
        $this->assertCount(0, \Cart::getContent());
    }

    /**
     * @test
    */
    public function  a_non_auth_user_cant_delete_products_to_the_cart()
    {
        $this->from(route('cart.index'))
            ->delete(route('cart.destroy', $this->product->id))
            ->assertRedirect(route('login'));
    }

    public function ActingAsClient()
    {
        $user = factory(User::class)->create(['role' => 'Cliente']);
        $this->actingAs($user);
    }
}
