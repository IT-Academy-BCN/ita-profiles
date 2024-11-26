<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{

    public function up(): void
    {
        Schema::create('language_resume', function (Blueprint $table) {
            $table->id();
            $table->uuid('language_id');
            $table->uuid('resume_id');

            // Definir las claves foráneas
            $table->foreign('language_id')
                ->references('id')->on('languages')
                ->onDelete('cascade');

            $table->foreign('resume_id')
                ->references('id')->on('resumes')
                ->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('language_resume');
    }
};
