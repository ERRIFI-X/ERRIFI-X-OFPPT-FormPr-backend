<?php

namespace Database\Factories;

use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;

class UserFactory extends Factory
{
    protected $model = User::class;

    public function definition(): array
    {
        $faker = $this->faker ?? (function_exists('fake') ? \fake() : \Faker\Factory::create());

        return [
            'name'       => $faker->name(),
            'email'      => $faker->unique()->safeEmail(),
            'phone'      => $faker->phoneNumber(),
            'password'   => Hash::make('password'),
            'role_id'    => Role::inRandomOrder()->first()?->id ?? Role::factory(),
        ];
    }

    public function admin(): static
    {
        return $this->state(fn () => [
            'role_id' => Role::where('name', 'Admin')->first()?->id,
        ]);
    }

    public function cdc(): static
    {
        return $this->state(fn () => [
            'role_id' => Role::where('name', 'CDC')->first()?->id,
        ]);
    }

    public function formateur(): static
    {
        return $this->state(fn () => [
            'role_id' => Role::where('name', 'Formateur')->first()?->id,
        ]);
    }
}
