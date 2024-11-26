<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
return new class extends Migration
{
    public function up(): void
    {
        Schema::create('students', function (Blueprint $table) {
            $table->char('id', 36)->primary();
            $table->string('name')->nullable();
            $table->string('surname')->nullable();
            $table->string('photo')->nullable();
            $table->enum('status', ['Active', 'Inactive', 'In a Bootcamp', 'In a Job'])->default('Active');
            $table->timestamps();
            $table->char('user_id', 36)->nullable();

            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('students');
    }
};
