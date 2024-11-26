<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('resume_collaboration', function (Blueprint $table) {
            $table->uuid('resume_id');
            $table->uuid('collaboration_id');
            $table->timestamps();

            $table->foreign('collaboration_id')
                ->references('id')->on('collaborations')
                ->onDelete('cascade');

            $table->foreign('resume_id')
                ->references('id')->on('resumes')
                ->onDelete('cascade');

            $table->primary(['resume_id', 'collaboration_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('resume_collaboration');
    }
};
