<?php

namespace Tests\Feature\Admin\Product;

use App\Category;
use App\Tag;
use App\User;
use App\Product;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;


class CreateProductTest extends TestCase
{
    use WithFaker, RefreshDatabase;

    /** @test */

    public function onlyAdminsCanSeeTheProductCreateView()
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
    public function anAdminCanCreateAProduct()
    {
        $this->withoutExceptionHandling();

        //Given => An a Authenticated User can Edit an existing product
        $this->ActingAsAdmin();
        //When

        $category = factory(Category::class)->create(['name' => 'categoryTest']);
        $tag1 = factory(Tag::class)->create(['name' => 'tagTest1']);
        $tag2 = factory(Tag::class)->create(['name' => 'tagTest2']);

        $product = ([
            'name' => 'ProductTest',
            'slug' => 'producttest',
            'details' => 'productdetails',
            'description' => 'productdescription',
            'category_id' => $category->id,
            'tags' => [ 0 => $tag1->id,
                        1 => $tag2->id]
        ]);

        $response = $this->post(route('product.store', $product));

        //Then
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
        // inyección de código <script> alert('test') </script>*/
    }

    /**
    * @test
     */

    public function aProductPriceMustBeGreaterThanZero()
    {
        $this->withoutExceptionHandling();

        //Given => An a authenticated admin can edit an existing product
        $this->ActingAsAdmin();
        $category = factory(Category::class)->create(['name' => 'categoryTest']);

        //Assert


        $response = $this->post(route('product.store'), array_merge($this->productCreation(), ['actual_price' => '100']));

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

private function ActingAsAdmin(){
    $user = factory(User::class)->create(['role' => 'Administrador']);
    $this->actingAs($user);
}
}