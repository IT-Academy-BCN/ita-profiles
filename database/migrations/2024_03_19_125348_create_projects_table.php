<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Query\Expression;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class () extends Migration {
    public function up(): void
    {
        Schema::create('projects', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('name');
            $table->foreignUuid('company_id')->references('id')->on('companies')->onDelete('cascade');
            $table->json('tags')->default(new Expression('(JSON_ARRAY())'));
            $table->string('github_url', 255)->default('');
            $table->string('project_url', 255)->default('');
        });
    }
    public function down(): void
    {
        Schema::dropIfExists('projects');
    }
};
