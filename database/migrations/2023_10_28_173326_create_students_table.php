<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class () extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('students', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('restrict')->onUpdate('cascade');
            $table->string('subtitle');
            $table->text('about')->nullable();
            $table->string('cv')->nullable();
            $table->enum('bootcamp', ['front end Developer', 'php developer', 'java developer', 'nodejs developer',
                'data scientists']);
            $table->date('end_date')->nullable();
            $table->string('linkedin')->nullable();
            $table->string('github')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('students');
    }
};
