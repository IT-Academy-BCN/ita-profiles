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
        Schema::table('resumes', function (Blueprint $table) {
            $table->dropColumn('collaborations_ids');
        });

        Schema::create('resume_collaboration', function (Blueprint $table) {
            $table->foreignUuid('resume_id')->constrained('resumes')->onDelete('cascade');
            $table->foreignUuid('collaboration_id')->constrained('collaborations')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
        Schema::dropIfExists('resumes_to_collaborations');
    }
};
