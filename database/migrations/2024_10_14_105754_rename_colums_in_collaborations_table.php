<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('collaborations', function (Blueprint $table) {
            $table->renameColumn('collaboration_name', 'name');
            $table->renameColumn('collaboration_description', 'description');
            $table->renameColumn('collaboration_quantity', 'quantity');
        });
    }

    public function down(): void
    {
        Schema::table('collaborations', function (Blueprint $table) {
            $table->renameColumn('name', 'collaboration_name');
            $table->renameColumn('description', 'collaboration_description');
            $table->renameColumn('quantity', 'collaboration_quantity');
        });
    }
};
