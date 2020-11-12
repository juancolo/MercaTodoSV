<?php

namespace Tests\Feature\Admin\Product;

use Tests\TestCase;
use App\Entities\User;
use App\Entities\Product;
use App\Entities\Category;
use Tests\Feature\ProductTest;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class DeleteProductTest extends TestCase
{
    protected $product;
    protected $category;

    use RefreshDatabase;
    use WithFaker;

  protected function setUp(): void
{
    parent::setUp();

    $this->category = factory(Category::class)->create();
    factory(Product::class, 15)->create(['category_id' => $this->category->id]);
    $this->product = ProductTest::createProduct($this->category);
}

    /**
     * @test
     */
    public function an_admin_can_delete_a_product()
    {
        $this->acting('Administrador');
        $this->assertDatabaseHas('products', ['name'=> $this->product->name]);

        $this->delete(route('product.destroy', $this->product))
            ->assertStatus(302)
            ->assertRedirect(route('product.index'));

        $this->assertDeleted('products', array($this->product));
        $this->assertCount(15 , Product::all());
        $this->assertDatabaseMissing('products', ['name'=> $this->product->name]);
    }

    /**
     * @test
    */
    public function a_client_cant_delete_a_product()
    {
        $this->acting('Cliente');
        $this->assertDatabaseHas('products', ['name'=> $this->product->name]);

        $this->delete(route('product.destroy', $this->product))
            ->assertStatus(302)
            ->assertRedirect(route('client.landing'));

        $this->assertCount(16 , Product::all());
        $this->assertDatabaseHas('products', ['name'=> $this->product->name]);
    }

    /**
     * @test
     */
    public function non_authenticated_user_cant_delete_a_product()
    {
        $this->assertDatabaseHas('products', ['name'=> $this->product->name]);

        $this->delete(route('product.destroy', $this->product))
            ->assertStatus(302)
            ->assertRedirect(route('login'));

        $this->assertCount(16 , Product::all());
        $this->assertDatabaseHas('products', ['name'=> $this->product->name]);
    }

    public function acting($user)
    {
        $this->actingAs(factory(User::class)->create(['role' => $user]));
    }
}
