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
        Schema::create('order_items', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid')->nullable();
            
            $table->foreignId('order_id');
            $table->foreign('order_id')->references('id')->on('orders')->onDelete('cascade');

            $table->foreignId('product_id')->nullable();
            
            $table->string('name')->nullable();
            $table->string('unit')->nullable();
            $table->string('unit_quantity')->nullable();
            
            $table->integer('quantity')->default(0);
            $table->integer('price')->default(0);
            $table->integer('wholesale_price')->default(0);
            $table->integer('wholesale_price_total')->default(0);
            $table->dateTime('wholesale_price_update_time')->nullable();
            $table->integer('profit')->default(0);
            $table->integer('total')->default(0);

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
        Schema::dropIfExists('order_items');
    }
};
