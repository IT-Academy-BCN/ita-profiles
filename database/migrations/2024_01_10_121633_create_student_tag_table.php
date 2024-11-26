<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('student_tag', function (Blueprint $table) {
            $table->bigIncrements('id')->unsigned();
            $table->unsignedBigInteger('tag_id');
            $table->uuid('student_id');
            $table->timestamps();

            $table->foreign('student_id')
                ->references('id')
                ->on('students')
                ->onUpdate('cascade');

            $table->foreign('tag_id')
                ->references('id')
                ->on('tags')
                ->onUpdate('cascade')
                ->onDelete('cascade');
        });

        Schema::table('students', function (Blueprint $table) {
            $table->index('user_id', 'students_user_id_index');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('student_tag');

        Schema::table('students', function (Blueprint $table) {
            $table->dropIndex('students_user_id_index');
        });
    }
};
