<?php

namespace Tests\Feature\Api\Product;

use App\Entities\Category;
use App\Entities\Product;
use CloudCreativity\LaravelJsonApi\Testing\MakesJsonApiRequests;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class FilterTest extends TestCase
{
    use RefreshDatabase;

    private $product;

    protected function setUp(): void
    {
        parent::setUp();

        $category = factory(Category::class)->create();

        $this->product = factory(Product::class)->create([
            'name' => 'Food',
            'details' => 'Details 3',
            'created_at' => now()->month(8)->year(2019),
            'category_id' => $category->id
        ]);

        factory(Product::class)->create([
            'name' => 'Vehicle',
            'details' => 'Details 4',
            'created_at' => now()->month(7)->year(2020),
            'category_id' => $category->id
        ]);
    }

    /** @test */
    public function can_filter_products_by_name()
    {
        /*$url = route('api.v1.products.index', ['filters[name]' => 'Food']);*/

        $this->jsonApi()
            ->filter(['name' => 'Food'])
            ->get(route('api.v1.products.index'))
            ->assertJsonCount(1, 'data')
            ->assertSee('Food')
            ->assertDontSee('Vehicle');
    }

    /** @test */

    public function can_filter_product_by_detail()
    {
        $this->jsonApi()
            ->filter(['details' => '3'])
            ->get(route('api.v1.products.index'))
            ->assertJsonCount(1, 'data')
            ->assertSee('Details 3')
            ->assertDontSee('Details 4');
    }

    /** @test */

    public function can_filter_product_by_month()
    {
        $this->jsonApi()
            ->filter(['month' => 8])
            ->get(route('api.v1.products.index'))
            ->assertJsonCount(1, 'data')
            ->assertSee('Details 3')
            ->assertDontSee('Details 4');
    }

    /** @test */

    public function can_filter_product_by_year()
    {
        $this->jsonApi()
            ->filter(['year' => 2020])
            ->get(route('api.v1.products.index'))
            ->assertJsonCount(1, 'data')
            ->assertSee('2020')
            ->assertDontSee('2019');
    }

    /** @test */

    public function can_not_filter_product_by_unknown_field()
    {
        $this->jsonApi()
            ->filter(['unknown' => 'unknown'])
            ->get(route('api.v1.products.index'))
            ->assertStatus(400);
    }
}
