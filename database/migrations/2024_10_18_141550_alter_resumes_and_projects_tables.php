<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('resumes', function (Blueprint $table) {
            $table->string('github_url', 255)->nullable()->unique()->change();
        });

        Schema::table('projects', function (Blueprint $table) {
            $table->unsignedBigInteger('github_repository_id')->nullable()->unique()->after('github_url');
        });
    }

    public function down(): void
    {
        Schema::table('resumes', function (Blueprint $table) {
            $table->string('github_url', 255)->default('')->change();
            $table->dropUnique(['github_url']);
        });

        Schema::table('projects', function (Blueprint $table) {
            $table->dropColumn('github_repository_id');
        });
    }
};
