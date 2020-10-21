<?php

namespace Tests\Feature\Store\Cart;

use App\Tag;
use App\User;
use App\Product;
use App\Category;
use Tests\TestCase;
use Illuminate\Support\Str;
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
        //Assert
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

    private function CreateProduct(Category $category, Tag $tag)
    {
        return Product::create([
            'name'=>'ProductTest',
            'slug'=>'producttest',
            'details'=>'ProductDetail',
            'description'=>'ProductDescription',
            'actual_price'=> 1000,
            'category_id' => $category->id,
            'tag_id' => $tag->id,
            'stock' => 10,
        ]);
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
