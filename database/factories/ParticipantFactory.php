<?php

namespace Database\Factories;

use App\Models\Participant;
use App\Models\Theme;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class ParticipantFactory extends Factory
{
    protected $model = Participant::class;

    public function definition(): array
    {
        return [
            'theme_id' => Theme::inRandomOrder()->first()?->id ?? Theme::factory(),
            'user_id'  => User::inRandomOrder()->first()?->id ?? User::factory(),
        ];
    }
}
