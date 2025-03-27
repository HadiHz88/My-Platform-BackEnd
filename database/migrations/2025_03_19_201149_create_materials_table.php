<?php

use App\Models\Course;
use App\Models\Topic;
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
        Schema::create('materials', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Topic::class)->constrained()->cascadeOnDelete();
            $table->string('title');
            $table->string('description')->nullable();
            $table->enum('language', ['en', 'fr', 'ar'])->default('en');
            $table->enum('type', ['video', 'image', 'pdf', 'link', 'code', 'markdown', 'other'])->default('other');
            $table->string('url');
            $table->unsignedInteger('order')->default(1);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('materials');
    }
};
