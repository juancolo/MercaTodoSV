<?php

namespace Tests\Feature\Api\Product;

use Laravel\Sanctum\Sanctum;
use Tests\TestCase;
use App\Entities\User;
use App\Entities\Product;
use App\Entities\Category;
use App\Constants\UserRoles;
use Illuminate\Foundation\Testing\RefreshDatabase;

class DeleteTest extends TestCase
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
    public function an_unauthenticated_user_can_not_delete_products()
    {
        $this->assertDatabaseHas('products',['name' => $this->product->name]);

        $this->jsonApi()
            ->content([
                'data' => [
                    'type' => 'products',
                    'id' => $this->product->slug,
                    ]
                ])
            ->delete(route('api.v1.products.update', $this->product))
            ->assertStatus(401);

        $this->assertDatabaseHas('products',['name' => $this->product->name]);

    }

    /** @test */
    public function power_user_can_not_delete_products()
    {
        Sanctum::actingAs(
            factory(User::class)->create(['role'=> UserRoles::POWERUSER]));

        $this->assertDatabaseHas('products',['name' => $this->product->name]);

        $this->jsonApi()
            ->content([
                'data' => [
                    'type' => 'products',
                    'id' => $this->product->slug,
                ]
            ])
            ->delete(route('api.v1.products.update', $this->product))
            ->assertStatus(403);

        $this->assertDatabaseHas('products', ['name' => $this->product->name]);
    }

    /** @test */
    public function an_admin_user_can_delete_products()
    {
        $this->actingAsAuthUser();

        $this->assertDatabaseHas('products',['name' => $this->product->name]);

        $this->jsonApi()
            ->content([
                'data' => [
                    'type' => 'products',
                    'id' => $this->product->slug,
                ]
            ])
            ->delete(route('api.v1.products.update', $this->product))
            ->assertStatus(204)
            ->assertDeleted();

        $this->assertDatabaseMissing('products', $this->product->toArray());
    }

    public function actingAsAuthUser(): void
    {
        Sanctum::actingAs(
            factory(User::class)->create(['role'=> UserRoles::ADMINISTRATOR]));
    }
}
