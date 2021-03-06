<?php

namespace Tests\Feature\Api\Product;

use Laravel\Sanctum\Sanctum;
use Tests\TestCase;
use App\Entities\User;
use App\Entities\Product;
use App\Entities\Category;
use App\Constants\UserRoles;
use Illuminate\Foundation\Testing\RefreshDatabase;

class IncludeRelationshipTest extends TestCase
{
    use RefreshDatabase;

    private $product;

    protected function setUp(): void
{
    parent::setUp();
    $category = factory(Category::class)->create();
    $this->product = factory(Product::class)->create([
        'category_id' => $category->id
    ]);
}

    /** @test */
    public function a_product_can_include_category()
    {
       $this->actingAsAdmin();

       $this->jsonApi()
           ->includePaths('categories')
           ->get(route('api.v1.products.read', $this->product))
           ->assertSee($this->product->category->name)
           ->assertJsonFragment([
               'related' => route('api.v1.products.relationships.categories', $this->product)
           ])
           ->assertJsonFragment([
               'self' => route('api.v1.products.relationships.categories.read', $this->product)
           ]);

    }

    /** @test */
    public function can_fetch_the_related_categories_of_a_product()
    {
        $this->actingAsAdmin();

        $this->jsonApi()
            ->get(route('api.v1.products.relationships.categories', $this->product))
            ->assertSee($this->product->category->name);

    }

    public function actingAsAdmin()
    {
        Sanctum::actingAs(
            factory(User::class)->create([
                'role' => UserRoles::ADMINISTRATOR
            ])
        );
    }
}
