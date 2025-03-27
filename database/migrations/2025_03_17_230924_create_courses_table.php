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
        Schema::create('courses', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('code');
            $table->string('description')->nullable();
            $table->integer('credits');
            $table->enum('difficulty', ['easy', 'normal', 'hard']);
            $table->string('image')->nullable();
            $table->enum('origin', ['Lebanese University', 'Personal', 'Other']);
            $table->integer('semester')->unsigned()->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('courses');
    }
};
