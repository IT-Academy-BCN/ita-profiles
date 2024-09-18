<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('projects', function (Blueprint $table) {
            // Drop the foreign key constraint and the company_id column
            $table->dropForeign(['company_id']);
            $table->dropColumn('company_id');

            // Add the company_name column with a default value of "Freelance"
            $table->string('company_name')->default('Freelance')->nullable();
        });
    }

    public function down(): void
    {
        Schema::table('projects', function (Blueprint $table) {
            // Remove the company_name column
            $table->dropColumn('company_name');

            // Add the company_id column back
            $table->foreignUuid('company_id')->references('id')->on('companies')->onDelete('cascade');
        });
    }
};
