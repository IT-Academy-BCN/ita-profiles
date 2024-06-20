<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Query\Expression;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class () extends Migration {
    
    public function up(): void
    {
        Schema::table('resumes', function (Blueprint $table) {
            $table->json('project_ids')->default(new Expression('(JSON_ARRAY())'))->after('specialization');
        });
    }

    public function down(): void
    {
        Schema::table('resumes', function (Blueprint $table) {
            $table->dropColumn('project_ids');
        });
    }
};
