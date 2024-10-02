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
        Schema::table('languages', function (Blueprint $table) {
            $table->renameColumn(from: 'language_name', to: 'name');
            $table->renameColumn(from: 'language_level', to: 'level');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('languages', function (Blueprint $table) {
            $table->renameColumn(from: 'name', to: 'language_name');
            $table->renameColumn(from: 'level', to: 'language_level');
        });
    }
};