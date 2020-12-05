<?php

namespace Tests\Feature\Api\Category;

use Tests\TestCase;
use App\Entities\User;
use App\Entities\Category;
use App\Constants\UserRoles;
use Laravel\Passport\Passport;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ShowTest extends TestCase
{
    use RefreshDatabase;

    private $category;

    protected function setUp(): void
{
    parent::setUp();
    $this->category = factory(Category::class, 10)->create();
}

    /** @test */
    public function an_unauthenticated_user_can_not_fetch_categories()
    {
        $this->jsonApi()
            ->get(route('api.v1.categories.read', $this->category[3]))
            ->assertStatus(401)
            ->assertDontSee($this->category[0]);
    }

    /** @test */
    public function an_authenticated_user_can_fetch_a_single_category()
    {
        $this->actingAsAdmin();

        $this->jsonApi()
            ->filter([])
            ->get(route('api.v1.categories.read', $this->category[3]))
            ->assertStatus(200)
            ->assertSee($this->category[3]['name'])
            ->assertDontSee($this->category[0]['name'])
            ->assertDontSee($this->category[1]['name'])
            ->assertDontSee($this->category[2]['name']);
    }

    public function actingAsAdmin()
    {
        Passport::actingAs(
            factory(User::class)->create([
                'role' => UserRoles::ADMINISTRATOR
            ])
        );
    }
}
