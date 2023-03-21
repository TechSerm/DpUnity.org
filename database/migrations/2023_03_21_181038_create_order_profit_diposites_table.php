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
        Schema::create('order_profit_diposites', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid')->nullable();
            $table->integer('product_profit')->default(0);
            $table->integer('delivery_fee')->default(0);
            $table->integer('total_amount')->default(0);
            $table->integer('total_orders')->default(0);

            $table->text('note')->nullable();
            
            $table->foreignId('user_id');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');

            $table->foreignId('account_transaction_id')->nullable();
            $table->foreign('account_transaction_id')->references('id')->on('account_transactions')->onDelete('cascade');
            
            $table->boolean('is_approved')->default(false);

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
        Schema::dropIfExists('order_profit_diposites');
    }
};
