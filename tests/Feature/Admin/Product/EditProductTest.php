<?php

namespace Tests\Feature\Admin\Product\Admin\Product;

use App\Tag;
use App\User;
use App\Product;
use App\Category;
use Tests\TestCase;
use Illuminate\Support\Str;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class EditProductTest extends TestCase
{
    use RefreshDatabase, WithFaker;
    /**
     * A basic feature test example.
     *
     * @return void
     */
    /** @test */

    public function a_client_cant_see_the_product_edit_view()
    {
        $this->withoutExceptionHandling();

        $user = factory(User::class)->create(['role' => 'Cliente']);

        $this->actingAs($user);
        $category = $this->CreateCategory();
        $this->CreateTag();
        $product = factory(Product::class)
                   ->create([
                       'name'=>'ProductTest',
                       'category_id' => $category->id
                           ]);

        $response = $this->get(route('product.edit', compact('product')));

        $response->assertRedirect(route('client.landing'));
        $response->assertStatus(302);
    }

    /**
     * @test
     */
    public function an_admin_can_see_the_product_edit_view()
    {
        $this->withoutExceptionHandling();

        $user = factory(User::class)->create(['role' => 'Administrador']);

        $this->actingAs($user);
        $product = $this->CreateProduct
            (
                $this->CreateCategory(),
                $this->CreateTag()
            );

        $response = $this->get(route('product.edit', compact('product')));

        $response->assertSee($product->name);
        $response->assertSee($product->category->name);
        $response->assertSee($product->category->old_price);
        $response->assertSee($product->actual_price);
        $response->assertSee($product->slug);
        $response->assertStatus(200);
    }

    /**
     * @test
     */
    public function admins_can_edit_an_existing_product()
    {
        //Arrange
        $user = factory(User::class)->create(['role' => 'Administrador']);
        $this->actingAs($user);
        $existProduct = $this->CreateProduct
            (
                $this->CreateCategory(),
                $this->CreateTag()
            );
        $this->assertDatabaseHas('products', ['name' => $existProduct->name]);
        //When
        $product = $this->EditProduct($existProduct);
        $response = $this->get(route('product.update', compact('product')));
        //Assert
        $this->assertDatabaseHas('products', ['name'=> $product->name]);
        $response->assertStatus(200);
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
            'stock'=> 100,
            'category_id' => $category->id,
            'tag_id' => $tag->id,
        ]);
    }

    private function EditProduct(Product $product)
    {
        $product->name = 'ProdcutEditName';
        $product->slug = Str::slug($product->name);
        $product->save();
        return $product;
    }
}