<?php

namespace Database\Seeders;

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
        ]);

        $testUser = User::create([
            'name' => 'Test User',
            'email' => 'test@example.com',
            'email_verified_at' => now(),
            'password' => Hash::make('password'),
            'remember_token' => Str::random(10),
        ]);

        // Create tags
        $tags = [
            ['name' => 'Laravel', 'color' => '#FF2D20', 'icon' => 'fab fa-laravel'],
            ['name' => 'React', 'color' => '#61DAFB', 'icon' => 'fab fa-react'],
            ['name' => 'Vue', 'color' => '#42B883', 'icon' => 'fab fa-vuejs'],
            ['name' => 'JavaScript', 'color' => '#F7DF1E', 'icon' => 'fab fa-js'],
            ['name' => 'PHP', 'color' => '#777BB4', 'icon' => 'fab fa-php'],
            ['name' => 'Python', 'color' => '#3776AB', 'icon' => 'fab fa-python'],
            ['name' => 'CSS', 'color' => '#264DE4', 'icon' => 'fab fa-css3-alt'],
            ['name' => 'HTML', 'color' => '#E34F26', 'icon' => 'fab fa-html5'],
            ['name' => 'Database', 'color' => '#336791', 'icon' => 'fas fa-database'],
            ['name' => 'UI/UX', 'color' => '#FF6B6B', 'icon' => 'fas fa-paint-brush'],
            ['name' => 'DevOps', 'color' => '#0DB7ED', 'icon' => 'fas fa-server'],
            ['name' => 'Mobile', 'color' => '#A4C639', 'icon' => 'fas fa-mobile-alt'],
        ];

        $createdTags = [];
        foreach ($tags as $tagData) {
            $createdTags[$tagData['name']] = Tag::create($tagData);
        }

        // Create projects
        $projects = [
            [
                'title' => 'Personal Portfolio',
                'description' => 'A personal portfolio website showcasing my skills and projects.',
                'image_url' => 'https://example.com/portfolio.jpg',
                'github_url' => 'https://github.com/username/portfolio',
                'live_url' => 'https://portfolio.example.com',
                'type' => 'personal',
                'tags' => ['React', 'JavaScript', 'CSS', 'HTML'],
            ],
            [
                'title' => 'E-commerce Platform',
                'description' => 'A full-featured e-commerce platform with user authentication, product management, and payment processing.',
                'image_url' => 'https://example.com/ecommerce.jpg',
                'github_url' => 'https://github.com/username/ecommerce',
                'live_url' => 'https://ecommerce.example.com',
                'type' => 'corporate',
                'tags' => ['Laravel', 'PHP', 'JavaScript', 'Database'],
            ],
            [
                'title' => 'Weather App',
                'description' => 'A simple weather application that fetches and displays weather data from an API.',
                'image_url' => 'https://example.com/weather.jpg',
                'github_url' => 'https://github.com/username/weather-app',
                'live_url' => 'https://weather.example.com',
                'type' => 'mini',
                'tags' => ['Vue', 'JavaScript', 'CSS'],
            ],
            [
                'title' => 'Task Management System',
                'description' => 'A task management system with features like task creation, assignment, and tracking.',
                'image_url' => 'https://example.com/tasks.jpg',
                'github_url' => 'https://github.com/username/task-manager',
                'live_url' => 'https://tasks.example.com',
                'type' => 'corporate',
                'tags' => ['Laravel', 'React', 'Database', 'UI/UX'],
            ],
        ];

        foreach ($projects as $projectData) {
            $tagNames = $projectData['tags'];
            unset($projectData['tags']);

            $project = Project::create($projectData);

            // Attach tags to project
            $tagIds = [];
            foreach ($tagNames as $tagName) {
                if (isset($createdTags[$tagName])) {
                    $tagIds[] = $createdTags[$tagName]->id;
                }
            }
            $project->tags()->sync($tagIds);
        }

        // Create entries (work, education, volunteer)
        $entries = [
            [
                'title' => 'Senior Web Developer',
                'description' => 'Developed and maintained enterprise web applications using Laravel and Vue.js.',
                'organization' => 'Tech Solutions Inc.',
                'location' => 'San Francisco, CA',
                'type' => 'work',
                'start_date' => '2022-01-01',
                'end_date' => null,
            ],
            [
                'title' => 'Web Developer',
                'description' => 'Created responsive web applications and maintained legacy systems.',
                'organization' => 'Digital Agency',
                'location' => 'New York, NY',
                'type' => 'work',
                'start_date' => '2020-03-15',
                'end_date' => '2021-12-31',
            ],
            [
                'title' => 'Computer Science Degree',
                'description' => 'Bachelor of Science in Computer Science',
                'organization' => 'Tech University',
                'location' => 'Boston, MA',
                'type' => 'education',
                'start_date' => '2016-09-01',
                'end_date' => '2020-05-15',
            ],
            [
                'title' => 'Code Mentor',
                'description' => 'Mentored underprivileged youth in coding and web development.',
                'organization' => 'Code for All',
                'location' => 'Online',
                'type' => 'volunteer',
                'start_date' => '2019-06-01',
                'end_date' => '2020-12-31',
            ],
        ];

        foreach ($entries as $entryData) {
            Entry::create($entryData);
        }

        // Create courses
        $courses = [
            [
                'name' => 'Introduction to Programming',
                'code' => 'CS101',
                'difficulty' => 'easy',
                'semester' => 1,
                'credits' => 3,
                'description' => 'An introduction to programming concepts using Python.',
                'tags' => ['Python'],
                'materials' => [
                    [
                        'title' => 'Python Basics',
                        'description' => 'Introduction to Python syntax and basic concepts',
                        'type' => 'pdf',
                        'url' => 'https://example.com/python-basics.pdf',
                    ],
                    [
                        'title' => 'Getting Started with Python',
                        'description' => 'Video tutorial on setting up Python environment',
                        'type' => 'video',
                        'url' => 'https://example.com/python-tutorial.mp4',
                    ],
                ],
            ],
            [
                'name' => 'Web Development Fundamentals',
                'code' => 'WEB201',
                'difficulty' => 'normal',
                'semester' => 2,
                'credits' => 4,
                'description' => 'Learn the basics of web development including HTML, CSS, and JavaScript.',
                'tags' => ['HTML', 'CSS', 'JavaScript'],
                'materials' => [
                    [
                        'title' => 'HTML Structure',
                        'description' => 'Understanding HTML document structure',
                        'type' => 'markdown',
                        'url' => 'https://example.com/html-structure.md',
                    ],
                    [
                        'title' => 'CSS Styling Guide',
                        'description' => 'Guide to CSS styling and layout',
                        'type' => 'link',
                        'url' => 'https://example.com/css-guide',
                    ],
                ],
            ],
            [
                'name' => 'Advanced Database Systems',
                'code' => 'DB301',
                'difficulty' => 'hard',
                'semester' => 3,
                'credits' => 5,
                'description' => 'Advanced concepts in database design, optimization, and management.',
                'tags' => ['Database'],
                'materials' => [
                    [
                        'title' => 'Database Normalization',
                        'description' => 'Understanding database normalization forms',
                        'type' => 'pdf',
                        'url' => 'https://example.com/database-normalization.pdf',
                    ],
                    [
                        'title' => 'Query Optimization Techniques',
                        'description' => 'Code examples for optimizing database queries',
                        'type' => 'code',
                        'url' => 'https://example.com/query-optimization.sql',
                    ],
                ],
            ],
        ];

        foreach ($courses as $courseData) {
            $tagNames = $courseData['tags'];
            $materials = $courseData['materials'];
            unset($courseData['tags'], $courseData['materials']);

            $course = Course::create($courseData);

            // Attach tags to course
            $tagIds = [];
            foreach ($tagNames as $tagName) {
                if (isset($createdTags[$tagName])) {
                    $tagIds[] = $createdTags[$tagName]->id;
                }
            }
            $course->tags()->sync($tagIds);

            // Create materials for course
            foreach ($materials as $materialData) {
                $materialData['course_id'] = $course->id;
                Material::create($materialData);
            }
        }

        // Generate some likes and views
        $likeables = [
            ['type' => Project::class, 'ids' => Project::pluck('id')->toArray()],
            ['type' => Course::class, 'ids' => Course::pluck('id')->toArray()],
        ];

        foreach ($likeables as $likeable) {
            foreach ($likeable['ids'] as $itemId) {
                // Add some likes
                if (rand(0, 1)) {
                    $admin->likes()->create([
                        'likeable_type' => $likeable['type'],
                        'likeable_id' => $itemId,
                    ]);
                }

                if (rand(0, 1)) {
                    $testUser->likes()->create([
                        'likeable_type' => $likeable['type'],
                        'likeable_id' => $itemId,
                    ]);
                }

                // Add some views
                $admin->views()->create([
                    'viewable_type' => $likeable['type'],
                    'viewable_id' => $itemId,
                ]);

                if (rand(0, 1)) {
                    $testUser->views()->create([
                        'viewable_type' => $likeable['type'],
                        'viewable_id' => $itemId,
                    ]);
                }
            }
        }
    }
}
