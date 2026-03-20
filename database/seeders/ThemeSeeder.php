<?php

namespace Database\Seeders;

use App\Models\Theme;
use Illuminate\Database\Seeder;

class ThemeSeeder extends Seeder
{
    public function run(): void
    {
        $themes = [
            ['title' => 'Bureautique et Informatique',   'description' => 'Formations relatives aux outils bureautiques et aux technologies informatiques.'],
            ['title' => 'Management et Leadership',       'description' => 'Développement des compétences managériales et de leadership.'],
            ['title' => 'Communication professionnelle',  'description' => 'Amélioration des techniques de communication en milieu professionnel.'],
            ['title' => 'Sécurité et Hygiène',           'description' => 'Formations sur les règles de sécurité et d\'hygiène au travail.'],
            ['title' => 'Développement personnel',        'description' => 'Renforcement des compétences personnelles et comportementales.'],
            ['title' => 'Langues étrangères',             'description' => 'Apprentissage et perfectionnement des langues étrangères.'],
            ['title' => 'Techniques pédagogiques',        'description' => 'Perfectionnement des méthodes d\'enseignement et de formation.'],
            ['title' => 'Numérique et Innovation',        'description' => 'Adaptation aux nouvelles technologies et aux outils numériques.'],
        ];

        $formations = \App\Models\Formation::all();
        if ($formations->isEmpty()) {
            return;
        }

        foreach ($themes as $index => $theme) {
            Theme::firstOrCreate(
                ['title' => $theme['title']],
                array_merge($theme, [
                    'formation_id' => $formations[$index % $formations->count()]->id,
                ])
            );
        }
    }
}
