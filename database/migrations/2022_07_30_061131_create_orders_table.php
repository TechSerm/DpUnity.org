<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
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
            $table->uuid('uuid')->nullable();

            $table->string('name')->nullable();
            $table->string('phone')->nullable();
            $table->string('address')->nullable();
            $table->string('area')->nullable();
            $table->string('ip_address')->nullable();
            $table->longText('user_agent')->nullable();

            $table->integer('discount_total')->default(0);
            $table->integer('delivery_fee')->default(0);
            $table->integer('subtotal')->default(0);
            $table->integer('total')->default(0);
            $table->integer('wholesale_total')->default(0);
            $table->integer('products_profit')->default(0);
            $table->integer('total_profit')->default(0);

            $table->string('status')->nullable();
            $table->boolean('is_approved')->default(false);
            $table->boolean('is_delivery_complete')->default(false);
            $table->boolean('is_vendor_payment_complete')->default(false);
            $table->boolean('is_cancelled')->default(false);
            
            $table->foreignId('vendor_id')->nullable();
            $table->foreignId('delivery_man_id')->nullable();

            $table->foreign('vendor_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('delivery_man_id')->references('id')->on('users')->onDelete('cascade');
            
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
};
