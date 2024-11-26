<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('additional_training_resume', function (Blueprint $table) {
            $table->id();
            $table->uuid('resume_id');
            $table->uuid('additional_training_id');
            $table->timestamps();

            $table->foreign('resume_id')
                ->references('id')
                ->on('resumes')
                ->onDelete('cascade');

            $table->foreign('additional_training_id')
                ->references('id')
                ->on('additional_trainings')
                ->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('additional_training_resume');
    }
};
