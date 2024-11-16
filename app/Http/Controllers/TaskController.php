<?php

namespace App\Http\Controllers;

use App\Http\Requests\Exercise\TaskCreateRequest;
use App\Http\Requests\Exercise\TaskDestroyRequest;
use App\Http\Requests\Exercise\TaskEditRequest;
use App\Http\Requests\Exercise\TaskStoreRequest;
use App\Http\Requests\Exercise\TaskUpdateRequest;
use App\Http\Requests\Invoice\TaskIndexRequest;
use App\Models\Task;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class TaskController extends Controller
{
    public function index(TaskIndexRequest $request): View
    {
        $tasks = $request->filter()->paginate(10);

        return view('tasks.index', compact('tasks'));
    }

    public function create(TaskCreateRequest $request): View
    {
        return view('tasks.create');
    }

    public function store(TaskStoreRequest $request): RedirectResponse
    {
        $task = Task::create($request->validated());

        return redirect()->route('tasks.index')->with('success', 'Task created successfully.');
    }

    public function edit(TaskEditRequest $request, Task $task): View
    {
        return view('tasks.edit', compact('task'));
    }

    public function update(TaskUpdateRequest $request, Task $task): RedirectResponse
    {
        $task->update($request->validated());

        return redirect()->route('tasks.index')->with('success', 'Task updated successfully.');
    }

    public function destroy(TaskDestroyRequest $task): RedirectResponse
    {
        $task->delete();

        return redirect()->route('tasks.index')->with('success', 'Task deleted successfully.');
    }
}
