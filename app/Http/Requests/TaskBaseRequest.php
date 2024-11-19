<?php

namespace App\Http\Requests;

use App\Enums\TaskPriority;
use App\Enums\TaskStatus;
use Carbon\CarbonImmutable;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class TaskBaseRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => ['string', 'required', 'max:255'],
            'description' => ['nullable', 'max:10000'],
            'priority' => ['required', Rule::enum(TaskPriority::class)],
            'status' => ['required', Rule::enum(TaskStatus::class)],
            'due_date' => ['required', 'date', 'after_or_equal:today'],
        ];
    }

    public function getName(): string
    {
        return $this->string('name');
    }

    public function getDescription(): ?string
    {
        return $this->input('description') ? $this->string('description') : null;
    }

    public function getPriority(): TaskPriority
    {
        return TaskPriority::from($this->input('priority'));
    }

    public function getStatus(): TaskStatus
    {
        return TaskStatus::from($this->input('status'));
    }

    public function getDueDate(): CarbonImmutable
    {
        return CarbonImmutable::parse($this->input('due_date'));
    }
}
