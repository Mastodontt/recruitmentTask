<?php

namespace App\Models;

use App\Enums\TaskPriority;
use App\Enums\TaskStatus;
use Carbon\CarbonImmutable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'priority',
        'status',
        'due_date',
    ];

    protected $casts = [
        'priority' => TaskPriority::class,
        'status' => TaskStatus::class,
        'due_date' => 'immutable_datetime',
    ];

    public static function createIt(
        string $name,
        ?string $description,
        TaskPriority $priority,
        TaskStatus $status,
        CarbonImmutable $dueDate
    ): self {
        return new self([
            'name' => $name,
            'description' => $description,
            'priority' => $priority,
            'status' => $status,
            'due_date' => $dueDate,
        ]);
    }

    public function setName(string $name): void
    {
        if ($this->name === $name) {
            return;
        }

        $this->name = $name;
    }

    public function setDescription(?string $description): void
    {
        if ($this->description === $description) {
            return;
        }

        $this->description = $description;
    }

    public function setPriority(TaskPriority $priority): void
    {
        if ($this->priority === $priority) {
            return;
        }

        $this->priority = $priority;
    }

    public function setTaskStatus(TaskStatus $status): void
    {
        if ($this->status === $status) {
            return;
        }

        $this->status = $status;
    }

    public function setDueDate(CarbonImmutable $dueDate): void
    {
        if ($this->due_date->eq($dueDate)) {
            return;
        }

        $this->due_date = $dueDate;
    }
}
