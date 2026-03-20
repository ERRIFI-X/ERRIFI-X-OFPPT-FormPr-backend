<?php

namespace Database\Factories;

use App\Models\Formation;
use App\Models\Session;
use Illuminate\Database\Eloquent\Factories\Factory;

class SessionFactory extends Factory
{
    protected $model = Session::class;

    public function definition(): array
    {
        $startTime = $this->faker->time('H:i');
        $endTime = date('H:i', strtotime($startTime . ' +2 hours'));

        return [
            'formation_id' => Formation::inRandomOrder()->first()?->id ?? Formation::factory(),
            'title'        => 'Session : ' . $this->faker->sentence(3),
            'date'         => $this->faker->dateTimeBetween('now', '+3 months'),
            'start_time'   => $startTime,
            'end_time'     => $endTime,
            'location'     => $this->faker->optional()->city(),
        ];
    }
}
