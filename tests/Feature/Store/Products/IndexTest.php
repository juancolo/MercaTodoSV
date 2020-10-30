<?php

namespace Tests\Feature\Store\Products;

use App\Entities\Category;
use App\Entities\Product;
use Tests\Feature\ProductTest;
use Tests\TestCase;
use App\Entities\User;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class IndexTest extends TestCase
{
    protected $category;
    protected $products;

    use RefreshDatabase;
    use WithFaker;

    protected function setUp(): void
{
    parent::setUp();

    $this->category = factory(Category::class)->create();

    $this->products = factory(Product::class,15)->create(['category_id'=>$this->category->id]);
}

    /**
     * @test
     */
    public function auth_client_can_see_the_product_index()
    {
        $products = $this->products;
        $this->actingAs($this->ActingAsClient());
        $this->get(route('client.product'))
            ->assertOk()
            ->assertViewHasAll(['products'])
            ->assertSee('Category');
    }

    /**
     * @test
     */
    public function an_non_authenticated_user_cant_see_product_index()
    {
        $response = $this->get(route('cart.index'));
        $response->assertStatus(302);
        $response->assertRedirect(route('login'));
    }

    private function ActingAsClient()
    {
        return factory(User::class)->create(['role' => 'Cliente']);
    }
}
