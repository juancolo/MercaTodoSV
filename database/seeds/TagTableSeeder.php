<?php

use App\Product;
use App\Tag;
use Illuminate\Database\Seeder;

class TagTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(Tag::class, 20)->create();

            /*->each(function (Tag $tag)
        {
            $tag->product()->save(factory(Product::class)->make());


        });*/

    }
}
