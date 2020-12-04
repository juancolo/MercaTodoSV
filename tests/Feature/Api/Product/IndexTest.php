<?php

namespace Tests\Feature\Api\Product;

use Tests\TestCase;
use App\Entities\User;
use App\Entities\Product;
use App\Entities\Category;
use Laravel\Passport\Passport;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class IndexTest extends TestCase
{
    use RefreshDatabase;
    use WithFaker;

    private $products;

    protected function setUp(): void
    {
        parent::setUp();
        $category = factory(Category::class)->create();
        $this->products = factory(Product::class, 3)->create(['category_id' => $category->id]);
    }

    /** @test */
    public function an_unauthenticated_user_cant_filter_products()
    {
        $this->jsonApi()
            ->get(route('api.v1.products.index'))
            ->assertStatus(401)
            ->assertDontSee($this->products);
    }

    /**
     * @test
     */
    public function a_authenticated_user_can_fetch_all_product()
    {
        $this->actingAsAuthUser();

        $products = $this->products;
        $response = $this->jsonApi()
            ->get(route('api.v1.products.index'));

        $response->assertJsonFragment([
            'data' => [
                [
                    'type' => 'products',
                    'id' => $products[0]->getRouteKey(),
                    'attributes' => [
                        'name' => $products[0]->name,
                        'slug' => $products[0]->slug,
                        'details' => $products[0]->details,
                        'category' => $products[0]->category->name,
                        'description' => $products[0]->description,
                        'created-at' => $products[0]->created_at->toAtomString(),
                        'updated-at' => $products[0]->updated_at->toAtomString(),
                    ],
                    'links' => [
                        'self' => route('api.v1.products.read', $products[0])
                    ]
                ],
                [
                    'type' => 'products',
                    'id' => $products[1]->getRouteKey(),
                    'attributes' => [
                        'name' => $products[1]->name,
                        'details' => $products[1]->details,
                        'category' => $products[1]->category->name,
                        'slug' => $products[1]->slug,
                        'description' => $products[1]->description,
                        'created-at' => $products[1]->created_at->toAtomString(),
                        'updated-at' => $products[1]->updated_at->toAtomString(),
                    ],
                    'links' => [
                        'self' => route('api.v1.products.read', $products[1])
                    ]
                ],
                [
                    'type' => 'products',
                    'id' => $products[2]->getRouteKey(),
                    'attributes' => [
                        'name' => $products[2]->name,
                        'slug' => $products[2]->slug,
                        'details' => $products[2]->details,
                        'category' => $products[2]->category->name,
                        'description' => $products[2]->description,
                        'created-at' => $products[2]->created_at->toAtomString(),
                        'updated-at' => $products[2]->updated_at->toAtomString(),
                    ],
                    'links' => [
                        'self' => route('api.v1.products.read', $products[2])
                    ]
                ],
            ]
        ])->assertSee($this->products[0]['name']);
    }

    public function actingAsAuthUser()
    {
        Passport::actingAs(
            factory(User::class)->create());
    }
}
