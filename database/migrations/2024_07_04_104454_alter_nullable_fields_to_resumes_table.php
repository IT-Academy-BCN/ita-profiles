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
        Schema::table('resumes', function (Blueprint $table) {
            $table->string('subtitle')->nullable()->change();
            $table->string('linkedin_url')->nullable()->change();
            $table->string('github_url')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('resumes', function (Blueprint $table) {
            $table->string('subtitle')->nullable(false)->change();
            $table->string('linkedin_url')->nullable(false)->change();
            $table->string('github_url')->nullable(false)->change();
        });
    }
};
