<?php

namespace Tests\Feature\Api\Product;

use Tests\TestCase;
use App\Entities\User;
use App\Entities\Product;
use App\Entities\Category;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\RefreshDatabase;

class SortTest extends TestCase
{
    use RefreshDatabase;

    private $product3;
    private $product1;
    private $product2;
    private $category1;
    private $category2;
    private $category3;

    protected function setUp(): void
    {
        parent::setUp();
        $this->category = factory(Category::class)->create();

        $this->product1 = factory(Product::class)->create([
            'name' => 'C Product',
            'category_id' => $this->category->id,
            'details' => 'A Detail']);
        $this->product2 = factory(Product::class)->create([
            'name' => 'A Product',
            'category_id' => $this->category->id,
            'details' => 'C Detail']);
        $this->product3 = factory(Product::class)->create([
            'name' => 'B Product',
            'category_id' => $this->category->id,
            'details' => 'B Detail']);
    }

    /** @test */
    public function an_unauthenticated_can_not_sort_products()
    {
        $this->jsonApi()
            ->filter(['sort' => 'name'])
            ->get(route('api.v1.products.index'))
            ->assertStatus(401)
            ->assertDontSee($this->product2['name']);
    }

    /** @test */
    public function an_authenticated_user_can_sort_product_by_name_asc()
    {
        $this->actingAsAuthUser();

        $url = route('api.v1.products.index', ['sort' => 'name']);
        $this->jsonApi()->get($url)->assertSeeInOrder([
            $this->product2['name'],
            $this->product3['name'],
            $this->product1['name']
        ]);
    }

    /** @test */
    public function an_authenticated_user_can_sort_product_by_name_desc()
    {
        $this->actingAsAuthUser();

        $url = route('api.v1.products.index', ['sort' => '-name']);
        $this->jsonApi()->get($url)->assertSeeInOrder([
            $this->product1['name'],
            $this->product3['name'],
            $this->product2['name']
        ]);
    }

    /** @test */
    public function an_authenticated_user_can_sort_product_by_name_and_category()
    {
        $this->actingAsAuthUser();

        $url = route('api.v1.products.index', ['sort' => 'name,details']);

        $this->jsonApi()->get($url)->assertSeeInOrder([
            'A Product',
            'B Product',
            'C Product',
        ]);

        $url = route('api.v1.products.index', ['sort' => 'details,name']);

        $this->jsonApi()->get($url)->assertSeeInOrder([
            'A Detail',
            'B Detail',
            'C Detail',
        ]);
    }

    /** @test */
    public function an_authenticated_user_can_not_sort_products_by_a_unknown_field()
    {
        $this->actingAsAuthUser();

        $url = route('api.v1.products.index', ['sort' => 'unknown']);

        $this->jsonApi()->get($url)->assertStatus(400);
    }

    public function actingAsAuthUser(): void
    {
        Sanctum::actingAs(
            factory(User::class)->create());
    }
}
