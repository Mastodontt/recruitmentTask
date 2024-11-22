<?php

namespace App\Services;

use App\Contracts\CalendarServiceContract;
use App\DataTransferObjects\CalendarTaskDto;
use Spatie\GoogleCalendar\Event;

final readonly class GoogleCalendarService implements CalendarServiceContract
{
    public function createEvent(CalendarTaskDto $event): string
    {
        $googleEvent = Event::create([
            'name' => $event->name,
            'description' => $event->description,
            'startDateTime' => $event->dueDate,
            'endDateTime' => $event->dueDate,
        ]);

        return $googleEvent->id;
    }
}
