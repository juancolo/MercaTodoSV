<?php

namespace Tests\Feature\Api\Product;

use Tests\TestCase;
use App\Entities\User;
use App\Entities\Product;
use App\Entities\Category;
use App\Constants\UserRoles;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\RefreshDatabase;

class UpdateTest extends TestCase
{
    use RefreshDatabase;

    private $product;

    protected function setUp(): void
    {
        parent::setUp();
        $category = factory(Category::class)->create();

        $this->product = factory(Product::class)->create([
            'category_id' => $category->id
        ]);
    }

    /** @test */
    public function an_unauthenticated_user_can_not_update_products()
    {
        $this->assertDatabaseHas('products',['name' => $this->product->name]);

        $this->jsonApi()
            ->content([
                'data' => [
                    'type' => 'products',
                    'id' => $this->product->slug,
                    'attributes' => [
                        'name' => 'Product Update',
                        'slug' => 'product-update',
                        'detail' => 'product-detail updated'
                    ]
                ]
            ])
            ->patch(route('api.v1.products.update', $this->product))
            ->assertStatus(401);

    }

    /** @test */
    public function an_authenticated_user_can_update_products()
    {
        $this->actingAsAuthUser();

        $this->assertDatabaseHas('products',['name' => $this->product->name]);

        $this->jsonApi()
            ->content([
                'data' => [
                    'type' => 'products',
                    'id' => $this->product->getRouteKey(),
                    'attributes' => [
                        'name' => 'Product Update',
                        'slug' => 'product-update',
                        'details' => 'product-detail updated',
                        'category_id' => $this->product->category->id
                    ]
                ]
            ])
            ->patch(route('api.v1.products.update', $this->product))
            ->assertStatus(200);

        $this->assertDatabaseHas('products', [
            'name' => 'Product Update',
            'slug' => 'product-update',
            'details' => 'product-detail updated'
        ]);
    }


    public function actingAsAuthUser(): void
    {
        Sanctum::actingAs(
            factory(User::class)->create(['role'=>UserRoles::ADMINISTRATOR]));
    }
}
