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
            self::Todo->value => __('tasks.priorities.todo'),
            self::InProgress->value => __('tasks.priorities.in_progress'),
            self::Done->value => __('tasks.priorities.done'),
        ];
    }

    public function label(): string
    {
        return match ($this) {
            self::Todo => __('tasks.priorities.todo'),
            self::InProgress => __('tasks.priorities.in_progress'),
            self::Done => __('tasks.priorities.done'),
        };
    }
}
