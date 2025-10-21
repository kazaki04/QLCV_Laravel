<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Mail;
use App\Models\User;
use App\Models\Task;
use App\Mail\TaskAssigned;

class TaskAssignmentTest extends TestCase
{
    use RefreshDatabase;

    public function test_assigning_task_sends_email()
    {
        Mail::fake();
        $manager = User::factory()->create(['role' => 'manager']);
        $employee = User::factory()->create(['role' => 'employee']);

        $this->actingAs($manager)->post(route('tasks.store'), [
            'title' => 'Assigned Task',
            'description' => 'Do this',
            'status' => 'pending',
            'assigned_to' => $employee->id,
        ])->assertRedirect(route('tasks.index'));

        $task = Task::where('title', 'Assigned Task')->first();
        $this->assertNotNull($task);

        Mail::assertSent(TaskAssigned::class, function($mail) use ($employee){
            return $mail->hasTo($employee->email);
        });
    }

    public function test_non_manager_cannot_assign_task()
    {
        $user = User::factory()->create(['role' => 'employee']);
        $employee = User::factory()->create(['role' => 'employee']);

        $this->actingAs($user)->post(route('tasks.store'), [
            'title' => 'Task',
            'status' => 'pending',
            'assigned_to' => $employee->id,
        ])->assertStatus(403);
    }
}
