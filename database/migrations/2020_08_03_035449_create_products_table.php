<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {


            $table->increments('id');
            $table->string('name')->unique();
            $table->string('slug')->unique();
            $table->string('details', 80);
            $table->text('description')->nullable();
            $table->decimal('actualPrice', 6, 2)->default(0);
            $table->decimal('oldPrice', 6, 2)->default(0);
            $table->unsignedBigInteger('category_id');
            $table->unsignedInteger('sales')->default(0);
            $table->unsignedBigInteger('visits')->default(0);
            $table->string('status');
            $table->timestamps();

            $table->foreign('category_id')->references('id')->on('categories');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('products');
    }
}
