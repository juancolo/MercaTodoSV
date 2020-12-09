<?php

namespace Tests\Feature\Admin\Product;

use App\Entities\Product;
use App\Exports\ProductsExport;
use Maatwebsite\Excel\Facades\Excel;
use Tests\TestCase;
use App\Entities\User;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ImportProductTest extends TestCase
{
    use RefreshDatabase;
    use WithFaker;

    /**
     * @test
     */
    public function an_admin_can_see_the_import_users_report_button()
    {
        $this->ActingAsAdmin();
        $this->get(route('product.index'))
            ->assertStatus(200)
            ->assertSee(route('product.import'));
    }

    /**
     * @test
     */
    public function an_user_cant_see_the_import_users_report_button()
    {
        $this->get(route('product.index'))
            ->assertStatus(302)
            ->assertRedirect(route('login'));
    }

    public function an_admin_can_export_a_user_xlsx_report()
    {
        $products = Product::all();
        $this->ActingAsAdmin();
        Excel::fake();
        $this->post(route('product.export'))
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
