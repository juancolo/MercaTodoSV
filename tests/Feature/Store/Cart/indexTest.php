<?php

namespace Tests\Feature\Store\Cart;

use App\Entities\Category;
use App\Entities\Product;
use App\Entities\Tag;
use App\Entities\User;
use Tests\TestCase;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class indexTest extends TestCase
{
    use WithFaker;
    use RefreshDatabase;

    /**
     * @test
     */
    public function auth_client_can_see_the_cart()
    {
        $this->actingAs($this->ActingAsClient());
        $product = $this->CreateProduct
            (
                $this->CreateCategory(),
                $this->CreateTag()
            );

        $this->actingAs($this->ActingAsClient());
        $this->from(route('client.product.specs', $product))
             ->post(route('cart.store', $product));

        $this->assertCount(1, \Cart::getContent());

        $user = Auth::id();
        $response = $this->get(route('cart.index'));

        $response->assertSee($product->name);
        $response->assertSee(\Cart::session($user)->getTotal());
        $response->assertSee('Modify');
        $response->assertSee('Pay');
        $response->assertOk();
    }

    /**
     * @test
     */
    public function an_non_authenticated_user_cant_see_a_cart()
    {
        $response = $this->get(route('cart.index'));
        $response->assertStatus(302);
        $response->assertRedirect(route('login'));
    }

    private function ActingAsClient()
    {
        return factory(User::class)->create(['role' => 'Cliente']);
    }



    private function CreateCategory(){
        $category = factory(Category::class)->create(['name' => 'categoryTest']);
        return $category;
    }

    private function CreateTag(){
        $tag = factory(Tag::class)->create(['name' => 'tagTest1']);
        return $tag;
    }
}
