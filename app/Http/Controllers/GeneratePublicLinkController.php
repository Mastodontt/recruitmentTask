<?php

namespace App\Http\Controllers;

use App\Models\PublicAccessToken;
use App\Models\Task;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\RedirectResponse;

final class GeneratePublicLinkController
{
    use AuthorizesRequests;

    public function __invoke(Task $task): RedirectResponse
    {
        $this->authorize('update', $task);

        if ($task->publicAccessToken) {
            $task->publicAccessToken->revoke();
        }

        $publicAccessToken = PublicAccessToken::generate($task, 60);
        $publicAccessToken->save();

        return redirect()->route('tasks.index')->with('success', 'Public link generated.');
    }
}
