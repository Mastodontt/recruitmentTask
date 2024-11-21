<?php

namespace Tests\Unit;

use App\Enums\TaskPriority;
use App\Enums\TaskStatus;
use App\Models\Task;
use App\Models\User;
use Carbon\CarbonImmutable;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class TaskTest extends TestCase
{
    use RefreshDatabase;

    public function testItCanCreateTask(): void
    {
        $name = 'Test Task';
        $description = 'This is a test task.';
        $priority = TaskPriority::Low;
        $status = TaskStatus::InProgress;
        $user = User::factory()->create();
        $dueDate = CarbonImmutable::now()->addDays(5);

        $task = Task::createIt(
            $name,
            $description,
            $priority,
            $status,
            $dueDate,
            $user
        );

        $task->save();

        $this->assertDatabaseHas('tasks', [
            'name' => $name,
            'description' => $description,
            'priority' => $priority->value,
            'status' => $status->value,
            'due_date' => $dueDate->format('Y-m-d H:i:s'),
        ]);
    }

    public function testItCanSetAndGetName(): void
    {
        $task = Task::factory()->create();
        $newName = 'Updated Task Name';

        $task->setName($newName);
        $task->save();

        $this->assertEquals($newName, $task->refresh()->name);
    }

    public function testItCanSetAndGetDescription(): void
    {
        $task = Task::factory()->create();
        $newDescription = 'Updated description.';

        $task->setDescription($newDescription);
        $task->save();

        $this->assertEquals($newDescription, $task->refresh()->description);
    }

    public function testItCanSetAndGetPriority(): void
    {
        $task = Task::factory()->create();
        $newPriority = TaskPriority::High;

        $task->setPriority($newPriority);
        $task->save();

        $this->assertEquals($newPriority, $task->refresh()->priority);
    }

    public function testItCanSetAndGetStatus(): void
    {
        $task = Task::factory()->create();
        $newStatus = TaskStatus::Done;

        $task->setTaskStatus($newStatus);
        $task->save();

        $this->assertEquals($newStatus, $task->refresh()->status);
    }

    public function testItCanSetAndGetDueDate(): void
    {
        $task = Task::factory()->create();
        $newDueDate = CarbonImmutable::now()->addDays(10);

        $task->setDueDate($newDueDate);
        $task->save();

        $retrievedDueDate = $task->refresh()->due_date;

        $this->assertTrue($newDueDate->format('Y-m-d H:i:s') === $retrievedDueDate->format('Y-m-d H:i:s'));
    }
}
