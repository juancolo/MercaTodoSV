<?php

namespace Tests\Feature\Admin\Product;

use Tests\TestCase;
use App\Entities\Tag;
use App\Entities\User;
use App\Entities\Product;
use App\Entities\Category;
use Illuminate\Support\Str;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class UpdateProductTest extends TestCase
{
    use WithFaker, RefreshDatabase;
    /**
     * @test
     */
    public function admins_can_update_an_existing_product()
    {
        $this->withoutExceptionHandling();
        $user = factory(User::class)->create(['role' => 'Administrador']);

        $this->actingAs($user);
        $product = $this->CreateProduct
            (
                $this->CreateCategory(),
                $this->CreateTag()
            );

        $this->assertDatabaseHas('products', ['name' => $product->name]);

        $product = $this->EditProduct($product);
        $response = $this->get(route('product.update', compact('product')));

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
