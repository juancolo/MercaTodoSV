<?php

namespace Tests\Feature\Store\Payment;

use App\Entities\Category;
use App\Entities\Product;
use App\Entities\Tag;
use App\Entities\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Auth;
use Tests\Feature\CartTest;
use Tests\Feature\ProductTest;
use Tests\TestCase;

class indexTest extends TestCase
{
    protected $category;
    protected $tag;
    protected $product;
    protected $cart;

    use RefreshDatabase;
    use WithFaker;

    public function setUp(): void
    {
        parent::setUp();

        $this->category = factory(Category::class)->create();
        $this->product = ProductTest::createProduct($this->category);
    }

    /** @test */
  public function auth_client_can_see_the_index_payment()
  {
      $this->actingAs($this->ActingAsClient());
      $user = Auth::id();
      CartTest::createCart($user, $this->product);

      $response = $this->get(route('payment.index', $user ));
      $response->assertStatus(200);
      $response->assertSee('Continue to checkout');
      $response->assertSee('Mobile');
  }

    /** @test */
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
