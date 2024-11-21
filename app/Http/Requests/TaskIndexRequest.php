<?php

namespace App\Http\Requests;

use App\Enums\TaskPriority;
use App\Enums\TaskStatus;
use App\Models\Task;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class TaskIndexRequest extends FilteredRequest
{
    protected function requestRules(): array
    {
        return [
            'priority' => ['nullable', Rule::enum(TaskPriority::class)],
            'status' => ['nullable', Rule::enum(TaskStatus::class)],
            'due_date' => ['nullable', 'array'],
            'due_date.from' => ['nullable', 'date'],
            'due_date.to' => ['nullable', 'date'],
        ];
    }

    public function authorize(): bool
    {
        return true;
    }

    public function applyFilters(Builder $query): Builder
    {
        $this->priority($query);
        $this->status($query);
        $this->dueDate($query);

        return $query;
    }

    public function getBaseQuery(): Builder
    {
        return Task::query()->where('created_by', Auth::user()->id);
    }

    private function status(Builder $query): void
    {
        if (! ($status = $this->input('status'))) {
            return;
        }

        $query->where('status', '=', TaskStatus::from($status));
    }

    private function priority(Builder $query): void
    {
        if (! ($priority = $this->input('priority'))) {
            return;
        }

        $query->where('priority', '=', TaskPriority::from($priority));
    }

    private function dueDate(Builder $query): void
    {
        $from = $this->input('due_date.from');
        $to = $this->input('due_date.to');

        $query->when($from, static fn (Builder $query) => $query->where('due_date', '>=', $from))
            ->when($to, static fn (Builder $query) => $query->where('due_date', '<=', $to))
            ->when($from && $to, static fn (Builder $query) => $query->whereBetween('due_date', [$from, $to]));
    }
}
