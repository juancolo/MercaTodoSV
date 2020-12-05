<?php

namespace Tests\Feature\Api\Category;

use App\Constants\UserRoles;
use App\Entities\Category;
use App\Entities\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Laravel\Passport\Passport;
use Tests\TestCase;

class IndexTest extends TestCase
{
 use RefreshDatabase;

    private $category;

    protected function setUp(): void
 {
     parent::setUp();
     $this->category = factory(Category::class, 15)->create();
 }

    /** @test */
    public function an_unauthenticated_user_can_not_fetch_categories()
    {
        $this->jsonApi()
            ->get(route('api.v1.categories.index'))
            ->assertStatus(401)
            ->assertDontSee($this->category[0]);
    }

    /** @test */
    public function an_authenticated_user_can_fetch_all_categories()
    {
       $this->actingAsAdmin();

       $this->jsonApi()
           ->get(route('api.v1.categories.index'))
           ->assertStatus(200)
           ->assertSee($this->category[0]['name']);
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
