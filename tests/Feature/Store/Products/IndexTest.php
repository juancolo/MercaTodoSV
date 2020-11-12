<?php

namespace Tests\Feature\Store\Products;

use App\Entities\Product;
use Tests\TestCase;
use App\Entities\User;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class IndexTest extends TestCase
{
    use RefreshDatabase;
    use WithFaker;
    /**
     * @test
     */
    public function auth_client_can_see_the_product_index()
    {
        factory(Product::class, 15)->create();
        $this->actingAs($this->ActingAsClient());
        $this->get(route('client.product'))
            ->assertOk()
            ->assertViewHasAll(['products'])
            ->assertSee('Category')
            ->assertSee('Product price');
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
