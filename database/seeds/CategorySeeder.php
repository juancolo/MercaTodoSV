<?php

use App\Category;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $category = new Category();
        $category->name = 'laptop';
        $category->type = 'pcs';
        $category->description = 'pcs for gaming' ;
        $category->save();
    }
}
