<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RolePermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Reset cached roles and permissions
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        // Create basic roles
        Role::firstOrCreate(['name' => 'guest']);
        Role::firstOrCreate(['name' => 'pro']);
        $adminRole = Role::firstOrCreate(['name' => 'admin']);

        // Create a default admin user
        $adminUser = \App\Models\User::firstOrCreate(
            ['email' => 'admin@niholo.com'],
            [
                'name' => 'Niholo Admin',
                'password' => \Illuminate\Support\Facades\Hash::make('password'),
            ]
        );

        if (!$adminUser->hasRole('admin')) {
            $adminUser->assignRole($adminRole);
        }
    }
}
