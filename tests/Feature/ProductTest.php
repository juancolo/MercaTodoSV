<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ProductTest extends TestCase
{
    use WithFaker, RefreshDatabase;

    /** @test */

    public function anAdminCanCreateAProduct()
    {
        $this->withoutExceptionHandling();

        $product= [
            'name' => $this->faker->firstName,
            'details' => $this->faker->sentence,
            'slug' => $this->faker->sentence,
            'price' => $this->faker->numberBetween(1000,2000),
            'description' => $this->faker->sentence,
            'category' => $this->faker->numberBetween(1-10),
        ];

        $this->post(route('product.store'), $product)->assertRedirect('/shop');

        $this->assertDatabaseHas('products', $product);

        $this->get('/shop')->assertSee($product['name']);

    }

    /** @test */

    public function aProductRequireAnInformation()
    {
        $this->post('/shop',[])->assertSessionHasErrors('description');
    }

    public function aUserCanViewTheProducts()
    {

    }

}
