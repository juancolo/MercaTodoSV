<?php

namespace Tests\Feature\Store\Payment;

use Tests\TestCase;
use App\Entities\User;
use App\Entities\Category;
use Tests\Feature\CartTest;
use Tests\Feature\ProductTest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class IndexTest extends TestCase
{
    protected $category;
    protected $product;

    use RefreshDatabase;
    use WithFaker;

    public function setUp(): void
    {
        parent::setUp();

        $this->category = factory(Category::class)->create();
        $this->product = ProductTest::createProduct($this->category);
    }

    /**
     * @test
     */
  public function auth_client_can_see_the_index_payment()
  {
      $this->actingAs($this->ActingAsClient());
      $user = Auth::id();
      CartTest::createCart($user, $this->product);

      $this->get(route('payment.index', $user ))
            ->assertStatus(200)
            ->assertSee('Continue to checkout')
            ->assertSee('Mobile');
  }

    /**
     * @test
     */
    public function a_non_auth_user_cant_see_the_index_payment()
  {
      $user = 1;
      $response = $this->get(route('payment.index', $user));
      $response->assertStatus(404);
  }

    private function ActingAsClient()
    {
        return factory(User::class)->create(['role' => 'Cliente']);
    }

}
