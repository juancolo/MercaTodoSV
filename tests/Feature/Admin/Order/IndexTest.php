<?php

namespace Tests\Feature\Admin\Order;

use Tests\TestCase;
use App\Entities\User;
use App\Constants\UserRoles;
use Illuminate\Foundation\Testing\RefreshDatabase;

class IndexTest extends TestCase
{
 use RefreshDatabase;

    /** @test */
    public function an_authorize_user_can_see_the_orders()
    {
        $this->withExceptionHandling();

        $this->actingAs(factory(User::class)->create([
            'role' => UserRoles::ADMINISTRATOR
        ]));

        $this->get(route('orders.index'))
            ->assertOk();
    }
}
