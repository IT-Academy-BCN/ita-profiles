<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Drop foreign key constraints and user_id columns
        Schema::table('students', function (Blueprint $table) {
            $table->dropForeign(['user_id']);
        });
        Schema::table('admins', function (Blueprint $table) {
            $table->dropForeign(['user_id']);
        });
        Schema::table('recruiters', function (Blueprint $table) {
            $table->dropForeign(['user_id']);
        });

        Schema::table('students', function (Blueprint $table) {
            $table->dropColumn('user_id');
        });
        Schema::table('admins', function (Blueprint $table) {
            $table->dropColumn('user_id');
        });
        Schema::table('recruiters', function (Blueprint $table) {
            $table->dropColumn('user_id');
        });
        Schema::table('oauth_auth_codes', function (Blueprint $table) {
            $table->dropColumn('user_id');
        });
        Schema::table('oauth_access_tokens', function (Blueprint $table) {
            $table->dropColumn('user_id');
        });
        Schema::table('oauth_clients', function (Blueprint $table) {
            $table->dropColumn('user_id');
        });

        // Drop and recreate users table with UUID primary key
        Schema::dropIfExists('users');

        Schema::create('users', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('username', 100);
            $table->string('password', 75);
            $table->string('dni', 9);
            $table->string('email', 75);
            $table->timestamp('email_verified_at')->nullable()->default(null);
        });

        // Update related tables with new user_id columns and add foreign keys
        Schema::table('students', function (Blueprint $table) {
            $table->uuid('user_id')->index()->nullable();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
        Schema::table('admins', function (Blueprint $table) {
            $table->uuid('user_id')->index()->nullable();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
        Schema::table('recruiters', function (Blueprint $table) {
            $table->uuid('user_id')->index()->nullable();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
        Schema::table('oauth_auth_codes', function (Blueprint $table) {
            $table->uuid('user_id')->index()->nullable();
        });
        Schema::table('oauth_access_tokens', function (Blueprint $table) {
            $table->uuid('user_id')->nullable()->index();
        });
        Schema::table('oauth_clients', function (Blueprint $table) {
            $table->uuid('user_id')->nullable()->index();
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Drop foreign key constraints and user_id columns
        Schema::table('students', function (Blueprint $table) {
            $table->dropForeign(['user_id']);
            $table->dropColumn('user_id');
        });
        Schema::table('admins', function (Blueprint $table) {
            $table->dropForeign(['user_id']);
            $table->dropColumn('user_id');
        });
        Schema::table('recruiters', function (Blueprint $table) {
            $table->dropForeign(['user_id']);
            $table->dropColumn('user_id');
        });
        Schema::table('oauth_auth_codes', function (Blueprint $table) {
            $table->dropColumn('user_id');
        });
        Schema::table('oauth_access_tokens', function (Blueprint $table) {
            $table->dropColumn('user_id');
        });
        Schema::table('oauth_clients', function (Blueprint $table) {
            $table->dropColumn('user_id');
        });

        // Drop and recreate users table with integer primary key
        Schema::dropIfExists('users');

        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('username', 100);
            $table->string('password', 75);
            $table->string('dni', 9);
            $table->string('email', 75);
            $table->timestamp('email_verified_at')->nullable()->default(null);
        });

        // Add user_id columns back and re-add foreign keys
        Schema::table('students', function (Blueprint $table) {
            $table->unsignedBigInteger('user_id')->index()->nullable();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
        Schema::table('admins', function (Blueprint $table) {
            $table->unsignedBigInteger('user_id')->index()->nullable();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
        Schema::table('recruiters', function (Blueprint $table) {
            $table->unsignedBigInteger('user_id')->index()->nullable();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
        Schema::table('oauth_auth_codes', function (Blueprint $table) {
            $table->unsignedBigInteger('user_id')->index()->nullable();
        });
        Schema::table('oauth_access_tokens', function (Blueprint $table) {
            $table->unsignedBigInteger('user_id')->nullable()->index();
        });
        Schema::table('oauth_clients', function (Blueprint $table) {
            $table->unsignedBigInteger('user_id')->nullable()->index();
        });
    }
};
