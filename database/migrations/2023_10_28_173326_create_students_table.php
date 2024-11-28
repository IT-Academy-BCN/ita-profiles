<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('students', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('name')->nullable();
            $table->string('surname')->nullable();
            $table->string('photo')->nullable();
            $table->enum('status', ['Active', 'Inactive', 'In a Bootcamp', 'In a Job'])->default('Active');
            $table->timestamps();
            // TODO: This should not be nullable. Fix it as soon as factorie create user for all students.
            $table->uuid('user_id')->nullable()->index();

            $table->foreign('user_id')
                ->references('id')
                ->on('users')
                ->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('students');
    }
};
