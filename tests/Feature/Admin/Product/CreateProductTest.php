<?php

namespace Tests\Feature\Admin\Product;

use Tests\TestCase;
use App\Entities\Tag;
use App\Entities\User;
use App\Entities\Product;
use App\Entities\Category;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;


class CreateProductTest extends TestCase
{
    use WithFaker, RefreshDatabase;

    /**
     * @test
     */
    public function only_admins_can_see_the_product_create_view()
    {
        $this->withoutExceptionHandling();

        $user = factory(User::class)->create(['role' => 'Cliente']);
        $this->actingAs($user);
        $response = $this->get(route('product.create'));
        $response->assertRedirect(route('client.landing'));
        $response->assertStatus(302);
    }

    /**
     * @test
     */
    public function an_admin_can_create_a_product()
    {
        $this->ActingAsAdmin();

        $category = factory(Category::class)->create(['name' => 'categoryTest']);
        $tag1 = factory(Tag::class)->create(['name' => 'tagTest1']);
        $tag2 = factory(Tag::class)->create(['name' => 'tagTest2']);

        $product = ([
            'name' => 'ProductTest',
            'slug' => 'producttest',
            'details' => 'productdetails',
            'actual_price' => 1000,
            'description' => 'productdescription',
            'category_id' => $category->id,
            'tags' => [ 0 => $tag1->id,
                        1 => $tag2->id]
        ]);

        $response = $this->post(route('product.store', $product));

        $this->assertDatabaseHas('products', [
            'name' => 'ProductTest',
            'slug' => 'producttest',
            'details' => 'productdetails',
            'description' => 'productdescription',
            'category_id' => strval($category->id),
        ]);
        $productSaved = Product::where('name', 'ProductTest')->first();

        $this->assertDatabaseHas('product_tag', [
            'product_id' => $productSaved->id,
            'tag_id' => $tag1->id
        ]);

        $this->assertDatabaseHas('product_tag', [
            'product_id' => $productSaved->id,
            'tag_id' => $tag2->id
        ]);

        $response->assertRedirect(route('product.index'));
        $response->assertStatus(302);
    }

    /**
    * @test
     */

    public function a_product_price_must_be_greater_than_zero()
    {
        $this->ActingAsAdmin();
        $category = factory(Category::class)->create(['name' => 'categoryTest']);
        $tag1 = factory(Tag::class)->create(['name' => 'tagTest1']);
        $tag2 = factory(Tag::class)->create(['name' => 'tagTest2']);

        $product = ([
            'name' => 'ProductTest',
            'slug' => 'producttest',
            'details' => 'productdetails',
            'actualPrice' => 0,
            'description' => 'productdescription',
            'category_id' => $category->id,
            'tags' => [ 0 => $tag1->id,
                        1 => $tag2->id]
        ]);

        $response = $this->post(route('product.store', $product));

        $response->assertSessionHasErrors('actual_price');

    }

    public function productCreation(){
            return [
                'name' => 'ProductTest',
                'slug' => 'producttest',
                'details' => 'productdetails',
                'description' => 'productdescription'
            ];
    }

    private function ActingAsAdmin()
    {
        $user = factory(User::class)->create(['role' => 'Administrador']);
        $this->actingAs($user);
    }

}
