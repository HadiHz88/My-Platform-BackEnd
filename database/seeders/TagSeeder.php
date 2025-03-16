<?php

namespace Database\Seeders;

use App\Models\Tag;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TagSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $tags = [
            ['name' => 'Java', 'icon' => 'fab fa-java', 'color' => '#f89820'],
            ['name' => 'C#', 'icon' => 'fab fa-microsoft', 'color' => '#68217a'],
            ['name' => 'Frontend', 'icon' => 'fas fa-code', 'color' => '#facc15'],
            ['name' => 'Backend', 'icon' => 'fas fa-server', 'color' => '#3b82f6'],
            ['name' => 'Mobile', 'icon' => 'fas fa-mobile-alt', 'color' => '#10b981'],
        ];

        foreach ($tags as $tag) {
            Tag::firstOrCreate(['name' => $tag['name']], $tag);
        }

        // Generate additional random test tags
        Tag::factory()->count(10)->create();
    }
}
