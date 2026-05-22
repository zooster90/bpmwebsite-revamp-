<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Guard: only create the admin role/user if they don't exist yet
        $adminRole = Role::firstOrCreate(['name' => 'Super Admin']);

        $admin = User::firstOrCreate(
            ['email' => 'admin@builtech.com'],
            [
                'name'     => 'Super Administrator',
                'password' => bcrypt('password123'),
            ]
        );

        if (! $admin->hasRole('Super Admin')) {
            $admin->assignRole($adminRole);
        }

        // Universal Content Migration Seeder (Ingests all legacy JSON records)
        $this->call([
            UniversalDataSeeder::class,
        ]);
    }
}
