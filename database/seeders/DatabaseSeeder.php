<?php

namespace Database\Seeders;

use App\Models\Blog;
use App\Models\Comment;
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
        // Create users
        $admin = User::create([
            'name' => 'Admin User',
            'email' => 'admin@example.com',
            'email_verified_at' => now(),
            'password' => Hash::make('password'),
            'remember_token' => Str::random(10),
            'role' => 'admin',
        ]);

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
    }
}
