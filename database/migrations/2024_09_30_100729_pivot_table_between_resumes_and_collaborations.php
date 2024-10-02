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
        //
        
        Schema::table('resumes', function (Blueprint $table) {
            $table->dropColumn('collaborations_ids');
        });
        
        Schema::create('resumes_to_collaborations', function (Blueprint $table) {
            //$table->uuid('id')->primary();
            $table->foreignUuid('resume_id')->references('id')->on('resumes')->onDelete('cascade');;
            $table->foreignUuid('collaboration_id')->references('id')->on('collaborations')->onDelete('cascade');;
            //collaborations
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
