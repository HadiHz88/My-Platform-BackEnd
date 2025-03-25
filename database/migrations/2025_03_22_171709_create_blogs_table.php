<?php

use App\Models\Blog;
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
        Schema::create('blogs', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->text('body');
            $table->string('image_url')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Get all blog images from database before dropping the table
        $blogs = DB::table('blogs')->get();

        foreach ($blogs as $blog) {
            if ($blog->image_url) {
                // Ensure we're deleting from storage, not public
                $relativePath = str_replace(asset('storage/'), '', $blog->image_url);
                Storage::disk('public')->delete($relativePath);
            }
        }

        // Drop the table after images are deleted
        Schema::dropIfExists('blogs');
    }
};
