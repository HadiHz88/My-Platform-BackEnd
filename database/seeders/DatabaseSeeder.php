<?php

namespace Database\Seeders;

use App\Models\Project;
use App\Models\Tag;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
        ]);

        $tags = Tag::factory()->count(10)->create();

        $projects = Project::factory(10)->create();
        $projects->each(function (Project $project) use ($tags) {
            $project->tags()->attach(
                $tags->random(rand(1, 3))->pluck('id'));
        });
    }
}
