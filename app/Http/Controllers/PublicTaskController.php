<?php

namespace App\Http\Controllers;

use App\Models\PublicAccessToken;
use Illuminate\Http\Request;
use Illuminate\View\View;

final class PublicTaskController extends Controller
{
    public function show(Request $request, string $token): View
    {
        $publicAccessToken = PublicAccessToken::query()->where('token', $token)->first();

        if ($publicAccessToken === null) {
            abort(404);
        }

        $task = $publicAccessToken->task;

        return view('tasks.public.show', compact('task'));
    }
}
