<?php

namespace Tests\Feature\Store\Order;

use App\Entities\Order;
use App\Entities\User;
use Tests\TestCase;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class showTest extends TestCase
{
    use RefreshDatabase, WithFaker;
    /**
     * @test
     */
    public function an_non_authenticated_client_cant_see_his_orders()
    {
        $user = Auth::id();
        $response = $this->get(route('order.show', $user));
        $response->assertStatus(302);
    }

    /**
     * @test
     */
    public function an_authenticated_client_cant_see_his_orders()
    {
        $this->actingAs($this->ActingAsClient());
        $user = Auth::id();
        $order = factory(Order::class)->create([
            'user_id' => $user,
        ]);

        $response = $this->get(route('order.show', $user));

        $response->assertStatus(200);
        $response->assertSee($order->total);
    }

    private function ActingAsClient()
    {
        return factory(User::class)->create(['role' => 'Cliente']);
    }
}
