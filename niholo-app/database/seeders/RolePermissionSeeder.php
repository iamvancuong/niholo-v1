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
        Role::firstOrCreate(['name' => 'admin']);

        // Permissions can be added later when we build the CMS or specific features
    }
}
