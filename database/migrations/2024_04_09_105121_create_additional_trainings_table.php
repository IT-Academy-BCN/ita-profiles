<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class CreateAdditionalTrainingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('additional_trainings', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('course_name');
            $table->string('study_center');
            $table->integer('course_beginning_year');
            $table->integer('course_ending_year');
            $table->integer('duration_hrs');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('additional_trainings');
    }
}
