<?php

namespace Tests\Feature\Admin\Product;

use Tests\TestCase;
use App\Entities\User;
use App\Entities\Product;
use App\Entities\Category;
use App\Constants\UserRoles;
use Illuminate\Http\UploadedFile;
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

    /**
     * @test
     */
    public function an_admin_can_create_import_users_from_xlsx()
    {
        factory(Category::class, 20)->create();

        $this->ActingAsAdmin();

        $this->assertDatabaseMissing('products', [
            'name' => 'Fake Name',
            'details' => "fake_details",
            'description' => "fake_description",
            'actual_price' => "1000"
        ]);

        $importFile = $this->getUploadFile('products-import-file.xlsx');


        $this->post(route('product.import'), ['file' => $importFile])
            ->assertRedirect(route('product.index'));

        $this->assertDatabaseHas('products', [
            'name' => 'Fake Name',
            'details' => "fake_details",
            'description' => "fake_description",
            'actual_price' => "1000",
        ]);
    }

    /**
     * @test
     */
    public function an_admin_can_update_users_with_an_from_xlsx()
    {
        factory(Category::class, 20)->create();

        $this->ActingAsAdmin();

        $product = [
            'name' => 'Fake Name',
            'details' => "old_fake_details",
            'description' => "old_fake_description",
            'actual_price' => "1000",
            'category_id' => 1
        ];

        factory(Product::class)->create($product);
        $this->assertDatabaseHas('products', $product);

        $importFile = $this->getUploadFile('products-import-file.xlsx');

        $this->post(route('product.import'), ['file' => $importFile])
            ->assertRedirect(route('product.index'));

        $this->assertDatabaseHas('products', [
            'name' => 'Fake Name',
            'details' => "fake_details",
            'description' => "fake_description",
            'actual_price' => "1000",
        ]);
    }

    private function ActingAsAdmin()
    {
        $user = factory(User::class)->create([
            'role' => UserRoles::ADMINISTRATOR]);
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
