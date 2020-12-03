<?php

namespace Tests\Feature\Api\Product;

use App\Entities\Category;
use App\Entities\Product;
use App\Http\Resources\ResourceObject;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class IndexTest extends TestCase
{
    use RefreshDatabase;
    use WithFaker;

    private $category;
    private $products;

    protected function setUp(): void
    {
        parent::setUp();
        $this->category = factory(Category::class)->create();
        $this->products = factory(Product::class, 3)->create(['category_id' => $this->category->id]);
    }

    /**
     * @test
     */
    public function can_fetch_all_product()
    {
        $products = $this->products;
        $response = $this->jsonApi()->get(route('api.v1.products.index'));

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
        ]);
    }
}
