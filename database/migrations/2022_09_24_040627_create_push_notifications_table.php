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
        Schema::create('push_notifications', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid');
            $table->string('title')->nullable();
            $table->longText('body')->nullable();
            $table->longText('url')->nullable();
            $table->longText('image')->nullable();
            $table->boolean('is_scheduling_notification')->default(false);
            $table->dateTime('scheduling_time')->nullable();
            $table->integer('total_sends')->default(0);
            $table->boolean('is_complete_send')->default(false);
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
        Schema::dropIfExists('push_notifications');
    }
};
