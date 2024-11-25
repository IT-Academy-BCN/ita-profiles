<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('messages', function (Blueprint $table) {
            $table->uuid();
            $table->uuid('sender');
            $table->uuid('receiver');
            $table->boolean('read')->default(false);
            $table->string('subject');
            $table->text('body');
            $table->timestamps();

            $table->foreign('sender')->references('id')->on('users')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('receiver')->references('id')->on('users')->onDelete('cascade')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('messages');
    }
};
