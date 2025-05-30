<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
  /**
   * Run the migrations.
   */
  public function up(): void
  {
    Schema::create('posts', function (Blueprint $table) {
      $table->id('id');
      $table->string('title');
      $table->string('slug');
      $table->longText('content');
        $table->foreignId('author_id')->constrained('users','id');
      $table->timestampsTz();
      $table->index(['author_id']);
    });
  }

  /**
   * Reverse the migrations.
   */
  public function down(): void
  {
    Schema::dropIfExists('posts');
  }
};
