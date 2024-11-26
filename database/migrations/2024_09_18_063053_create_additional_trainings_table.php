<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('additional_trainings', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('course_name', 255);
            $table->string('study_center', 255);
            $table->integer('course_beginning_year');
            $table->integer('course_ending_year');
            $table->integer('duration_hrs');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('additional_trainings');
    }
};
