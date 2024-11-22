<?php

namespace Tests\Feature;

use App\Contracts\CalendarServiceContract;
use App\Models\Task;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class SyncTaskWithCalendarControllerTest extends TestCase
{
    use RefreshDatabase;

    protected function authenticate(): void
    {
        $user = User::factory()->create();
        $this->actingAs($user);
    }

    public function testItSyncsTaskWithCalendar(): void
    {
        $this->authenticate();

        $mockCalendarService = \Mockery::mock(CalendarServiceContract::class);

        $mockCalendarService->shouldReceive('createEvent')
            ->once()
            ->andReturn('12345');

        $this->app->instance(CalendarServiceContract::class, $mockCalendarService);

        $task = Task::factory()->create();

        $this->post(route('tasks.sync-calendar', $task))
            ->assertRedirect(route('tasks.index'))
            ->assertSessionHas('success', 'Task synced successfully.');

        $this->assertDatabaseHas('tasks', [
            'id' => $task->id,
            'calendar_event_id' => '12345',
        ]);
    }

    public function testItHandlesCalendarServiceFailure(): void
    {
        $this->authenticate();

        $mockCalendarService = \Mockery::mock(CalendarServiceContract::class);

        $mockCalendarService->shouldReceive('createEvent')
            ->once()
            ->andThrow(new \Exception('Test exception'));

        $this->app->instance(CalendarServiceContract::class, $mockCalendarService);

        $task = Task::factory()->create();

        $this->post(route('tasks.sync-calendar', $task))
            ->assertRedirect()
            ->assertSessionHas('error', 'Failed to sync task with calendar.');

        $this->assertDatabaseMissing('tasks', [
            'id' => $task->id,
            'calendar_event_id' => '12345',
        ]);
    }
}
