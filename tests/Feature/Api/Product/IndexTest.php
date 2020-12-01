<?php

namespace Tests\Feature\Api\Product;

use App\Entities\Category;
use App\Entities\Product;
use App\Http\Resources\ProductResource;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class IndexTest extends TestCase
{
    private $category;
    private $products;

    use RefreshDatabase;
    use WithFaker;

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
        $response = $this->getJson(route('api.v1.products.index'));

        $response->assertJsonFragment([
            'data' => [
                [
                    'type' => 'product',
                    'id' => $products[0]->getRouteKey(),
                    'attributes' => [
                        'name' => $products[0]->name,
                        'slug' => $products[0]->slug,
                        'details' => $products[0]->details,
                        'category' => $products[0]->category->name,
                        'description' => $products[0]->description
                    ],
                    'link' => [
                        'self' => route('api.v1.products.show', $products[0])
                    ]
                ],
                [
                    'type' => 'product',
                    'id' => $products[1]->getRouteKey(),
                    'attributes' => [
                        'name' => $products[1]->name,
                        'details' => $products[1]->details,
                        'category' => $products[1]->category->name,
                        'slug' => $products[1]->slug,
                        'description' => $products[1]->description
                    ],
                    'link' => [
                        'self' => route('api.v1.products.show', $products[1])
                    ]
                ],
                [
                    'type' => 'product',
                    'id' => $products[2]->getRouteKey(),
                    'attributes' => [
                        'name' => $products[2]->name,
                        'slug' => $products[2]->slug,
                        'details' => $products[2]->details,
                        'category' => $products[2]->category->name,
                        'description' => $products[2]->description
                    ],
                    'link' => [
                        'self' => route('api.v1.products.show', $products[2])
                    ]
                ],
            ]
        ]);

        $response->assertJsonStructure([
            'links'=>[],
            'meta'=>[]
        ]);
    }
}
