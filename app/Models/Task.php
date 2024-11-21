<?php

namespace App\Models;

use App\Enums\TaskPriority;
use App\Enums\TaskStatus;
use Carbon\CarbonImmutable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Task extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'priority',
        'status',
        'due_date',
        'notification_sent_at',
        'created_by',
        'updated_by',
    ];

    protected $casts = [
        'priority' => TaskPriority::class,
        'status' => TaskStatus::class,
        'due_date' => 'immutable_datetime',
        'notification_sent_at' => 'immutable_datetime',
    ];

    public static function createIt(
        string $name,
        ?string $description,
        TaskPriority $priority,
        TaskStatus $status,
        CarbonImmutable $dueDate,
        User $user,
    ): self {
        return new self([
            'name' => $name,
            'description' => $description,
            'priority' => $priority,
            'status' => $status,
            'due_date' => $dueDate,
            'created_by' => $user->id,
        ]);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
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

    public function setNotificationSentAt(CarbonImmutable $notificationSentAt): void
    {
        $this->notification_sent_at?->eq($notificationSentAt) ?: $this->notification_sent_at = $notificationSentAt;
    }

    public function setUpdatedBy(User $user): void
    {
        if ($this->updated_by === $user->id) {
            return;
        }

        $this->updated_by = $user->id;
    }
}
