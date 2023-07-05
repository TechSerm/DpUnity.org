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
        Schema::create('device_histories', function (Blueprint $table) {
            $table->id();
            $table->foreignId('device_id');
            $table->foreign('device_id')->references('id')->on('notification_devices')->onDelete('cascade');

            $table->string('ip')->nullable();

            $table->longText('cache_data')->nullable();
            $table->string('url')->nullable();

            $table->foreignId('user_id')->nullable();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');

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
        Schema::dropIfExists('device_histories');
    }
};
