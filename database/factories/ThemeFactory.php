<?php

namespace Database\Factories;

use App\Models\Theme;
use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Formation;

class ThemeFactory extends Factory
{
    protected $model = Theme::class;

    public function definition(): array
    {
        $faker = $this->faker ?? (function_exists('fake') ? \fake() : \Faker\Factory::create());

        $themes = [
            'Bureautique et Informatique',
            'Management et Leadership',
            'Communication professionnelle',
            'Sécurité et Hygiène',
            'Développement personnel',
            'Langues étrangères',
            'Techniques pédagogiques',
            'Numérique et Innovation',
        ];

        return [
            'title'        => $faker->unique()->randomElement($themes),
            'description'  => $faker->paragraph(),
            'duration'     => $faker->numberBetween(1, 30),
            'formation_id' => Formation::inRandomOrder()->first()?->id ?? Formation::factory(),
        ];
    }
}
