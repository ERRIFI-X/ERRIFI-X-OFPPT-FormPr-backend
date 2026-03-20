<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        $adminRole     = Role::where('name', 'Admin')->firstOrFail();
        $cdcRole       = Role::where('name', 'CDC')->firstOrFail();
        $formateurRole = Role::where('name', 'Formateur')->firstOrFail();

        // Fixed Admin account
        User::firstOrCreate(
            ['email' => 'admin@ofppt.ma'],
            [
                'name'     => 'Super Admin',
                'password' => Hash::make('password'),
                'role_id'  => $adminRole->id,
            ]
        );

        // Fixed CDC account
        User::firstOrCreate(
            ['email' => 'cdc@ofppt.ma'],
            [
                'name'     => 'CDC Responsable',
                'password' => Hash::make('password'),
                'role_id'  => $cdcRole->id,
            ]
        );

        // Fixed Formateur account
        User::firstOrCreate(
            ['email' => 'formateur@ofppt.ma'],
            [
                'name'     => 'Formateur Principal',
                'password' => Hash::make('password'),
                'role_id'  => $formateurRole->id,
            ]
        );

        // Random CDC users
        User::factory(3)->create(['role_id' => $cdcRole->id]);

        // Random Formateur users
        User::factory(5)->create(['role_id' => $formateurRole->id]);

        // Random participant-level users (no specific role restriction needed)
        User::factory(10)->create(['role_id' => $formateurRole->id]);
    }
}
