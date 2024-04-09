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
        Schema::create('bootcamps_resumes', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('bootcamp_id')->references('id')->on('bootcamps')->onDelete('cascade');
            $table->foreignUuid('resume_id')->references('id')->on('resumes')->onDelete('cascade');
            $table->date('end_date');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bootcamps_resumes');
    }
};
