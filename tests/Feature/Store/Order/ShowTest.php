<?php

namespace Tests\Feature\Store\Order;

use App\Constants\OrderStatus;
use Tests\TestCase;
use App\Entities\User;
use Tests\Feature\OrderTest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ShowTest extends TestCase
{
    use RefreshDatabase;
    use WithFaker;

    /** @test */
    public function an_non_authenticated_client_cant_see_his_orders()
    {
        $user = Auth::id();
        $this->get(route('order.show', $user))
            ->assertStatus(302)
            ->assertRedirect(route('login'));
    }

    /** @test */
    public function an_authenticated_client_cant_see_his_orders()
    {
        $this->actingAs($this->ActingAsClient());

        $user = Auth::id();
        $order = OrderTest::createOrder($user, OrderStatus::APPROVED);

        $this->get(route('order.show', $user))
            ->assertStatus(200)
            ->assertSee($order->presentPrice())
            ->assertSee($order->reference)
            ->assertSee($order->status)
            ->assertDontSee('Redone Payment');
    }

    /** @test */
    public function if_order_has_failed_status_it_should_show_the_redone_payment_button()
    {
        $this->actingAs($this->ActingAsClient());

        $user = Auth::id();
        $order = OrderTest::createOrder($user, OrderStatus::FAILED);

        $this->get(route('order.show', $user))
            ->assertStatus(200)
            ->assertSee($order->presentPrice())
            ->assertSee($order->reference)
            ->assertSee($order->status)
            ->assertSee('Redone Payment');
    }

    private function ActingAsClient()
    {
        return factory(User::class)->create(['role' => 'Cliente']);
    }
}
