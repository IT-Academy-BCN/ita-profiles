<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class () extends Migration {
    public function up(): void
    {
        Schema::create('bootcamp_resume', function (Blueprint $table) {
            $table->id();
            $table->foreignUuid('bootcamp_id')->references('id')->on('bootcamps')->onDelete('cascade');
            $table->foreignUuid('resume_id')->references('id')->on('resumes')->onDelete('cascade');
            $table->date('end_date');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('bootcamp_resume');
    }
};
