<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('job_offer_student', function (Blueprint $table) {
            $table->id();
            $table->uuid('job_offer_id');
            $table->uuid('student_id');
            $table->timestamps();

            $table->foreign('job_offer_id')
                ->references('id')
                ->on('job_offers')
                ->onDelete('cascade');

            $table->foreign('student_id')
                ->references('id')
                ->on('students')
                ->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('job_offer_student');
    }
};
