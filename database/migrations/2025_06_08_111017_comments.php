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
    Schema::create('comments', function (Blueprint $table) {
      $table->id('id');
      $table->foreignId('post_id')->constrained('posts', 'id')->onDelete('cascade');
      $table->foreignId('user_id')->constrained('users', 'id')->onDelete('cascade');
      $table->bigInteger('parent_id')->nullable()->default(null);
      $table->text('content');
      $table->timestampsTz();
      $table->softDeletes();

      $table->foreign('parent_id')->references('id')->on('comments')->onDelete('cascade');
      $table->index(['post_id', 'user_id']);
    });
  }

  /**
   * Reverse the migrations.
   */
  public function down(): void
  {
    Schema::dropIfExists('comments');
  }
};
