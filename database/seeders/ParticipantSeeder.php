<?php

namespace Database\Seeders;

use App\Models\Participant;
use Illuminate\Database\Seeder;

class ParticipantSeeder extends Seeder
{
    public function run(): void
    {
        $users = \App\Models\User::all();
        $themes = \App\Models\Theme::all();
        
        if ($users->isEmpty() || $themes->isEmpty()) {
            return;
        }

        $pairs = [];
        foreach ($users as $user) {
            foreach ($themes as $theme) {
                $pairs[] = ['user_id' => $user->id, 'theme_id' => $theme->id];
            }
        }
        
        shuffle($pairs);
        
        // Seed 30 participants
        $participantCount = min(count($pairs), 30);
        for ($i = 0; $i < $participantCount; $i++) {
            Participant::create(array_merge($pairs[$i], [
                'role' => 'participant',
                'status' => 'valide',
            ]));
        }

        // Remove used pairs
        $remainingPairs = array_slice($pairs, $participantCount);
        
        // Seed 40 inscrits
        $inscritCount = min(count($remainingPairs), 40);
        for ($i = 0; $i < $inscritCount; $i++) {
            Participant::create(array_merge($remainingPairs[$i], [
                'role' => 'inscrit',
                'status' => collect(['en_attente', 'valide', 'annule'])->random(),
                'date_inscription' => now(),
            ]));
        }
    }
}
