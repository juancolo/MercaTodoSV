<?php

namespace Tests\Feature\Api\Product;

use _HumbugBox50262afef792\React\Http\Io\UploadedFile;
use Tests\TestCase;
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
    public function can_create_products()
    {
        $this->withExceptionHandling();
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
            ->post(route('api.v1.products.create'))->assertCreated();

        $this->assertDatabaseHas('products', $product);
    }

    /**
     * @test
     * @dataProvider  productRequireDataProvider
     */
    public function some_information_is_required_to_create_a_product($productInfo)
    {
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
     */
    public function some_information_has_to_be_unique_to_create_a_product($productInfo)
    {
        $product = factory(Product::class)->create([
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

    public function productRequireDataProvider()
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

    public function productUniqueDataProvider()
    {
        return [
            ['name'],
            ['slug'],
        ];
    }
}
