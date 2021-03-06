<?php

namespace Tests\Feature\Admin\Product;

use Maatwebsite\Excel\Facades\Excel;
use Tests\TestCase;
use App\Entities\User;
use App\Entities\Product;
use App\Entities\Category;
use App\Constants\UserRoles;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ExportProductTest extends TestCase
{
    protected $category;
    protected $products;

    use RefreshDatabase;
    use WithFaker;

    protected function setUp(): void
    {
        parent::setUp();

        $this->category = factory(Category::class)->create();
        $this->products = factory(Product::class, 20)->create(['category_id' => $this->category->id]);
    }

    /**
     * @test
     */
    public function an_admin_can_see_the_export_a_users_report_button()
    {
        $this->ActingAsAdmin();
        $this->get(route('product.index'))
            ->assertStatus(200)
            ->assertSee(route('product.export'))
            ->assertViewIs('admin.products.index');
    }

    /**
     * @test
     */
    public function an_user_cant_export_a_users_report()
    {
        $this->get(route('product.index'))
            ->assertStatus(302)
            ->assertRedirect(route('login'));
    }

    /**
     * @test
     */
    public function an_admin_can_export_a_user_xlsx_report()
    {
        $this->ActingAsAdmin();
        Excel::fake();
        $this->post(route('product.export'), $this->extension())
            ->assertStatus(302)
            ->assertRedirect(route('product.index'))
            ->assertSessionHas('status', trans('products.messages.export.status'));

        Excel::assertQueued(date('d-m-Y', strtotime(now())).'-products.xlsx');

        Excel::assertStored(date('d-m-Y', strtotime(now())).'-products.xlsx',);
    }

    private function ActingAsAdmin(): void
    {
        $user = factory(User::class)->create(['role' => UserRoles::ADMINISTRATOR]);
        $this->actingAs($user);
    }

    public function extension(): array
    {
        return [
            'extension' => 'xlsx'
        ];
    }

}
