<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('bootcamp_resume', function (Blueprint $table) {
            $table->id();
            $table->uuid('bootcamp_id');
            $table->uuid('resume_id');
            $table->date('end_date');
            $table->timestamps();

            $table->foreign('bootcamp_id')
                ->references('id')->on('bootcamps')
                ->onDelete('cascade');

            $table->foreign('resume_id')
                ->references('id')->on('resumes')
                ->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('bootcamp_resume');
    }
};
