<?php
declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('resumes', function (Blueprint $table) {
            $table->timestamp('github_updated_at')->nullable();
        });
    }

    public function down(): void
    {
        Schema::table('resume', function (Blueprint $table) {
            $table->dropColumn('github_updated_at');
        });
    }
};
