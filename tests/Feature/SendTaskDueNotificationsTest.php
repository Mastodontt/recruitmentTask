<?php

namespace Tests\Feature;

use App\Mail\TaskDueTomorrowMail;
use App\Models\Task;
use App\Models\User;
use Carbon\CarbonImmutable;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Mail;
use Tests\TestCase;

class SendTaskDueNotificationsTest extends TestCase
{
    use RefreshDatabase;

    public function testItSendsEmailsForTasksDueTomorrow(): void
    {
        Mail::fake();

        $user = User::factory()->create();

        $task = Task::factory()
            ->withDueDate(CarbonImmutable::now()->addDay())
            ->withCreatedBy($user)
            ->create();

        $this->artisan('tasks:send-due-notifications')
            ->assertExitCode(0);

        Mail::assertQueued(
            TaskDueTomorrowMail::class,
            static fn (TaskDueTomorrowMail $mail) => $mail->hasTo($task->user->email) && $mail->task->is($task)
        );

        $this->assertNotNull($task->fresh()->notification_sent_at);
    }

    public function testItDoesNotSendEmailsForTasksNotDueTomorrow(): void
    {
        Mail::fake();

        $user = User::factory()->create();

        $task = Task::factory()
            ->withDueDate(CarbonImmutable::now())
            ->withCreatedBy($user)
            ->create();

        $this->artisan('tasks:send-due-notifications')
            ->assertExitCode(0);

        Mail::assertNotQueued(TaskDueTomorrowMail::class);

        $this->assertNull($task->fresh()->notification_sent_at);
    }
}
