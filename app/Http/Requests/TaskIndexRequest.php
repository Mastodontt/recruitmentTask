<?php

namespace App\Http\Requests\Invoice;

use App\Enums\TaskPriority;
use App\Enums\TaskStatus;
use App\Http\Filters\FilteredRequest;
use App\Models\Task;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Validation\Rule;

class TaskIndexRequest extends FilteredRequest
{
    protected function requestRules(): array
    {
        return [
            'priority' => ['sometimes', Rule::enum(TaskPriority::class)],
            'status' => ['sometimes', Rule::enum(TaskStatus::class)],
        ];
    }

    public function authorize(): bool
    {
        return true;
    }

    public function applyFilters(Builder $query): Builder
    {
        return $query;
    }

    public function getBaseQuery(): Builder
    {
        return Task::query();
    }
}
