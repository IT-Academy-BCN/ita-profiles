<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddDevelopmentColumnToResumesTable extends Migration
{
    public function up()
    {
        Schema::table('resumes', function (Blueprint $table) {
            $table->enum('development', ["Spring", "Laravel", "Angular", "React", 'Not Set'])->default('Not Set')->after('specialization');
        });
    }

    public function down()
    {
        Schema::table('resumes', function (Blueprint $table) {
            $table->dropColumn('development');
        });
    }
}
