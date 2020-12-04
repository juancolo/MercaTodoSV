<?php

namespace Tests\Feature\Api\Product;

use Tests\TestCase;
use App\Entities\User;
use App\Entities\Product;
use App\Entities\Category;
use Laravel\Passport\Passport;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ShowTest extends TestCase
{
    use RefreshDatabase;
    use WithFaker;

    protected function setUp(): void
    {
        parent::setUp();
        $category = factory(Category::class)->create();
        factory(Product::class, 15)->create(['category_id' => $category->id]);
    }

    /** @test */
    public function an_unauthenticated_can_not_fetch_a_single_product()
    {
        $product = Product::all()->last();

        $this->jsonApi()
            ->filter(['sort' => 'name'])
            ->get(route('api.v1.products.index', $product))
            ->assertStatus(401);
    }

    /** @test */
    public function an_authenticated_can_fetch_a_single_product()
    {
        $this->actingAsAuthUser();

        $product = Product::all()->last();

        $this->jsonApi()->get(route('api.v1.products.read', $product))
            ->assertExactJson([
                'data' =>
                    [
                        'type' => 'products',
                        'id' => $product->getRouteKey(),
                        'attributes' => [
                            'name' => $product->name,
                            'slug' => $product->slug,
                            'details' => $product->details,
                            'category' => $product->category->name,
                            'description' => $product->description,
                            'created-at' => $product->created_at->toAtomString(),
                            'updated-at' => $product->updated_at->toAtomString(),
                        ],
                        'links' => [
                            'self' => route('api.v1.products.read', $product)
                        ]
                    ]
            ]);
    }

    public function actingAsAuthUser(): void
    {
        Passport::actingAs(
            factory(User::class)->create());
    }
}
