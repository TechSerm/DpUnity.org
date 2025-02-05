<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('news', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('slug')->nullable()->unique();
            $table->text('content')->nullable();
            $table->string('thumbnail')->nullable();
            $table->integer('author')->nullable();
            $table->timestamp('published_at')->nullable()->index();
            $table->integer('order')->default(0);
            $table->boolean('is_featured')->default(false)->index();
            $table->enum('status', ['draft', 'published', 'archived'])->default('draft')->index();
            $table->integer('views')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('news');
    }
};
