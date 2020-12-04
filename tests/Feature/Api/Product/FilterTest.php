<?php

namespace Tests\Feature\Api\Product;

use Tests\TestCase;
use App\Entities\User;
use App\Entities\Product;
use App\Entities\Category;
use Laravel\Passport\Passport;
use Illuminate\Foundation\Testing\RefreshDatabase;

class FilterTest extends TestCase
{
    use RefreshDatabase;

    private $product2;
    private $product1;

    protected function setUp(): void
    {
        parent::setUp();

        $category = factory(Category::class)->create();

        $this->product1 = factory(Product::class)->create([
            'name' => 'Food',
            'details' => 'Details 3',
            'created_at' => now()->month(8)->year(2019),
            'category_id' => $category->id
        ]);

        $this->product2 = factory(Product::class)->create([
            'name' => 'Vehicle',
            'details' => 'Details 4',
            'created_at' => now()->month(7)->year(2020),
            'category_id' => $category->id
        ]);
    }

    /** @test */
    public function an_unauthenticated_user_cant_filter_products()
    {
        $this->jsonApi()
            ->filter(['name' => 'Food'])
            ->get(route('api.v1.products.index'))
            ->assertStatus(401);
    }

    /** @test */
    public function an_authenticated_user_can_filter_products_by_name()
    {
        $this->actingAsAuthUser();

        $this->jsonApi()
            ->filter(['name' => 'Food'])
            ->get(route('api.v1.products.index'))
            ->assertJsonCount(1, 'data')
            ->assertSee('Food')
            ->assertDontSee('Vehicle');
    }

    /** @test */

    public function an_authenticated_user_can_filter_product_by_detail()
    {
        $this->actingAsAuthUser();

        $this->jsonApi()
            ->filter(['details' => '3'])
            ->get(route('api.v1.products.index'))
            ->assertJsonCount(1, 'data')
            ->assertSee('Details 3')
            ->assertDontSee('Details 4');
    }

    /** @test */

    public function an_authenticated_user_can_filter_product_by_month()
    {
        $this->actingAsAuthUser();

        $this->jsonApi()
            ->filter(['month' => 8])
            ->get(route('api.v1.products.index'))
            ->assertJsonCount(1, 'data')
            ->assertSee('Details 3')
            ->assertDontSee('Details 4');
    }

    /** @test */

    public function an_authenticated_user_can_filter_product_by_year()
    {
        $this->actingAsAuthUser();

        $this->jsonApi()
            ->filter(['year' => 2020])
            ->get(route('api.v1.products.index'))
            ->assertJsonCount(1, 'data')
            ->assertSee('2020')
            ->assertDontSee('2019');
    }

    /** @test */

    public function an_authenticated_user_can_not_filter_product_by_unknown_field()
    {
        $this->actingAsAuthUser();

        $this->jsonApi()
            ->filter(['unknown' => 'unknown'])
            ->get(route('api.v1.products.index'))
            ->assertStatus(400);
    }

    public function actingAsAuthUser(): void
    {
        Passport::actingAs(
            factory(User::class)->create());
    }
}
