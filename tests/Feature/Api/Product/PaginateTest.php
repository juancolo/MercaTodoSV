<?php

namespace Tests\Feature\Api\Product;

use App\Entities\Category;
use App\Entities\Product;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class PaginateTest extends TestCase
{
    use RefreshDatabase;

    private $category;
    private $product;

    protected function setUp(): void
    {
        parent::setUp();
        $this->category = factory(Category::class)->create();

        $this->product = factory(Product::class, 15)->create([
            'category_id' => $this->category->id]);
    }

    /** @test */
    public function cant_fetch_paginate_products()
    {
        $url = route('api.v1.products.index', ['page[size]' => 2, 'page[number]' => 3]);

        $response = $this->getJson($url);

        $response->assertJsonCount(2, 'data');
        $response->assertDontSee($this->product[0]->name);
        $response->assertDontSee($this->product[1]->name);
        $response->assertDontSee($this->product[2]->name);
        $response->assertDontSee($this->product[3]->name);
        $response->assertSee($this->product[4]->name);
        $response->assertSee($this->product[5]->name);
        $response->assertDontSee($this->product[6]->name);
        $response->assertDontSee($this->product[7]->name);
        $response->assertDontSee($this->product[8]->name);
        $response->assertDontSee($this->product[9]->name);
        $response->assertDontSee($this->product[10]->name);

        $response->assertJsonFragment([
            'first' => route('api.v1.products.index', ['page[size]' => 2, 'page[number]' => 1]),
            'last' => route('api.v1.products.index', ['page[size]' => 2, 'page[number]' => 8]),
            'prev' => route('api.v1.products.index', ['page[size]' => 2, 'page[number]' => 2]),
            'next' => route('api.v1.products.index', ['page[size]' => 2, 'page[number]' => 4])
        ]);
    }
}
