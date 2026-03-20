<?php

namespace Database\Factories;

use App\Models\Absence;
use App\Models\Participant;
use App\Models\Session;
use Illuminate\Database\Eloquent\Factories\Factory;

class AbsenceFactory extends Factory
{
    protected $model = Absence::class;

    public function definition(): array
    {
        $participant = Participant::inRandomOrder()->first() ?? Participant::factory()->create();
        return [
            'user_id'    => $participant->user_id,
            'theme_id'   => $participant->theme_id,
            'session_id'     => Session::inRandomOrder()->first()?->id ?? Session::factory(),
            'date'           => $this->faker->dateTimeBetween('-1 month', 'now'),
            'reason'         => $this->faker->optional()->sentence(),
        ];
    }
}
