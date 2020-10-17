<?php

namespace Tests\Feature\Admin\Product\Admin\Product;

use App\Category;
use App\Product;
use App\Tag;
use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class EditProductTest extends TestCase
{
    use RefreshDatabase, WithFaker;
    /**
     * A basic feature test example.
     *
     * @return void
     */
    /** @test */

    public function only_admins_can_see_the_product_edit_view()
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

    private function CreateCategory(){
        $category = factory(Category::class)->create(['name' => 'categoryTest']);
        return $category;
    }

    private function CreateTag(){
        $tag = factory(Tag::class)->create(['name' => 'tagTest1']);
        return $tag;
    }
}
