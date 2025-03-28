<?php

namespace Database\Seeders;

use App\Models\Admin;
use App\Models\Blog;
use App\Models\Comment;
use App\Models\Topic;
use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Project;
use App\Models\Tag;
use App\Models\Entry;
use App\Models\Course;
use App\Models\Material;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Check if admin already exists
        $existingAdmin = Admin::first();

        if (!$existingAdmin) {
            Admin::create([
                'name' => config('app.admin.name'),
                'email' => config('app.admin.email'),
                'password' => Hash::make(config('app.admin.password')),
                'info' => config('app.admin.info'),
                'bio' => config('app.admin.bio'),
                'phone' => config('app.admin.phone'),
                'address' => config('app.admin.address'),
                'facebook_url' => config('app.admin.facebook'),
                'instagram_url' => config('app.admin.instagram'),
                'youtube_url' => config('app.admin.youtube'),
                'linkedin_url' => config('app.admin.linkedin'),
                'github_url' => config('app.admin.github'),
            ]);
        }

        // Create some users
        User::factory(10)->create();

        // Create some tags first
        Tag::factory(10)->create();

        // Create projects and attach random tags
        Project::factory(5)->create();

        // Create some blogs and attach comments
        Blog::factory(5)->create()->each(function (Blog $blog) {
            Comment::factory(rand(2,5))->create([
                'blog_id' => $blog->id,
            ]);
        });

        // Create courses with related topics and materials
        Course::factory(5)->has(
            Topic::factory()->count(rand(2, 5))->has(
                Material::factory()->count(rand(2, 5))
            )
        )->create();

        Entry::factory(7)->create();
    }
}
