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
            $table->dropColumn('additional_trainings_ids');});
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('resume', function (Blueprint $table) {
            //
        });
    }
};
