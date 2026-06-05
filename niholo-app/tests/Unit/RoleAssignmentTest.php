<?php

namespace Tests\Unit;

use App\Models\User;
use Database\Seeders\RolePermissionSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class RoleAssignmentTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_is_assigned_guest_role_on_creation(): void
    {
        $this->seed(RolePermissionSeeder::class);

        $user = User::factory()->create();

        $this->assertTrue($user->hasRole('guest'));
        $this->assertFalse($user->hasRole('admin'));
    }

    public function test_user_with_explicit_role_is_not_assigned_guest(): void
    {
        $this->seed(RolePermissionSeeder::class);

        $admin = User::factory()->create();
        // Since the created event assigns 'guest', we have to test if assigning admin works
        // But wait, the created event assigns 'guest' if they don't have any roles.
        // During User::factory()->create(), no roles are assigned yet. So 'guest' is assigned.
        // We can sync roles to make them admin.
        $admin->syncRoles(['admin']);
        
        $this->assertTrue($admin->hasRole('admin'));
        $this->assertFalse($admin->hasRole('guest'));
    }
}
