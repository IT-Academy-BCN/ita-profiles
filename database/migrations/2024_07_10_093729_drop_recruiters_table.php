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
    Schema::dropIfExists('recruiters');
  }

  /**
   * Reverse the migrations.
   */
  public function down(): void
  {
    Schema::create('recruiters', function (Blueprint $table) {
      $table->id();
      $table->uuid('user_id')->index()->nullable();
      $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
      $table->string('company');
      $table->string('sector');
      $table->timestamps();
    });
  }
};
