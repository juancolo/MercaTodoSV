<?php

namespace Tests\Feature\Store\Cart;

use Tests\TestCase;
use App\Entities\User;
use App\Entities\Product;
use App\Entities\Category;
use Tests\Feature\ProductTest;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class StoreTest extends TestCase
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
    public function auth_client_can_see_add_product_to_cart()
    {
        $this->actingAs($this->ActingAsClient());

        $response = $this->from('client.product')
            ->get(route('client.product.specs', $this->product));

        $response->assertStatus(200);
        $response->assertSee('Add to Cart');
        $response->assertSee($this->product->name);
        $response->assertSee($this->product->price);
    }

    /**
     * @test
     */
    public function a_non_auth_user_cant_see_add_product_to_cart()
    {
        $response = $this->from('client.product')
            ->get(route('client.product.specs', $this->product));

        $response->assertStatus(302);
        $response->assertRedirect(route('login'));
    }

    /**
     * @test
     */
    public function an_authenticated_user_can_add_a_product_to_the_cart()
    {
        factory(Product::class, 10)->create(['category_id' => $this->category->id]);
        $product = Product::where(['id' => '3'])->first();
        $this->actingAs($this->ActingAsClient());

        $this->from(route('client.product.specs', $product))
            ->post(route('cart.store', $product))
            ->assertStatus(302)
            ->assertRedirect(route('client.product.specs', $product));

        $this->assertCount(1, \Cart::getContent());
    }

    /**
     * @test
     */
    public function an_unauthenticated_user_cant_store_a_product_into_the_cart()
    {
        factory(Product::class, 10)->create(['category_id' => $this->category->id]);
        $product = Product::where(['id' => '3'])->first();

        $this->post(route('cart.store', $product))
            ->assertRedirect(route('login'))
            ->assertStatus(302);

        $this->assertCount(0, \Cart::getContent());
    }

        private function ActingAsClient()
    {
        $user = factory(User::class)->create(['role' => 'Cliente']);
        return $user;
    }
}
