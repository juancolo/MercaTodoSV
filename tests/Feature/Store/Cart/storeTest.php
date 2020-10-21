<?php

namespace Tests\Feature\Store\Cart;

use App\Tag;
use App\User;
use App\Product;
use App\Category;
use Illuminate\Support\Facades\Auth;
use Tests\TestCase;
use Darryldecode\Cart\Cart;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class storeTest extends TestCase
{
    use WithFaker;
    use RefreshDatabase;

    /**
     * @test
     */
    public function auth_client_can_see_add_product_to_cart()
    {
        $this->actingAs($this->ActingAsClient());
        $product = $this->CreateProduct(
            $this->CreateCategory(),
            $this->CreateTag()
        );

        $response = $this->from('client.product')
            ->get(route('client.product.specs', $product));

        $response->assertStatus(200);
        $response->assertSee('Add to Cart');
        $response->assertSee($product->name);
        $response->assertSee($product->price);
    }

    /**
     * @test
     */
    public function a_non_auth_user_cant_see_add_product_to_cart()
    {
        $product = $this->CreateProduct
        (
            $this->CreateCategory(),
            $this->CreateTag()
        );

        $response = $this->from('client.product')
            ->get(route('client.product.specs', $product));

        $response->assertStatus(302);
        $response->assertRedirect(route('login'));
    }

    /**
     * @test
     */
    public function an_authenticated_user_can_add_a_product_to_the_cart()
    {
        $category = factory(Category::class)->create(['name' => 'categoryTest']);
        factory(Product::class, 10)->create(['category_id' => $category->id]);

        $product = Product::where(['id' => '3'])->first();
        //When
        $this->actingAs($this->ActingAsClient());
        $response = $this->from(route('client.product.specs', $product))
                    ->post(route('cart.store', $product));

        $cart = new Cart();
        //Assert
        $this->assertCount(1, \Cart::getContent());
        $response->assertRedirect(route('client.product.specs', $product));
        $response->assertStatus(302);

    }

    /**
     * @test
     */
    public function an_unauthenticated_user_cant_store_a_product_into_the_cart()
    {
        //Arrange
        $category = factory(Category::class)->create(['name' => 'categoryTest']);
        factory(Product::class, 10)->create(['category_id' => $category->id]);

        $product = Product::where(['id' => '3'])->first();
        //When
        $response = $this->post(route('cart.store', $product));
        $this->assertCount(0, \Cart::getContent());
        //Assert
        $response
            ->assertRedirect(route('login'))
            ->assertStatus(302);

    }
        private function ActingAsClient()
    {
        $user = factory(User::class)->create(['role' => 'Cliente']);

        return $user;
    }

    private function CreateCategory(){
        $category = factory(Category::class)->create(['name' => 'categoryTest']);
        return $category;
    }

    private function CreateTag(){
        $tag = factory(Tag::class)->create(['name' => 'tagTest1']);
        return $tag;
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
        ]);
    }
}
