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
            'title'        => fake()->unique()->randomElement($themes),
            'description'  => fake()->paragraph(),
            'duration'     => fake()->numberBetween(1, 30),
            'formation_id' => Formation::inRandomOrder()->first()?->id ?? Formation::factory(),
        ];
    }
}
