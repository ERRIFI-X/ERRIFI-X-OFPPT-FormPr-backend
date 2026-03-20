<?php

namespace Database\Seeders;

use App\Models\Formation;
use App\Models\Role;
use App\Models\Theme;
use App\Models\User;
use Illuminate\Database\Seeder;

class FormationSeeder extends Seeder
{
    public function run(): void
    {
        $cdcRole = Role::where('name', 'CDC')->first();
        $cdcs    = User::where('role_id', $cdcRole->id)->get();

        if ($cdcs->isEmpty()) {
            return;
        }

        $formations = [
            [
                'title'       => 'Formation Excel Avancé',
                'description' => 'Maîtrise des fonctions avancées de Microsoft Excel.',
                'location'    => 'Casablanca',
                'start_date'  => '2025-04-01',
                'end_date'    => '2025-04-05',
            ],
            [
                'title'       => 'Leadership et Gestion d\'équipe',
                'description' => 'Développer les compétences de leadership et de gestion d\'équipe.',
                'location'    => 'Rabat',
                'start_date'  => '2025-05-10',
                'end_date'    => '2025-05-14',
            ],
            [
                'title'       => 'Communication efficace',
                'description' => 'Techniques de communication efficace en entreprise.',
                'location'    => 'Marrakech',
                'start_date'  => '2025-06-01',
                'end_date'    => '2025-06-03',
            ],
            [
                'title'       => 'Sécurité au travail',
                'description' => 'Règles et bonnes pratiques de sécurité et santé au travail.',
                'location'    => 'Fès',
                'start_date'  => '2025-07-15',
                'end_date'    => '2025-07-17',
            ],
            [
                'title'       => 'Formation en Anglais professionnel',
                'description' => 'Amélioration de l\'anglais dans le cadre professionnel.',
                'location'    => 'Tanger',
                'start_date'  => '2025-08-01',
                'end_date'    => '2025-08-30',
            ],
        ];

        foreach ($formations as $index => $data) {
            Formation::firstOrCreate(
                ['title' => $data['title']],
                array_merge($data, [
                    'cdc_id'   => $cdcs[$index % $cdcs->count()]->id,
                ])
            );
        }
    }
}
