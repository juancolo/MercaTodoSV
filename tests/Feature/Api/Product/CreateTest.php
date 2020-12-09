<?php

namespace Tests\Feature\Api\Product;

use App\Constants\UserRoles;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;
use App\Entities\User;
use App\Entities\Product;
use App\Entities\Category;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CreateTest extends TestCase
{
    use RefreshDatabase;

    private $category;

    protected function setUp(): void
    {
        parent::setUp();
        $this->category = factory(Category::class)->create();
    }

    /** @test */
    public function an_unauthenticated_user_can_not_create_products_throw_the_api()
    {
        $product = factory(Product::class)->raw([
            'category_id' => $this->category->id,
            'file' => null]);

        $product = array_filter($product);

        $this->assertDatabaseMissing('products', $product);

        $this->jsonApi()
            ->content([
                'data' => [
                    'type' => 'products',
                    'attributes' => $product
                ]
            ])
            ->post(route('api.v1.products.create'))
            ->assertStatus(401);

        $this->assertDatabaseMissing('products', $product);
    }

    /** @test */
    public function an_authenticated_user_can_create_products_throw_the_api()
    {
        $this->actingAsAuthUser();

        $product = factory(Product::class)->raw([
            'category_id' => $this->category->id,
            'file' => null]);

        $product = array_filter($product);

        $this->assertDatabaseMissing('products', $product);

        $this->jsonApi()
            ->content([
                'data' => [
                    'type' => 'products',
                    'attributes' => $product
                ]
            ])
            ->post(route('api.v1.products.create'))
            ->assertCreated();

        $this->assertDatabaseHas('products', $product);
    }

    /**
     * @test
     * @dataProvider  productRequireDataProvider
     * @param $productInfo
     */
    public function some_information_is_required_to_create_a_product($productInfo)
    {
        $this->actingAsAuthUser();

        $product = factory(Product::class)->raw([
            $productInfo => null]);

        $this->jsonApi()
            ->content([
                'data' => [
                    'type' => 'products',
                    'attributes' => $product
                ]
            ])
            ->post(route('api.v1.products.create'))
            ->assertStatus(422)
            ->assertSee('data\/attributes\/' . $productInfo);

        $this->assertDatabaseMissing('products', $product);
    }

    /**
     * @test
     * @dataProvider  productUniqueDataProvider
     * @param $productInfo
     */
    public function some_information_has_to_be_unique_to_create_a_product($productInfo)
    {
       $this->actingAsAuthUser();

        factory(Product::class)->create([
            $productInfo => 'same',
            'category_id' => $this->category]);

        $product = factory(Product::class)->raw([
            $productInfo => 'same']);

        $this->jsonApi()
            ->content([
                'data' => [
                    'type' => 'products',
                    'attributes' => $product
                ]
            ])
            ->post(route('api.v1.products.create'))
            ->assertStatus(422)
            ->assertSee('data\/attributes\/' . $productInfo);

        $this->assertDatabaseMissing('products', $product);
    }

    /**
     * @test
     * @dataProvider slugValidationProvider
     * @param $slug
     * @param $message
     */
    public function the_slug_field_can_not_have_some_special_charts($slug, $message)
    {
        $this->actingAsAuthUser();

        $product = factory(Product::class)->raw([
            'slug' => $slug,
            'category_id' => $this->category->id,
            'file' => null]);

        $product = array_filter($product);

        $this->jsonApi()
            ->content([
                'data' => [
                    'type' => 'products',
                    'attributes' => $product
                ]
            ])
            ->post(route('api.v1.products.create'))
            ->assertStatus(422)
            ->assertSee(trans($message, ['attribute' =>'slug']))
            ->assertSee('data\/attributes\/slug');

        $this->assertDatabaseMissing('products', $product);
    }

    public function productRequireDataProvider(): array
    {
        return [
            ['name'],
            ['slug'],
            ['details'],
            ['description'],
            ['actual_price'],
            ['category_id'],
        ];
    }

    public function productUniqueDataProvider(): array
    {
        return [
            ['name'],
            ['slug'],
        ];
    }

    public function slugValidationProvider(): array
    {
        return [
            'Underscore validation' => ['under_scores', 'validation.no_underscores'],
            'starting dashes validation' => ['-dashes', 'validation.starting_dashes'],
            'ending dashes validation' => ['dashes-', 'validation.ending_dashes']
        ];
    }

    public function actingAsAuthUser(): void
    {
        Sanctum::actingAs(
            factory(User::class)->create([
                'role' => UserRoles::ADMINISTRATOR
            ]));
    }
}

