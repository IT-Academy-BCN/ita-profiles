<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('languages', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('name')->nullable();
            $table->enum('level', ['Bàsic', 'Intermedi', 'Avançat', 'Natiu'])->nullable();
            $table->unique(['name', 'level'], 'languages_language_name_language_level_unique');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('languages');
    }
};
