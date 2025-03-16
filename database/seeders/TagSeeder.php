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
            // Programming Languages
            ['name' => 'Java', 'icon' => 'fab fa-java', 'color' => '#f89820'],
            ['name' => 'C#', 'icon' => 'fab fa-microsoft', 'color' => '#68217a'],
            ['name' => 'JavaScript', 'icon' => 'fab fa-js', 'color' => '#f0db4f'],
            ['name' => 'Python', 'icon' => 'fab fa-python', 'color' => '#306998'],
            ['name' => 'PHP', 'icon' => 'fab fa-php', 'color' => '#8e44ad'],
            ['name' => 'Ruby', 'icon' => 'fab fa-ruby', 'color' => '#e21121'],
            ['name' => 'Go', 'icon' => 'fab fa-go', 'color' => '#00ADD8'],
            ['name' => 'Swift', 'icon' => 'fab fa-swift', 'color' => '#f05138'],
            ['name' => 'C++', 'icon' => 'fab fa-cuttlefish', 'color' => '#f34b7d'],
            ['name' => 'Rust', 'icon' => 'fab fa-rust', 'color' => '#000000'],
            ['name' => 'Kotlin', 'icon' => 'fab fa-kotlin', 'color' => '#7f52ff'],
            ['name' => 'TypeScript', 'icon' => 'fab fa-js-square', 'color' => '#3178c6'],
            ['name' => 'HTML5', 'icon' => 'fab fa-html5', 'color' => '#e34f26'],
            ['name' => 'CSS3', 'icon' => 'fab fa-css3-alt', 'color' => '#2965f1'],

            // Frontend Frameworks
            ['name' => 'React', 'icon' => 'fab fa-react', 'color' => '#61dafb'],
            ['name' => 'Vue.js', 'icon' => 'fab fa-vuejs', 'color' => '#42b883'],
            ['name' => 'Angular', 'icon' => 'fab fa-angular', 'color' => '#dd1b16'],
            ['name' => 'Svelte', 'icon' => 'fas fa-rocket', 'color' => '#ff3e00'],

            // Backend Frameworks
            ['name' => 'Laravel', 'icon' => 'fab fa-laravel', 'color' => '#ff2d20'],
            ['name' => 'Django', 'icon' => 'fab fa-python', 'color' => '#092e20'],
            ['name' => 'Ruby on Rails', 'icon' => 'fab fa-ruby', 'color' => '#e21121'],
            ['name' => 'ASP.NET', 'icon' => 'fab fa-microsoft', 'color' => '#512BD4'],
            ['name' => 'Node.js', 'icon' => 'fab fa-node', 'color' => '#8cc84b'],
            ['name' => 'Express.js', 'icon' => 'fab fa-node', 'color' => '#000000'],

            // Mobile Development
            ['name' => 'Flutter', 'icon' => 'fab fa-flutter', 'color' => '#02569b'],
            ['name' => 'React Native', 'icon' => 'fab fa-react', 'color' => '#61dafb'],
            ['name' => 'Xamarin', 'icon' => 'fab fa-microsoft', 'color' => '#0078d4'],

            // Databases
            ['name' => 'MySQL', 'icon' => 'fab fa-mysql', 'color' => '#4479a1'],
            ['name' => 'MongoDB', 'icon' => 'fab fa-database', 'color' => '#4db33d'],
            ['name' => 'PostgreSQL', 'icon' => 'fab fa-database', 'color' => '#336791'],
            ['name' => 'SQLite', 'icon' => 'fab fa-database', 'color' => '#003b57'],

            // DevOps / Cloud Technologies
            ['name' => 'Docker', 'icon' => 'fab fa-docker', 'color' => '#2496ed'],
            ['name' => 'AWS', 'icon' => 'fab fa-amazon', 'color' => '#ff9900'],
            ['name' => 'Azure', 'icon' => 'fab fa-microsoft', 'color' => '#0084c7'],
            ['name' => 'Google Cloud', 'icon' => 'fab fa-google', 'color' => '#4285f4'],

            // Testing and CI/CD
            ['name' => 'Jest', 'icon' => 'fab fa-js-square', 'color' => '#c7e200'],
            ['name' => 'Cypress', 'icon' => 'fab fa-npm', 'color' => '#17202c'],
            ['name' => 'GitHub Actions', 'icon' => 'fab fa-github', 'color' => '#24292f'],
            ['name' => 'Travis CI', 'icon' => 'fab fa-travis', 'color' => '#3eaa5f'],

            // Tools and Other
            ['name' => 'Git', 'icon' => 'fab fa-git', 'color' => '#f14e32'],
            ['name' => 'GitHub', 'icon' => 'fab fa-github', 'color' => '#24292f'],
            ['name' => 'Bitbucket', 'icon' => 'fab fa-bitbucket', 'color' => '#0052cc'],
            ['name' => 'VSCode', 'icon' => 'fab fa-vscode', 'color' => '#007acc'],
            ['name' => 'Slack', 'icon' => 'fab fa-slack', 'color' => '#4a154b'],
            ['name' => 'Figma', 'icon' => 'fab fa-figma', 'color' => '#f24e1e'],
            ['name' => 'Docker', 'icon' => 'fab fa-docker', 'color' => '#2496ed'],
            ['name' => 'Postman', 'icon' => 'fab fa-postman', 'color' => '#ff6c37'],
        ];

        foreach ($tags as $tag) {
            Tag::firstOrCreate(['name' => $tag['name']], $tag);
        }
    }
}
