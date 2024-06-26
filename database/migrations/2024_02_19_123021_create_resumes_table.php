<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Query\Expression;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class () extends Migration {
    public function up(): void
    {
        Schema::create('resumes', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('student_id')->references('id')->on('students')->onDelete('cascade');
            $table->string('subtitle', 255)->default('');
            $table->string('linkedin_url', 255)->default('');
            $table->string('github_url', 255)->default('');
            $table->json('tags_ids')->default(new Expression('(JSON_ARRAY())'));
            $table->enum(
                'specialization',
                ['Frontend', 'Backend', 'Fullstack', 'Data Science', 'Not Set']
            )->default('Not Set');
            $table->timestamps();
        });
    }
    
    public function down(): void
    {
        Schema::dropIfExists('resumes');
    }
};
