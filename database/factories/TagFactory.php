<?php

namespace Database\Factories;

use App\Models\Tag;
use Illuminate\Database\Eloquent\Factories\Factory;

class TagFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Tag::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     * @throws \Exception
     */
    public function definition(): array
    {
        $tags = [
            // Programming Languages
            ['name' => 'Java', 'icon' => 'fab fa-java', 'color' => '#f89820', 'category' => 'Programming Languages'],
            ['name' => 'C#', 'icon' => 'fab fa-microsoft', 'color' => '#68217a', 'category' => 'Programming Languages'],
            ['name' => 'JavaScript', 'icon' => 'fab fa-js', 'color' => '#f0db4f', 'category' => 'Programming Languages'],
            ['name' => 'Python', 'icon' => 'fab fa-python', 'color' => '#306998', 'category' => 'Programming Languages'],
            ['name' => 'PHP', 'icon' => 'fab fa-php', 'color' => '#8e44ad', 'category' => 'Programming Languages'],
            ['name' => 'Ruby', 'icon' => 'fab fa-ruby', 'color' => '#e21121', 'category' => 'Programming Languages'],
            ['name' => 'Go', 'icon' => 'fab fa-go', 'color' => '#00ADD8', 'category' => 'Programming Languages'],
            ['name' => 'Swift', 'icon' => 'fab fa-swift', 'color' => '#f05138', 'category' => 'Programming Languages'],
            ['name' => 'C++', 'icon' => 'fab fa-cuttlefish', 'color' => '#f34b7d', 'category' => 'Programming Languages'],
            ['name' => 'Rust', 'icon' => 'fab fa-rust', 'color' => '#000000', 'category' => 'Programming Languages'],
            ['name' => 'Kotlin', 'icon' => 'fab fa-kotlin', 'color' => '#7f52ff', 'category' => 'Programming Languages'],
            ['name' => 'TypeScript', 'icon' => 'fab fa-js-square', 'color' => '#3178c6', 'category' => 'Programming Languages'],
            ['name' => 'HTML5', 'icon' => 'fab fa-html5', 'color' => '#e34f26', 'category' => 'Programming Languages'],
            ['name' => 'CSS3', 'icon' => 'fab fa-css3-alt', 'color' => '#2965f1', 'category' => 'Programming Languages'],

            // Frontend Frameworks
            ['name' => 'React', 'icon' => 'fab fa-react', 'color' => '#61dafb', 'category' => 'Frontend Frameworks'],
            ['name' => 'Vue.js', 'icon' => 'fab fa-vuejs', 'color' => '#42b883', 'category' => 'Frontend Frameworks'],
            ['name' => 'Angular', 'icon' => 'fab fa-angular', 'color' => '#dd1b16', 'category' => 'Frontend Frameworks'],
            ['name' => 'Svelte', 'icon' => 'fas fa-rocket', 'color' => '#ff3e00', 'category' => 'Frontend Frameworks'],

            // Backend Frameworks
            ['name' => 'Laravel', 'icon' => 'fab fa-laravel', 'color' => '#ff2d20', 'category' => 'Backend Frameworks'],
            ['name' => 'Django', 'icon' => 'fab fa-python', 'color' => '#092e20', 'category' => 'Backend Frameworks'],
            ['name' => 'Ruby on Rails', 'icon' => 'fab fa-ruby', 'color' => '#e21121', 'category' => 'Backend Frameworks'],
            ['name' => 'ASP.NET', 'icon' => 'fab fa-microsoft', 'color' => '#512BD4', 'category' => 'Backend Frameworks'],
            ['name' => 'Node.js', 'icon' => 'fab fa-node', 'color' => '#8cc84b', 'category' => 'Backend Frameworks'],
            ['name' => 'Express.js', 'icon' => 'fab fa-node', 'color' => '#000000', 'category' => 'Backend Frameworks'],

            // Mobile Development
            ['name' => 'Flutter', 'icon' => 'fab fa-flutter', 'color' => '#02569b', 'category' => 'Mobile Development'],
            ['name' => 'React Native', 'icon' => 'fab fa-react', 'color' => '#61dafb', 'category' => 'Mobile Development'],
            ['name' => 'Xamarin', 'icon' => 'fab fa-microsoft', 'color' => '#0078d4', 'category' => 'Mobile Development'],

            // Databases
            ['name' => 'MySQL', 'icon' => 'fab fa-mysql', 'color' => '#4479a1', 'category' => 'Databases'],
            ['name' => 'MongoDB', 'icon' => 'fab fa-database', 'color' => '#4db33d', 'category' => 'Databases'],
            ['name' => 'PostgreSQL', 'icon' => 'fab fa-database', 'color' => '#336791', 'category' => 'Databases'],
            ['name' => 'SQLite', 'icon' => 'fab fa-database', 'color' => '#003b57', 'category' => 'Databases'],

            // DevOps / Cloud Technologies
            ['name' => 'Docker', 'icon' => 'fab fa-docker', 'color' => '#2496ed', 'category' => 'Cloud Technologies'],
            ['name' => 'AWS', 'icon' => 'fab fa-amazon', 'color' => '#ff9900', 'category' => 'Cloud Technologies'],
            ['name' => 'Azure', 'icon' => 'fab fa-microsoft', 'color' => '#0084c7', 'category' => 'Cloud Technologies'],
            ['name' => 'Google Cloud', 'icon' => 'fab fa-google', 'color' => '#4285f4', 'category' => 'Cloud Technologies'],

            // Testing and CI/CD
            ['name' => 'Jest', 'icon' => 'fab fa-js-square', 'color' => '#c7e200', 'category' => 'Testing and CI/CD'],
            ['name' => 'Cypress', 'icon' => 'fab fa-npm', 'color' => '#17202c', 'category' => 'Testing and CI/CD'],
            ['name' => 'GitHub Actions', 'icon' => 'fab fa-github', 'color' => '#24292f', 'category' => 'Testing and CI/CD'],
            ['name' => 'Travis CI', 'icon' => 'fab fa-travis', 'color' => '#3eaa5f', 'category' => 'Testing and CI/CD'],

            // Tools and Other
            ['name' => 'Git', 'icon' => 'fab fa-git', 'color' => '#f14e32', 'category' => 'Tools'],
            ['name' => 'GitHub', 'icon' => 'fab fa-github', 'color' => '#24292f', 'category' => 'Tools'],
            ['name' => 'Bitbucket', 'icon' => 'fab fa-bitbucket', 'color' => '#0052cc', 'category' => 'Tools'],
            ['name' => 'VSCode', 'icon' => 'fab fa-vscode', 'color' => '#007acc', 'category' => 'Tools'],
            ['name' => 'Slack', 'icon' => 'fab fa-slack', 'color' => '#4a154b', 'category' => 'Tools'],
            ['name' => 'Figma', 'icon' => 'fab fa-figma', 'color' => '#f24e1e', 'category' => 'Tools'],
            ['name' => 'Docker', 'icon' => 'fab fa-docker', 'color' => '#2496ed', 'category' => 'Tools'],
            ['name' => 'Postman', 'icon' => 'fab fa-postman', 'color' => '#ff6c37', 'category' => 'Tools'],
        ];

        static $usedTags = [];

        $availableTags = array_filter($tags, function($tag) use (&$usedTags) {
            return !in_array($tag['name'], $usedTags);
        });

        if (empty($availableTags)) {
            throw new \Exception('All tags have been used');
        }

        $tag = $this->faker->randomElement($availableTags);
        $usedTags[] = $tag['name'];

        return [
            'name' => $tag['name'],
            'icon' => $tag['icon'],
            'color' => $tag['color'],
            'category' => $tag['category'],
            'is_skill' => $this->faker->boolean()
        ];
    }
}
