<?php

namespace Tests\Feature\Store\Cart;

use Tests\TestCase;
use App\Entities\User;
use App\Entities\Category;
use Tests\Feature\ProductTest;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class IndexTest extends TestCase
{
    protected $product;
    protected $category;

    use WithFaker;
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->category = factory(Category::class)->create(['name' => 'categoryTest']);
        $this->product = ProductTest::createProduct($this->category);
    }


    /**
     * @test
     */
    public function auth_client_can_see_the_cart_when_it_has_not_products()
    {
        $this->actingAs($this->ActingAsClient());

        $this->actingAs($this->ActingAsClient());
        $this->get(route('cart.index'))
            ->assertOK()
            ->assertSee('There is no products into the Cart');
    }

    /**
     * @test
     */
    public function auth_client_can_see_the_cart_when_it_has_products()
    {
        $this->actingAs($this->ActingAsClient());
        $this->post(route('cart.store', $this->product));

        $this->get(route('cart.index'))
            ->assertOk()
            ->assertSee($this->product->name)
            ->assertSee(\Cart::session($this->ActingAsClient())->getSubtotal())
            ->assertSee('Pay');
    }

    /**
     * @test
     */
    public function an_non_authenticated_user_cant_see_the_cart()
    {
        $this->get(route('cart.index'))
            ->assertStatus(302)
            ->assertRedirect(route('login'));
    }

    private function ActingAsClient()
    {
        return factory(User::class)->create(['role' => 'Cliente']);
    }
}
