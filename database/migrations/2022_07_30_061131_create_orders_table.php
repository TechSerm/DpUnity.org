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
            $table->integer('woo_id')->nullable();

            $table->string('customer_name')->nullable();
            $table->string('customer_phone')->nullable();
            $table->string('customer_address')->nullable();
            $table->string('customer_area')->nullable();
            $table->string('customer_ip_address')->nullable();
            $table->longText('customer_user_agent')->nullable();

            $table->dateTime('order_date')->nullable();
            $table->integer('discount_total')->default(0);
            $table->integer('shipping_total')->default(0);
            $table->integer('total')->default(0);
            $table->integer('wholesale_total')->default(0);
            $table->integer('profit')->default(0);

            $table->string('order_status')->nullable();
            
            $table->foreignId('shop_id')->nullable();
            $table->foreignId('delivery_man_id')->nullable();

            $table->foreign('shop_id')->references('id')->on('users')->onDelete('cascade');
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
