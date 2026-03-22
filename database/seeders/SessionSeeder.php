<?php

namespace Database\Seeders;

use App\Models\Formation;
use App\Models\Session;
use Illuminate\Database\Seeder;

class SessionSeeder extends Seeder
{
    public function run(): void
    {
        $formations = Formation::all();

        foreach ($formations as $formation) {
            $themes = $formation->themes;
            if ($themes->isEmpty()) continue;

            $sessionCount = rand(3, 5);
            $baseDate     = $formation->start_date;

            for ($i = 1; $i <= $sessionCount; $i++) {
                $theme = $themes->random();
                Session::firstOrCreate(
                    [
                        'formation_id' => $formation->id,
                        'theme_id'     => $theme->id,
                        'title'        => "Séance {$i} - {$theme->title}",
                    ],
                    [
                        'date'       => $baseDate->copy()->addDays($i - 1),
                        'start_time' => '09:00',
                        'end_time'   => '12:00',
                        'location'   => $formation->location,
                    ]
                );
            }
        }
    }
}
