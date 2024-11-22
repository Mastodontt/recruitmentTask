<?php

namespace App\Contracts;

use App\DataTransferObjects\CalendarTaskDto;

interface CalendarServiceContract
{
    public function createEvent(CalendarTaskDto $event): string;
}
