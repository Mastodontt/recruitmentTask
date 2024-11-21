<?php

namespace App\Mail;

use App\Models\Task;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

final class TaskDueTomorrowMail extends Mailable implements ShouldQueue
{
    use Queueable;
    use SerializesModels;

    public function __construct(public Task $task) {}

    public function build()
    {
        return $this->subject('Reminder: Task Due Tomorrow')
            ->view('emails.task_due_tomorrow');
    }
}
