<?php

namespace Tests\Feature\Api\Product;

use App\Entities\Category;
use App\Entities\Product;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class FilterTest extends TestCase
{
    use RefreshDatabase;

    private $category;

    protected function setUp(): void
    {
        parent::setUp();

        $this->category = factory(Category::class)->create();

        factory(Product::class)->create([
            'name' => 'Food',
            'category_id' => $this->category->id
        ]);

        factory(Product::class)->create([
            'name' => 'Vehicle',
            'category_id' => $this->category->id
        ]);
    }

    /** @test */
    public function can_filter_products_by_name()
    {
        $url = route('api.v1.products.index', ['filters[name]' => 'Food']);

        $this->getJson($url)
            ->assertJsonCount(1, 'data')
            ->assertSee('Food')
            ->assertDontSee('Vehicle');
    }
}
