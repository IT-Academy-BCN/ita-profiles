<?php

use App\Models\Recruiter;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('job_offers', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Recruiter::class)->constrained();
            $table->string('title', 255);
            $table->text('description');
            $table->string('location', 255);
            $table->string('skills', 255)->nullable();
            $table->string('salary', 255);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('job_offers');
    }
};
