<?php

namespace Tests\Feature\Api\Product;

use Tests\TestCase;
use App\Entities\Product;
use App\Entities\Category;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ShowTest extends TestCase
{
    private $category;
    private $products;

    use RefreshDatabase;
    use WithFaker;

    protected function setUp(): void
    {
        parent::setUp();
        $this->category = factory(Category::class)->create();
        $this->products = factory(Product::class, 15)->create(['category_id' => $this->category->id]);
    }

    /** @test */
    public function it_can_fetch_a_single_product()
    {
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
}
