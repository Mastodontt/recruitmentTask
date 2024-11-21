<?php

namespace App\Http\Controllers;

use App\Models\Task;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\RedirectResponse;

class RevokePublicLinkController
{
    use AuthorizesRequests;

    public function __invoke(Task $task): RedirectResponse
    {
        $this->authorize('update', $task);

        $task->publicAccessToken?->revoke();

        return redirect()->route('tasks.index')->with('success', 'Public link revoked.');
    }
}
