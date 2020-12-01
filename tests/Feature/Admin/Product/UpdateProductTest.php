<?php

namespace Tests\Feature\Admin\Product;

use App\Entities\Product;
use App\Http\Requests\Product\UpdateProductRequest;
use Tests\TestCase;
use App\Entities\User;
use App\Entities\Category;
use Tests\Feature\ProductTest;
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
        $product = factory(Product::class)->create(
            [
                'name' => 'ProductTest',
                'slug' => 'producttest',
                'details' => 'ProductDetail',
                'description' => 'ProductDescription',
                'actual_price' => 1000,
                'category_id' => $this->CreateCategory(),
                'stock' => 10,
            ]);
        $this->assertDatabaseHas('products', ['name' => $product->name]);

        $response = $this->put(route('product.update', $product), $this->data());

        $product->fresh();
        $this->assertDatabaseHas('products', ['name' => 'Test Edit Name']);
        $response->assertStatus(302);
    }

    private function CreateCategory()
    {
        $category = factory(Category::class)->create(['name' => 'categoryTest']);
        return $category;
    }

    public function data()
    {
        return [
            'name' => 'Test Edit Name',
            'slug' => 'testeditslug',
        ];
    }
}
