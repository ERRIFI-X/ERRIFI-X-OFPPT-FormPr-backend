<?php

namespace Database\Factories;

use App\Models\Role;
use Illuminate\Database\Eloquent\Factories\Factory;

class RoleFactory extends Factory
{
    protected $model = Role::class;

    public function definition(): array
    {
        $faker = $this->faker ?? (function_exists('fake') ? \fake() : \Faker\Factory::create());

        return [
            'name' => $faker->unique()->randomElement(['Admin', 'CDC', 'Formateur']),
        ];
    }
}
