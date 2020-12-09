<?php

namespace Tests\Feature\Api\User;

use Tests\TestCase;
use App\Entities\User;
use App\Constants\UserRoles;
use Illuminate\Support\Facades\Hash;
use Illuminate\Foundation\Testing\RefreshDatabase;

class LoginTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function an_user_can_log_in()
    {
        $user = factory(User::class)->create([
            'role' => UserRoles::ADMINISTRATOR,
            'password' => Hash::make('12345678')
        ]);

        $auth =
            [
                'email' => $user->email,
                'password' => '12345678'
            ];

        $this->postJson(route('api.v1.login.user'), $auth)
            ->assertSee('accesses_token');
    }
}
