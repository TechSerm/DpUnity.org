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
        Schema::table('products', function (Blueprint $table) {
            $table->integer('regular_price')->default(0);
            $table->integer('sale_price')->default(0);
            $table->integer('total_stock')->default(0);
            $table->boolean('has_hot_deals')->default(false);
            $table->longText('description')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('products', function (Blueprint $table) {
            $table->dropColumn('regular_price');
            $table->dropColumn('sale_price');
            $table->dropColumn('total_stock');
            $table->dropColumn('has_hot_deals');
            $table->dropColumn('description');
        });
    }
};
