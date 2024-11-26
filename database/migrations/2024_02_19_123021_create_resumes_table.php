<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{

    public function up(): void
    {
        Schema::create('resumes', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('student_id');
            $table->string('subtitle', 255)->nullable();
            $table->string('linkedin_url', 255)->nullable();
            $table->string('github_url', 255)->nullable()->unique();
            $table->enum('specialization', ['Frontend', 'Backend', 'Fullstack', 'Data Science', 'Not Set'])->default('Not Set');
            $table->enum('development', ['Spring', 'Laravel', 'Angular', 'React', 'Not Set'])->default('Not Set');
            $table->longText('modality')->nullable()->collation('utf8mb4_bin')->check(function ($check) {
                $check->json('modality');
            });
            $table->timestamps();
            $table->text('about')->nullable();
            $table->timestamp('github_updated_at')->nullable();

            $table->foreign('student_id')
                ->references('id')
                ->on('students')
                ->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('resumes');
    }
};
