<?php

namespace Tests\Feature;

use App\Enums\TaskPriority;
use App\Enums\TaskStatus;
use App\Models\Task;
use App\Models\User;
use Carbon\CarbonImmutable;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class TaskControllerTest extends TestCase
{
    use RefreshDatabase;

    protected function authenticate(): void
    {
        $user = User::factory()->create();
        $this->actingAs($user);
    }

    public function testItCanDisplayTaskIndex(): void
    {
        $this->authenticate();

        Task::factory()->count(15)->create();

        $this->get(route('tasks.index'))
            ->assertOk()
            ->assertViewHas('tasks');
    }

    public function testItCanDisplayTaskCreationForm(): void
    {
        $this->authenticate();

        $this->get(route('tasks.create'))
            ->assertOk()
            ->assertViewIs('tasks.create');
    }

    public function testItCanStoreANewTask(): void
    {
        $this->authenticate();

        $data = [
            'name' => 'New Task',
            'description' => 'Task description',
            'priority' => TaskPriority::Low->value,
            'status' => TaskStatus::InProgress->value,
            'due_date' => CarbonImmutable::now()->addDays(7)->format('Y-m-d H:i:s'),
        ];

        $this->post(route('tasks.store'), $data)
            ->assertRedirect(route('tasks.index'))
            ->assertSessionHas('success', 'Task created successfully.');

        $this->assertDatabaseHas('tasks', [
            'name' => 'New Task',
            'description' => 'Task description',
        ]);
    }

    public function testItCanDisplayTaskEditForm(): void
    {
        $this->authenticate();

        $task = Task::factory()->create();

        $this->get(route('tasks.edit', $task))
            ->assertOk()
            ->assertViewIs('tasks.edit')
            ->assertViewHas('task', $task);
    }

    public function testItCanUpdateATask(): void
    {
        $this->authenticate();

        $task = Task::factory()->create([
            'name' => 'Old Task Name',
        ]);

        $data = [
            'name' => 'Updated Task Name',
            'description' => $task->description,
            'priority' => $task->priority->value,
            'status' => $task->status->value,
            'due_date' => $task->due_date->format('Y-m-d H:i:s'),
        ];

        $this->put(route('tasks.update', $task), $data)
            ->assertRedirect(route('tasks.index'))
            ->assertSessionHas('success', 'Task updated successfully.');

        $this->assertDatabaseHas('tasks', [
            'id' => $task->id,
            'name' => 'Updated Task Name',
        ]);
    }

    public function testItCanDeleteATask(): void
    {
        $this->authenticate();

        $task = Task::factory()->create();

        $this->delete(route('tasks.destroy', $task))
            ->assertRedirect(route('tasks.index'))
            ->assertSessionHas('success', 'Task deleted successfully.');

        $this->assertDatabaseMissing('tasks', [
            'id' => $task->id,
        ]);
    }
}
