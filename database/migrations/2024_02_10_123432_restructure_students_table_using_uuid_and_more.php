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
        Schema::table('student_has_tags', function (Blueprint $table) {
            $table->dropConstrainedForeignId('student_id');
        });

        Schema::drop('students');

        Schema::create('students', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('name', 255);
            $table->string('surname', 255);
            $table->string('photo')->nullable();
            $table->enum(
                'status',
                ['Active', 'Inactive', 'In a Bootcamp', 'In a Job']
            )->default('Active');
            $table->timestamps();
        });

        Schema::table('student_has_tags', function (Blueprint $table) {
            $table->uuid('student_id');
            $table->foreign('student_id')->references('id')->on('students')
                ->onDelete('restrict')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('students');
        Schema::create('students', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()
            ->onDelete('restrict')
            ->onUpdate('cascade');
            $table->string('subtitle');
            $table->text('about')->nullable();
            $table->string('cv')->nullable();
            $table->enum(
                'bootcamp',
                ['front end Developer', 'php developer', 'java developer', 'nodejs developer', 'data scientists']
            );
            $table->date('end_date')->nullable();
            $table->string('linkedin')->nullable();
            $table->string('github')->nullable();
            $table->timestamps();
        });

        Schema::table('student_has_tags', function (Blueprint $table) {
            $table->foreignId('student_id')->constrained()->onDelete('restrict')->onUpdate('cascade');
        });
    }
};