<?php

namespace App\DataTransferObjects;

use Carbon\CarbonImmutable;

final readonly class CalendarTaskDto
{
    public function __construct(
        public string $name,
        public ?string $description,
        public CarbonImmutable $dueDate,
    ) {}
}
