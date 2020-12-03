<?php

namespace Tests\Feature\Api\Product;

use App\Entities\Category;
use App\Entities\Product;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PaginateTest extends TestCase
{
    use RefreshDatabase;

    private $product;

    protected function setUp(): void
    {
        parent::setUp();
        $category = factory(Category::class)->create();

        $this->product = factory(Product::class, 15)->create([
            'category_id' => $category->id]);
    }

    /** @test */
    public function can_fetch_paginate_products()
    {
        $url = route('api.v1.products.index', ['page[number]' => 3, 'page[size]' => 2]);

        $response = $this->jsonApi()->get($url);

        $response->assertJsonCount(2, 'data')
            ->assertDontSee($this->product[0]->name)
            ->assertDontSee($this->product[1]->name)
            ->assertDontSee($this->product[2]->name)
            ->assertDontSee($this->product[3]->name)
            ->assertDontSee($this->product[4]->name)
            ->assertDontSee($this->product[5]->name);

        $response->assertJsonFragment([
            'first' => route('api.v1.products.index', ['page[number]' => 1, 'page[size]' => 2]),
            'last' => route('api.v1.products.index', ['page[number]' => 8, 'page[size]' => 2]),
            'prev' => route('api.v1.products.index', ['page[number]' => 2, 'page[size]' => 2]),
            'next' => route('api.v1.products.index', ['page[number]' => 4, 'page[size]' => 2])
        ]);
    }
}
