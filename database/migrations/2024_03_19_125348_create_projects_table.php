<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('projects', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('name', 255);
            $table->string('github_url', 255)->default('');
            $table->unsignedBigInteger('github_repository_id')->nullable()->unique();
            $table->string('project_url', 255)->default('');
            $table->string('company_name', 255)->default('Freelance')->nullable();
            $table->timestamps(); // created_at, updated_at
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('projects');
    }
};
