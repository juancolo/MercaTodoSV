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
            $table->bigIncrements('id');
            $table->uuid('reference')->nullable();
            $table->unsignedBigInteger('user_id')->nullable();
            $table->enum('status', ['OK','PENDING', 'FAILED', 'APPROVED', 'APPROVED_PARTIAL','PARTIAL_EXPIRED', 'REJECTED', 'PENDING_VALIDATION', 'REFUNDED' ])->default('PENDING');
            $table->string('first_name', 70);
            $table->string('last_name', 70);
            $table->string('email', 124);
            $table->string('document_type', 2);
            $table->string('document_number', 12);
            $table->string('mobile', 10);
            $table->string('address', 70);
            $table->string('city', 30);
            $table->string('state', 30);
            $table->string('zip', 7);
            $table->unsignedFloat('total')->nullable();
            $table->string('currency')->nullable();
            $table->string('requestId')->nullable();
            $table->string('processUrl')->nullable();

            $table->timestamps();


            $table->foreign('user_id')->references('id')->on('users')
                ->onDelete('set null')
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
        Schema::dropIfExists('orders');
    }
}
