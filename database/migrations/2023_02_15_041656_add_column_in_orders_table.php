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
        Schema::table('orders', function (Blueprint $table) {
            $table->boolean('is_vendor_assign')->default(false);
            $table->boolean('is_pack_complete')->default(false);
            $table->boolean('is_delivery_start')->default(false);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->dropColumn('is_vendor_assign');
            $table->dropColumn('is_ready_for_delivery');
            $table->dropColumn('is_delivery_start');
        });
    }
};
