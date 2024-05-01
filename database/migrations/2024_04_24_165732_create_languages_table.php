<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    
    public function up(): void
    {
        Schema::create('languages', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('language_name')->nullable();
            $table->enum('language_level', ['Bàsic', 'Intermedi', 'Avançat', 'Natiu'])->nullable();
            $table->unique(['language_name', 'language_level']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('languages');
    }
};
