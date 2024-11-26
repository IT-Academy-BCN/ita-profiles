<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('recruiters', function (Blueprint $table) {
            $table->char('id', 36)->primary(); // id (UUID como clave primaria)
            $table->char('company_id', 36); // company_id (clave foránea a la tabla companies)
            $table->char('user_id', 36); // user_id (clave foránea a la tabla users)
            $table->string('role')->default('recruiter'); // role con valor predeterminado 'recruiter'
            $table->timestamps(); // created_at, updated_at

            // Claves foráneas
            $table->foreign('company_id')
                ->references('id')->on('companies')
                ->onDelete('cascade');

            $table->foreign('user_id')
                ->references('id')->on('users')
                ->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('recruiters');
    }
};
