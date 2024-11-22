<?php

namespace App\Http\Controllers;

use App\Contracts\CalendarServiceContract;
use App\DataTransferObjects\CalendarTaskDto;
use App\Models\Task;
use Illuminate\Http\RedirectResponse;

final class SyncTaskWithCalendarController extends Controller
{
    public function __construct(private CalendarServiceContract $calendarService) {}

    public function __invoke(Task $task): RedirectResponse
    {
        if ($task->due_date->isPast()) {
            return redirect()->back()->with('error', 'Task due date is in the past and cannot be synced to the calendar.');
        }

        try {
            $event = new CalendarTaskDto(
                name: $task->name,
                description: $task->description,
                dueDate: $task->due_date
            );

            $calendarEventId = $this->calendarService->createEvent($event);

            $task->setCalendarEventId($calendarEventId);
            $task->saveOrFail();
        } catch (\Throwable $e) {
            return redirect()->back()->with('error', 'Failed to sync task with calendar.');
        }

        return redirect()->route('tasks.index')->with('success', 'Task synced successfully.');
    }
}
