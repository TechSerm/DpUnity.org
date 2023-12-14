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
        Schema::table('customer_reviews', function (Blueprint $table) {
            $table->string('audio_filename')->nullable()->change();
            $table->text('review_description')->nullable()->change();
            $table->dateTime('schedule_time')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('customer_reviews', function (Blueprint $table) {
            $table->string('audio_filename')->nullable(false)->change();
            $table->text('review_description')->nullable(false)->change();
            $table->dateTime('schedule_time')->nullable(false)->change();
        });
    }
};
