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

        Schema::table('students', function (Blueprint $table) {
            $table->uuid('id')->change();
            $table->dropConstrainedForeignId('user_id');
            $table->string('name', 255)->after('id');
            $table->string('surname', 255)->after('name');
            $table->string('photo')->unique()->nullable()->after('surname'); // Check if nullable is ok
            $table->enum(
                'status',
                ['Active', 'Inactive', 'In a Bootcamp', 'In a Job']
            )->default('Active')->after('photo'); // TODO Check if default active is correct
        });

        Schema::table('student_has_tags', function (Blueprint $table) {
            $table->uuid('student_id')->after('id');
            $table->foreign('student_id')->references('id')->on('students')
            ->constrained('students')->onDelete('restrict')->onUpdate('cascade');
        });

        Schema::table('students', function (Blueprint $table) {
            $table->dropColumn(['subtitle','about', 'cv', 'bootcamp', 'end_date', 'linkedin', 'github']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('student_has_tags', function (Blueprint $table) {
            $table->dropConstrainedForeignId('student_id');
        });
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
        });
        Schema::table('student_has_tags', function (Blueprint $table) {
            $table->foreignId('student_id')->constrained()->onDelete('restrict')->onUpdate('cascade');
        });

    }
};
