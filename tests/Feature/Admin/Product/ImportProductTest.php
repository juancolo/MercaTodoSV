<?php

namespace Tests\Feature\Admin\Product;

use App\Entities\Category;
use Illuminate\Http\UploadedFile;
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
/*
    public function an_admin_can_import_a_users_from_xlsx()
    {
        factory(Category::class, 20)->create();

        $this->ActingAsAdmin();

        $importFile = $this->getUploadFile('products-import-file.xlsx');

        $response = $this->post(route('product.import'), ['file' => $importFile]);

        $response->assertOk();

    }*/

    private function ActingAsAdmin()
    {
        $user = factory(User::class)->create(['role' => 'Administrador']);
        $this->actingAs($user);
    }

    /**
     * @param string $originalName
     * @return UploadedFile
     */
    private function getUploadFile(string $originalName): UploadedFile
    {
        $filePath = base_path('tests/Stubs/' . $originalName);

        return new UploadedFile($filePath, $originalName, null, null, true);
    }
}
