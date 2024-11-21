<?php

namespace App\Console\Commands;

use App\Mail\TaskDueTomorrowMail;
use App\Models\Task;
use Carbon\CarbonImmutable;
use Illuminate\Console\Command;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Mail;

final class SendTaskDueNotifications extends Command
{
    protected $signature = 'tasks:send-due-notifications';

    protected $description = 'Send email notifications for tasks due tomorrow';

    public function handle(): int
    {
        $startOfTomorrow = CarbonImmutable::now()->addDay()->startOfDay();
        $endOfTomorrow = $startOfTomorrow->endOfDay();

        Task::query()
            ->with('user')
            ->whereBetween('due_date', [$startOfTomorrow, $endOfTomorrow])
            ->whereNull('notification_sent_at')
            ->chunk(200, function (Collection $tasks) {
                $tasks->each(function (Task $task) {
                    Mail::to($task->user->email)->queue(new TaskDueTomorrowMail($task));
                    $task->setNotificationSentAt(CarbonImmutable::now());
                    $task->save();
                });
            });

        return Command::SUCCESS;
    }
}
