<?php

namespace Tests\Feature\Admin\Report;

use Tests\TestCase;
use App\Entities\User;
use App\Entities\Order;
use App\Constants\UserRoles;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ShowTest extends TestCase
{
 use RefreshDatabase;
 use WithFaker;

    /** @test */
    public function it_can_test()
    {
        $this->artisan('migrate:refresh --seed');
        factory(Order::class)->create([
            'created_at' => $this->faker->dateTimeThisMonth()
        ]);
        $this->ActingAsAdmin();
        $this->get(route('report.show'))->dump();

    }


    public function ActingAsAdmin()
    {
        $user = factory(User::class)
            ->create(['role' => UserRoles::ADMINISTRATOR]);
        $this->actingAs($user);
    }
}
