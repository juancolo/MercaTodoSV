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

            $table->bigIncrements('id');
            $table->string('name', 124)->unique();
            $table->string('slug', 124)->unique();
            $table->string('details', 80);
            $table->text('description')->nullable();
            $table->decimal('actual_price', 6, 2);
            $table->decimal('old_price', 6, 2)->nullable();
            $table->unsignedBigInteger('category_id');
            $table->unsignedInteger('stock')->default(0);
            $table->string('file', 200)->nullable();
            $table->enum('status', ['ACTIVO', 'INACTIVO'])->default('ACTIVO');
            $table->timestamps();

            //relations
            $table->foreign('category_id')->references('id')->on('categories')
            ->onDelete('cascade')
            ->onUpdate('cascade');

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
