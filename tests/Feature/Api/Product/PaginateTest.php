<?php

namespace Tests\Feature\Api\Product;

use Tests\TestCase;
use App\Entities\User;
use App\Entities\Product;
use App\Entities\Category;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\RefreshDatabase;

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
    public function a_unauthenticated_user_can_not_fetch_paginate_products()
    {
        $this->jsonApi()
            ->get(route('api.v1.products.index', ['page[number]' => 3, 'page[size]' => 2]))
            ->assertStatus(401);
    }

    /** @test */
    public function can_fetch_paginate_products()
    {
        $this->actingAsAuthUser();

        $response = $this->jsonApi()
            ->sort('data')
            ->get(route('api.v1.products.index', ['page[number]' => 3, 'page[size]' => 2]));

        echo $this->product;
        $response->assertJsonCount(2, 'data');

        $response->assertJsonFragment([
            'first' => route('api.v1.products.index', ['page[number]' => 1, 'page[size]' => 2]),
            'last' => route('api.v1.products.index', ['page[number]' => 8, 'page[size]' => 2]),
            'prev' => route('api.v1.products.index', ['page[number]' => 2, 'page[size]' => 2]),
            'next' => route('api.v1.products.index', ['page[number]' => 4, 'page[size]' => 2])
        ]);
    }

    public function actingAsAuthUser()
    {
        Sanctum::actingAs(
            factory(User::class)->create());
    }
}
