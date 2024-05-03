<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class () extends Migration {
    public function up(): void
    {
        Schema::create('language_resume', function (Blueprint $table) {
            $table->id();
            $table->foreignUuid('language_id')->references('id')->on('languages')->onDelete('cascade');
            $table->foreignUuid('resume_id')->references('id')->on('resumes')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('language_resum');
    }
};
