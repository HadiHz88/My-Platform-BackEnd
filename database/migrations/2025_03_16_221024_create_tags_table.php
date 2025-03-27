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
        Schema::create('tags', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique();
            $table->boolean('is_skill')->default(false);
            $table->string('color')->nullable();
            $table->string('icon')->nullable();
            $table->enum('category', ['Programming Languages', 'Frontend Frameworks', 'Backend Frameworks',
                'Mobile Development', 'Databases', 'Cloud Technologies', 'Testing and CI/CD', 'Tools', 'Other'])->default('Other');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tags');
    }
};
