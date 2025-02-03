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
        $table->uuid('id')->default(DB::raw('gen_random_uuid()'));;
        $table->string('title');
        $table->string('slug', 100);
        $table->longText('content');
        $table->foreignId('owner_id')->constrained('users','id')
              ->onDelete('cascade');
        $table->timestamps();

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
