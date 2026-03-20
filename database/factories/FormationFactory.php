<?php

namespace Database\Factories;

use App\Models\Formation;
use App\Models\Role;
use App\Models\Theme;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class FormationFactory extends Factory
{
    protected $model = Formation::class;

    public function definition(): array
    {
        $startDate = $this->faker->dateTimeBetween('now', '+3 months');
        $endDate = $this->faker->dateTimeBetween($startDate, '+6 months');

        $cdcRole = Role::where('name', 'CDC')->first();

        return [
            'title'       => $this->faker->sentence(4),
            'description' => $this->faker->paragraph(),
            'theme_id'    => Theme::inRandomOrder()->first()?->id ?? Theme::factory(),
            'cdc_id'      => $cdcRole
                ? User::where('role_id', $cdcRole->id)->inRandomOrder()->first()?->id ?? User::factory()->cdc()
                : User::factory(),
            'location'    => $this->faker->city(),
            'start_date'  => $startDate,
            'end_date'    => $endDate,
        ];
    }
}
