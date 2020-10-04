<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->uuid('reference');
            $table->unsignedBigInteger('user_id');
            $table->enum('status', ['OK','PENDING', 'FAILED', 'APPROVED', 'APPROVED_PARTIAL','PARTIAL_EXPIRED', 'REJECTED', 'PENDING_VALIDATION', 'REFUNDED' ])->default('PENDING');
            $table->text('full_name');
            $table->text('last_name')->nullable();
            $table->text('email')->unique();
            $table->text('document_type');
            $table->text('document_number');
            $table->string('phone_number');
            $table->string('address');
            $table->string('city');
            $table->string('state');
            $table->string('zip');

            $table->foreign('user_id')->references('id')->on('users')
                ->onDelete('cascade')
                ->onUpdate('cascade');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('orders');
    }
}
