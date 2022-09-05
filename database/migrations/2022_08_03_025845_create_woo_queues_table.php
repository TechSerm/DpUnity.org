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
        Schema::create('woo_queues', function (Blueprint $table) {
            $table->id();
            $table->integer('woo_id')->nullable();
            $table->integer('orm_model_id')->nullable();
            $table->string('slug')->nullable();
            $table->string('woo_model')->nullable();
            $table->string('method')->nullable();
            $table->longText('data')->nullable();
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
        Schema::dropIfExists('woo_queues');
    }
};
