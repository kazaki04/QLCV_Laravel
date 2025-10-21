<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\User;

class EmployeeRoleTest extends TestCase
{
    use RefreshDatabase;

    public function test_manager_can_create_employee_with_role()
    {
        $manager = User::factory()->create(['role' => 'manager']);
        $this->actingAs($manager)->post(route('employees.store'), [
            'name' => 'New Employee',
            'email' => 'newemployee@example.com',
            'password' => 'secret123',
            'password_confirmation' => 'secret123',
            'role' => 'employee',
        ])->assertRedirect(route('employees.index'));

        $this->assertDatabaseHas('users', ['email' => 'newemployee@example.com', 'role' => 'employee']);
    }

    public function test_non_manager_cannot_access_create_employee()
    {
        $user = User::factory()->create(['role' => 'employee']);
        $this->actingAs($user)->get(route('employees.create'))->assertStatus(403);
    }
}
