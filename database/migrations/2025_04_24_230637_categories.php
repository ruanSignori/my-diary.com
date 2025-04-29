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
    Schema::create('categories', function (Blueprint $table) {
      $table->id('id');
      $table->string('name');
      $table->boolean('is_default')->default(false);
      $table->timestampsTz();
    });

    Schema::create('posts_categories', function (Blueprint $table) {
      $table->id('id');
      $table->foreignId('category_id')->constrained('categories', 'id')->onDelete('cascade');
      $table->foreignId('post_id')->constrained('posts', 'id')->onDelete('cascade');
      $table->primary(['category_id', 'post_id']);
    });
  }
  /**
   * Reverse the migrations.
   */
  public function down(): void
  {
    Schema::dropIfExists('posts_categories');
    Schema::dropIfExists('categories');
  }
};
