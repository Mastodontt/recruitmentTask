<?php

namespace App\Enums;

enum TaskStatus: string
{
    case Todo = 'todo';
    case InProgress = 'in_progress';
    case Done = 'done';

    public static function options(): array
    {
        return [
            self::Todo->value => __('tasks.statuses.todo'),
            self::InProgress->value => __('tasks.statuses.in_progress'),
            self::Done->value => __('tasks.statuses.done'),
        ];
    }

    public function label(): string
    {
        return match ($this) {
            self::Todo => __('tasks.statuses.todo'),
            self::InProgress => __('tasks.statuses.in_progress'),
            self::Done => __('tasks.statuses.done'),
        };
    }
}
