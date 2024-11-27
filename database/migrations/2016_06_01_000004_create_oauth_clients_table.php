<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('oauth_clients', function (Blueprint $table) {
            $table->id();
            $table->string('name', 255);
            $table->string('secret', 100)->nullable();
            $table->string('provider', 255)->nullable();
            $table->text('redirect');
            $table->boolean('personal_access_client');
            $table->boolean('password_client');
            $table->boolean('revoked');
            $table->timestamps();
            $table->char('user_id', 36)->nullable()->index();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('oauth_clients');
    }
};
