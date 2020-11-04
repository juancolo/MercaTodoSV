<?php

namespace Tests\Feature\Admin\Product;

use App\Entities\Product;
use Tests\TestCase;
use App\Entities\User;
use App\Entities\Category;
use Tests\Feature\ProductTest;
use App\Exports\ProductsExport;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ExportProductTest extends TestCase
{
    protected $category;

    use RefreshDatabase;
    use WithFaker;

    protected function setUp(): void
{
    parent::setUp();

    $this->category = factory(Category::class)->create();
    factory(Product::class, 20)->create(['category_id' => $this->category->id]);
}

    /**
     * @test
    */
    public function an_admin_can_see_the_export_a_users_report_button()
    {
        $this->ActingAsAdmin();
        $this->get(route('product.index'))
            ->assertStatus(200)
            ->assertSee(route('product.export'));
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
        $products = Product::all();
        $this->ActingAsAdmin();
        Excel::fake();
        $this->get(route('product.export'))
            ->assertStatus(200);

        Excel::assertDownloaded('products.xlsx', function (ProductsExport $export)
        use ($products){
            return $export->collection()->contains($products->random());
        });
    }

    private function ActingAsAdmin()
    {
        $user = factory(User::class)->create(['role' => 'Administrador']);
        $this->actingAs($user);
    }

}
