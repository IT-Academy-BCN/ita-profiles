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
        Schema::create('additional_training_resume', function (Blueprint $table) {
            $table->id();
            $table->foreignUuid('resume_id')->constrained('resumes')->onDelete('cascade');
            $table->foreignUuid('additional_training_id')->constrained('additional_trainings')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('additional_training_resume');
    }
};
