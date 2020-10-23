<?php

namespace Tests\Feature\Store\Products;

use App\Entities\Category;
use App\Entities\Tag;
use App\Entities\User;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class IndexTest extends TestCase
{
    use RefreshDatabase, WithFaker;
    /**
     * @test
     */
    public function auth_client_can_see_the_product_index()
    {
        $this->withoutExceptionHandling();

        $this->actingAs($this->ActingAsClient());
        $response = $this->get(route('client.product'));

        $response->assertOk();
    }

    /**
     * @test
     */
    public function an_non_authenticated_user_cant_see_product_index()
    {
        $response = $this->get(route('cart.index'));
        $response->assertStatus(302);
        $response->assertRedirect(route('login'));
    }

    private function ActingAsClient()
    {
        return factory(User::class)->create(['role' => 'Cliente']);
    }

    private function CreateCategory()
    {
        $category = factory(Category::class)->create(['name' => 'categoryTest']);
        return $category;
    }

    private function CreateTag()
    {
        $tag = factory(Tag::class)->create(['name' => 'tagTest1']);
        return $tag;
    }
}
