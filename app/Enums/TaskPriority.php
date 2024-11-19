<?php

namespace App\Enums;

enum TaskPriority: string
{
    case Low = 'low';
    case Medium = 'medium';
    case High = 'high';

    public static function options(): array
    {
        return [
            self::Low->value => __('tasks.priorities.low'),
            self::Medium->value => __('tasks.priorities.medium'),
            self::High->value => __('tasks.priorities.high'),
        ];
    }

    public function label(): string
    {
        return match ($this) {
            self::Low => __('tasks.priorities.low'),
            self::Medium => __('tasks.priorities.medium'),
            self::High => __('tasks.priorities.high'),
        };
    }
}
