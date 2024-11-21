<?php

namespace App\Models;

use Carbon\CarbonImmutable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PublicAccessToken extends Model
{
    use HasFactory;

    protected $fillable = [
        'task_id',
        'token',
        'expires_at',
    ];

    protected $casts = [
        'expires_at' => 'immutable_datetime',
    ];

    public static function generate(Task $task, int $durationInMinutes): self
    {
        return new self([
            'task_id' => $task->id,
            'token' => bin2hex(random_bytes(32)),
            'expires_at' => CarbonImmutable::now()->addMinutes($durationInMinutes),
        ]);
    }

    public function revoke(): void
    {
        $this->delete();
    }

    public function isValid(string $token): bool
    {
        return $this->token === $token && $this->expires_at && $this->expires_at->isFuture();
    }

    public function task(): BelongsTo
    {
        return $this->belongsTo(Task::class);
    }
}
