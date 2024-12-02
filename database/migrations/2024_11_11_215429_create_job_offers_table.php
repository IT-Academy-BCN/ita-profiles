<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('job_offers', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('recruiter_id')->constrained()->onDelete('cascade');
            $table->string('title', 255);
            $table->text('description');
            $table->string('location', 255);
            $table->string('skills', 255)->nullable();
            $table->string('salary', 255)->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('job_offers');
    }
};
