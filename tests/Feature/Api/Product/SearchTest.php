<?php

namespace Tests\Feature\Api\Product;

use Tests\TestCase;
use App\Entities\Product;
use App\Entities\Category;
use Illuminate\Foundation\Testing\RefreshDatabase;

class SearchTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        $category = factory(Category::class)->create();

        factory(Product::class, 2)->create([
            'details' => 'Details of the A product MercaTodo',
            'created_at' => now()->month(8)->year(2019),
            'category_id' => $category->id
        ]);

        factory(Product::class)->create([
            'name' => 'B Name',
            'details' => 'Details of the B product Evertec',
            'created_at' => now()->month(8)->year(2020),
            'category_id' => $category->id
        ]);

        factory(Product::class)->create([
            'name' => 'C Name',
            'details' => 'Details of the B product',
            'created_at' => now()->month(8)->year(2020),
            'category_id' => $category->id
        ]);
    }

    /** @test */
    public function can_search_products_by_name_and_details()
    {
        $this->jsonApi()
            ->filter(['search' => 'MercaTodo'])
            ->get(route('api.v1.products.index'))
            ->assertJsonCount(2, 'data')
            ->assertSee('Details of the A product MercaTodo');
    }


    /** @test */
    public function can_search_products_by_name_and_details_with_multiple_terms()
    {
        $this->jsonApi()
            ->filter(['search' => 'MercaTodo Evertec'])
            ->get(route('api.v1.products.index'))
            ->assertJsonCount(3, 'data')
            ->assertSee('Details of the A product MercaTodo')
            ->assertSee('Evertec');
    }
}
